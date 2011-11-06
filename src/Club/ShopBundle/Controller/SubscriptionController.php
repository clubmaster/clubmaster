<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
   * @Route("/shop/subscription/show/{id}")
   * @Template()
   */
  public function showAction($id)
  {
    $em = $this->getDoctrine();
    $subscription = $em->getRepository('ClubShopBundle:Subscription')->find($id);

    return array(
      'subscription' => $subscription
    );
  }

  /**
   * @Route("/shop/subscription/pause/{id}", name="shop_subscription_pause")
   * @Template()
   */
  public function pauseAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $subscription = $em->find('ClubShopBundle:Subscription',$id);

    $this->validateOwner($subscription);
    $this->get('subscription')->pauseSubscription($subscription);

    return $this->redirect($this->generateUrl('shop_subscription'));
  }

  /**
   * @Route("/shop/subscription/resume/{id}", name="shop_subscription_resume")
   * @Template()
   */
  public function resumeAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $subscription = $em->find('ClubShopBundle:Subscription',$id);

    $this->validateOwner($subscription);
    $this->get('subscription')->resumeSubscription($subscription);

    return $this->redirect($this->generateUrl('shop_subscription'));
  }

  private function validateOwner(\Club\ShopBundle\Entity\Subscription $subscription)
  {
    $user = $this->get('security.context')->getToken()->getUser();

    // FIXME, does security not allowed exception exists
    if ($subscription->getUser()->getId() != $user->getId())
      throw new \Exception('You are not allowed to change this subscription.');
  }
}
