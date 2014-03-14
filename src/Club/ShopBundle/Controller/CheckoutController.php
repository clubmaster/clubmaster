<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/shop/checkout")
 */
class CheckoutController extends Controller
{
    /**
     * @Route("", name="shop_checkout")
     * @Template()
     */
    public function indexAction()
    {
        $cart = $this->get('cart')
            ->getCurrent()
            ->getCart();

        return array(
            'cart' => $cart,
            'active_page' => 'cart'
        );
    }

    /**
     * @Route("/decrement/{id}")
     */
    public function decrementAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('ClubShopBundle:CartProduct')->find($id);
        $this->get('cart')
            ->getCurrent()
            ->modifyQuantity($product,-1);

        return $this->redirect($this->generateUrl('shop_checkout'));
    }

    /**
     * @Route("/order", name="shop_checkout_order")
     * @Template()
     */
    public function orderAction()
    {
        $cart = $this->get('cart')
            ->getCurrent()
            ->getCart();

        if (!$cart->getCustomerAddress()) {
            $address = new \Club\ShopBundle\Entity\CartAddress();
            $this->get('cart')->setAddresses($address);
        }

        $form = $this->createForm(new \Club\ShopBundle\Form\Cart, $cart);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($cart);
                $em->flush();

                $this->get('cart')->updateShipping();
                $this->get('cart')->calcCartPrice();

                return $this->redirect($this->generateUrl('shop_checkout_review'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/review", name="shop_checkout_review")
     * @Template()
     */
    public function reviewAction()
    {
        if (!count($this->get('cart')->getCurrent()->getCart()->getCartProducts())) {
            $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('You need to add products to your cart before you can checkout.'));

            return $this->redirect($this->generateUrl('shop_checkout'));
        }

        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('club_shop_checkout_signin'));
        }

        if (!$this->get('cart')->getCart()->getCustomerAddress()) {
            $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('You need to enter customer informations'));
            return $this->redirect($this->generateUrl('shop_checkout_order'));
        }

        if (!$this->get('cart')->getCart()->getShipping()) {
            $em = $this->getDoctrine()->getManager();
            $shippings = $em->getRepository('ClubShopBundle:Shipping')->findAll();
            $shipping = array_shift($shippings);
            $this->get('cart')->getCart()->setShipping($shipping);
            $this->get('cart')->updateShipping();

            $this->get('cart')->save();
        }

        $payments = $this->get('shop_paymentmethod')->getAll();
        $cart = $this->get('cart')->getCart();

        return array(
            'payments' => $payments,
            'cart' => $this->get('cart')->getCart()
        );
    }

    /**
     * @Route("/process/{id}", name="shop_checkout_process")
     * @Template()
     */
    public function processAction(\Club\ShopBundle\Entity\PaymentMethod $payment)
    {
        try {
            $cart = $this->get('cart')
                ->getCurrent()
                ->setPayment($payment)
                ->getCart();

            $errors = $this->get('validator')->validate($cart);
            if (count($errors)) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('Something when wrong in your order, please try again! If that does not help empty your cart and try again.'));
                return $this->redirect($this->generateUrl('shop_checkout_review'));
            }

            if (!count($cart->getCartProducts())) {
                throw new \Exception($this->get('translator')->trans('This order has no products.'));
            }

            if (!$cart) {
                throw new \Exception($this->get('translator')->trans('No active cart'));
            }

            $order = $this->get('order')
                ->convertToOrder($cart)
                ->getOrder();

            return $this->redirect($this->generateUrl(
                $order->getPaymentMethod()->getController(),
                array(
                    'order_id' => $order->getId()
                )
            ));

        } catch (\Exception $e) {
            $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans($e->getMessage()));
            return $this->redirect($this->generateUrl('shop'));
        }
    }

    /**
     * @Route("/empty", name="shop_checkout_empty")
     */
    public function emptyCartAction()
    {
        $this->get('cart')->emptyCart();

        return $this->redirect($this->generateUrl('shop_checkout'));
    }

    /**
     * @Route("/signin")
     * @Template()
     */
    public function signinAction()
    {
        $this->get('session')->set('_security.user.target_path', $this->generateUrl('club_shop_checkout_login', array(), true));
        return $this->redirect($this->generateUrl('club_user_auth_signin'));
    }

    /**
     * @Route("/login")
     * @Template()
     */
    public function loginAction()
    {

        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $carts = $em->getRepository('ClubShopBundle:Cart')->findBy(array(
            'user' => $this->getUser()->getId()
        ));
        foreach ($carts as $cart) {
            $em->remove($cart);
        }

        $this->get('cart')
            ->getCurrent()
            ->setUser($this->getUser());

        $this->get('cart')->save();

        return $this->redirect($this->generateUrl('shop_checkout_review'));
    }

    protected function getCustomerAddress(\Club\ShopBundle\Entity\Cart $cart)
    {
        $profile = $cart->getUser()->getProfile();

        $address = new \Club\ShopBundle\Entity\CartAddress();
        $address->setFirstName($profile->getFirstName());
        $address->setLastName($profile->getLastName());

        return $address;
    }
}
