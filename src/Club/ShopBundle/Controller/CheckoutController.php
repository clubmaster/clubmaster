<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

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
        $cart = $this->get('cart')->getCart();

        return array(
            'cart' => $cart,
            'active_page' => 'cart'
        );
    }

    /**
     * @Route("/increment/{id}")
     */
    public function incrementAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('ClubShopBundle:CartProduct')->find($id);
        $this->get('cart')->modifyQuantity($product);

        return $this->redirect($this->generateUrl('shop_checkout'));
    }

    /**
     * @Route("/decrement/{id}")
     */
    public function decrementAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('ClubShopBundle:CartProduct')->find($id);
        $this->get('cart')->modifyQuantity($product,-1);

        return $this->redirect($this->generateUrl('shop_checkout'));
    }

    /**
     * @Route("/order", name="shop_checkout_order")
     * @Template()
     */
    public function orderAction()
    {
        $cart = $this->get('cart')->getCart();
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
        if (!count($this->get('cart')->getCart()->getCartProducts())) {
            $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('You need to add products to your cart before you can checkout.'));

            return $this->redirect($this->generateUrl('shop_checkout'));
        }

        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('club_shop_checkout_signin'));
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
            $this->get('cart')->setPayment($payment);
            $this->get('cart')->save();

            $cart = $this->get('cart')->getCart();

            $errors = $this->get('validator')->validate($cart);
            if (count($errors)) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('Something when wrong in your order, please try again! If that does not help empty your cart and try again.'));
                return $this->redirect($this->generateUrl('shop_checkout_review'));
            }

            if (!count($cart->getCartProducts())) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('This order has no products.'));

                return $this->redirect($this->generateUrl('shop'));
            }

            if ($cart) {
                $em = $this->getDoctrine()->getManager();
                $shipping = $cart->getShipping();

                if ($shipping->getPrice() > 0) {
                    $product = array(
                        'product_name' => $shipping->getShippingName(),
                        'price' => $shipping->getPrice(),
                        'type' => 'shipping'
                    );
                    $this->get('cart')->addToCart($product);
                }
                $this->get('order')->convertToOrder($cart);
                $order = $this->get('order')->getOrder();

            } else {
                return $this->redirect($this->generateUrl('shop'));
            }

            return $this->redirect($this->generateUrl($order->getPaymentMethod()->getController(), array(
                'order_id' => $order->getId()
            )));
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
        $em = $this->getDoctrine()->getManager();
        $this->get('session')->set('_security.user.target_path', $this->generateUrl('club_shop_checkout_login', array(), true));

        $user = $this->get('clubmaster.user')->get();
        $form = $this->createForm(new \Club\UserBundle\Form\User(), $user);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());
            if ($form->isValid()) {

                $this->get('clubmaster.user')->save();
                $this->get('session')->getFlashBag()->add('notice',$this->get('translator')->trans('Your account has been created.'));

                $token = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken(
                    $user,
                    null,
                    'user'
                );
                $this->get('security.context')->setToken($token);

                return $this->redirect($this->generateUrl('club_shop_checkout_login'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/login")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function loginAction()
    {
        $em = $this->getDoctrine()->getManager();
        $carts = $em->getRepository('ClubShopBundle:Cart')->findBy(array(
            'user' => $this->getUser()->getId()
        ));
        foreach ($carts as $cart) {
            $em->remove($cart);
        }

        $this->get('cart')->setUser();
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
