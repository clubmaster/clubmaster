<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SubscriptionController extends Controller
{
  /**
   * @Route("/shop/subscription", name="shop_subscription")
   * @Template()
   */
  public function indexAction()
  {
    $user = $this->get('security.context')->getToken()->getUser();

    return array(
      'user' => $user
    );
  }

  /**
   * @Route("/shop/subscription/pause/{id}", name="shop_subscription_pause")
   * @Template()
   */
  public function pauseAction($id)
  {
    $em = $this->get('doctrine')->getEntityManager();
    $subscription = $em->find('ClubShopBundle:Subscription',$id);

    // validate that the user is allowed to pause
    if (count($subscription->getSubscriptionPauses()) >= $subscription->getAllowedPauses()) {
      $this->get('session')->setFlash('error','You cannot have anymore pauses.');
      return new RedirectResponse($this->generateUrl('shop_subscription'));
    }

    $subscription->setIsActive(0);

    $pause = new \Club\ShopBundle\Entity\SubscriptionPause();
    $pause->setSubscription($subscription);
    $pause->setStartDate(new \DateTime());

    $em->persist($subscription);
    $em->persist($pause);
    $em->flush();

    $this->get('session')->set('notice','Your subscription has been paused.');

    return new RedirectResponse($this->generateUrl('shop_subscription'));
  }

  /**
   * @Route("/shop/subscription/resume/{id}", name="shop_subscription_resume")
   * @Template()
   */
  public function resumeAction($id)
  {
    $em = $this->get('doctrine')->getEntityManager();

    $subscription = $em->find('ClubShopBundle:Subscription',$id);
    $subscription->setIsActive(1);

    $pause = $em->getRepository('ClubShopBundle:Subscription')->getActivePause($subscription);
    $pause->setExpireDate(new \DateTime());

    $diff = $pause->getStartDate()->diff($pause->getExpireDate());
    $new = new \DateTime($subscription->getExpireDate()->format('Y-m-d'));
    $new->add($diff);
    $subscription->setExpireDate($new);

    $em->persist($subscription);
    $em->persist($pause);
    $em->flush();

    return new RedirectResponse($this->generateUrl('shop_subscription'));
  }
}
