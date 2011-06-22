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

    $this->get('subscription')->pauseSubscription($subscription);

    return $this->redirect($this->generateUrl('admin_shop_subscription',array(
      'id' => $subscription->getUser()->getId()
    )));
  }

  /**
   * @Route("/shop/subscription/resume/{id}", name="admin_shop_subscription_resume")
   * @Template()
   */
  public function resumeAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $subscription = $em->find('ClubShopBundle:Subscription',$id);

    $this->get('subscription')->resumeSubscription($subscription);

    return $this->redirect($this->generateUrl('admin_shop_subscription',array(
      'id' => $subscription->getUser()->getId()
    )));
  }

  /**
   * @Route("/shop/subscription/expire/{id}",name="admin_shop_subscription_expire")
   */
  public function expireAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $subscription = $em->find('ClubShopBundle:Subscription',$id);

    $this->get('subscription')->expireSubscription($subscription);

    return $this->redirect($this->generateUrl('admin_shop_subscription',array(
      'id' => $subscription->getUser()->getId()
    )));
  }
}
