<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminSubscriptionController extends Controller
{
  /**
   * @Route("/shop/subscription/{id}", name="admin_shop_subscription")
   * @Template()
   */
  public function indexAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $user = $em->find('ClubUserBundle:User',$id);

    return array(
      'user' => $user
    );
  }

  /**
   * @Route("/shop/subscription/pause/{id}", name="admin_shop_subscription_pause")
   * @Template()
   */
  public function pauseAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $subscription = $em->find('ClubShopBundle:Subscription',$id);

    // validate that the user is allowed to pause
    if (count($subscription->getSubscriptionPauses()) >= $subscription->getAllowedPauses()) {
      $this->get('session')->setFlash('error','You cannot have anymore pauses.');
      return $this->redirect($this->generateUrl('admin_shop_subscription'));
    }

    $subscription->setIsActive(0);

    $pause = new \Club\ShopBundle\Entity\SubscriptionPause();
    $pause->setSubscription($subscription);
    $pause->setStartDate(new \DateTime());

    $em->persist($subscription);
    $em->persist($pause);
    $em->flush();

    $this->get('session')->set('notice','Your subscription has been paused.');

    return $this->redirect($this->generateUrl('admin_shop_subscription'));
  }

  /**
   * @Route("/shop/subscription/resume/{id}", name="admin_shop_subscription_resume")
   * @Template()
   */
  public function resumeAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

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

    return $this->redirect($this->generateUrl('admin_shop_subscription'));
  }

  /**
   * @Route("/shop/subscription/expire/{id}",name="admin_shop_subscription_expire")
   */
  public function expireAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $subscription = $em->find('ClubShopBundle:Subscription',$id);
    $subscription->expire(new \DateTime());

    $em->persist($subscription);
    $em->flush();

    return $this->redirect($this->generateUrl('admin_shop_subscription',array(
      'id' => $subscription->getUser()->getId()
    )));
  }
}
