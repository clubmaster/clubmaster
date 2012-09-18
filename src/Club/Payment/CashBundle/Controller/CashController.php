<?php

namespace Club\Payment\CashBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/cash")
 */
class CashController extends Controller
{
    /**
     * @Route("/register/{order_id}")
     * @Route("/register/{order_id}/{allow_split}", name="payment_cash_confirm")
     * @Template()
     */
    public function registerAction($order_id, $allow_split = false)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $order = $em->find('ClubShopBundle:Order', $order_id);

        $payment = $em->getRepository('ClubShopBundle:PaymentMethod')->findOneBy(array(
            'controller' => $this->container->getParameter('club_payment_cash.controller')
        ));
        $log = new \Club\ShopBundle\Entity\PurchaseLog();
        $log->setOrder($order);
        $log->setPaymentMethod($payment);
        $log->setAmount($order->getAmountLeft());
        $log->setAccepted(true);
        $log->setCurrency($order->getCurrency());

        $form = $this->processForm($log, $order, $allow_split);
        if ($form instanceOf RedirectResponse) return $form;

        return array(
            'form' => $form->createView(),
            'order' => $order,
        );
    }

    /**
     * @Route("/confirm/{order_id}/{amount}")
     * @Template()
     */
    public function confirmAction($order_id, $amount)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $order = $em->find('ClubShopBundle:Order', $order_id);

        $log = new \Club\ShopBundle\Entity\PurchaseLog();
        $log->setAmount($amount);

        $form = $this->processForm($log, $order);

        return array(
            'order' => $order,
            'log' => $log,
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/{order_id}")
     * @Template()
     */
    public function indexAction($order_id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $order = $em->find('ClubShopBundle:Order', $order_id);

        return array(
            'order' => $order,
        );
    }

    private function getForm($log)
    {
        $form = $this->createFormBuilder($log)
            ->add('amount')
            ->getForm();

        return $form;
    }

    private function processForm($log, $order, $allow_split = false)
    {
        $form = $this->getForm($log);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($this->getRequest());
            if ($form->isValid()) {
                $log->setAmount($log->getAmount()*100);

                if (!$allow_split && $order->getAmountLeft() != $log->getAmount()/100) {
                    return $this->redirect($this->generateUrl('club_payment_cash_cash_confirm', array(
                        'order_id' => $order->getId(),
                        'amount' => $log->getAmount()/100
                    )));
                }

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($log);
                $em->flush();

                $this->get('order')->setOrder($order);
                $this->get('order')->makePayment($log);

                $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your changes are saved.'));

                return $this->redirect($this->generateUrl('admin_shop_order_edit', array('id' => $order->getId())));
            }
        }

        return $form;
    }
}
