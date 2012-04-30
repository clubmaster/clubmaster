<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/shop/subscription")
 */
class SubscriptionController extends Controller
{
  /**
   * @Route("/", name="shop_subscription")
   * @Template()
   * @Secure(roles="ROLE_USER")
   *
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $user = $this->get('security.context')->getToken()->getUser();

    $coming = $em->getRepository('ClubShopBundle:Subscription')->getComingSubscriptions($user);
    $active = $em->getRepository('ClubShopBundle:Subscription')->getActiveSubscriptions($user);
    $expired = $em->getRepository('ClubShopBundle:Subscription')->getExpiredSubscriptions($user);

    return array(
      'user' => $user,
      'active' => $active,
      'coming' => $coming,
      'expired' => $expired
    );
  }

  /**
   * @Route("/show/{id}")
   * @Template()
   * @Secure(roles="ROLE_USER")
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
   * @Route("/stop/{id}")
   * @Template()
   * @Secure(roles="ROLE_USER")
   */
  public function stopAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $subscription = $em->find('ClubShopBundle:Subscription', $id);

    $this->get('subscription')->stopSubscription($subscription);
    $this->get('session')->setFlash('notice', $this->get('translator')->trans('Subscription will not be renewed'));

    return $this->redirect($this->generateUrl('shop_subscription'));
  }

  /**
   * @Route("/expire/{id}")
   * @Template()
   * @Secure(roles="ROLE_USER")
   */
  public function expireAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $subscription = $em->find('ClubShopBundle:Subscription', $id);

    $this->get('subscription')->expireSubscription($subscription);

    return $this->redirect($this->generateUrl('shop_subscription'));
  }

  /**
   * @Route("/pause/{id}", name="shop_subscription_pause")
   * @Template()
   * @Secure(roles="ROLE_USER")
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
   * @Route("/resume/{id}", name="shop_subscription_resume")
   * @Template()
   * @Secure(roles="ROLE_USER")
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
