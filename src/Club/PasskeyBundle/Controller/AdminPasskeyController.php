<?php

namespace Club\PasskeyBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Club\PasskeyBundle\Entity\Passkey;
use Club\PasskeyBundle\Form\PasskeyType;

/**
 * @Route("/admin/passkey")
 */
class AdminPasskeyController extends Controller
{
    /**
     * @Route("")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $passkeys = $em->getRepository('ClubPasskeyBundle:Passkey')->findAll();

        return array(
            'passkeys' => $passkeys
        );
    }

    /**
     * @Route("/new")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $passkey = new Passkey();

        $form = $this->createForm(new PasskeyType(), $passkey);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($passkey);
            $em->flush();

            $this->get('club_extra.flash')->addNotice();

            return $this->redirect($this->generateUrl('club_passkey_adminpasskey_edit', array(
                'id' => $passkey->getId()
            )));
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/edit/{id}")
     * @Template()
     */
    public function editAction(Request $request, Passkey $passkey)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new PasskeyType(), $passkey);
        $form->handleRequest($request);

        $user_form = $this->get('club_user.form')->getAjaxForm('all');

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($passkey);
            $em->flush();

            $this->get('club_extra.flash')->addNotice();

            return $this->redirect($this->generateUrl('club_passkey_adminpasskey_index'));
        }

        return array(
            'passkey' => $passkey,
            'form' => $form->createView(),
            'user_form' => $user_form->createView()
        );
    }

    /**
     * @Route("/user/{id}")
     * @Template()
     */
    public function userAction(Request $request, Passkey $passkey)
    {
        $em = $this->getDoctrine()->getManager();
        $userForm = $this->get('club_user.form');;

        $form = $userForm->getAjaxForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $user = $userForm->getUser();

            if ($user) {
                $passkey->setUser($user);

                $em = $this->getDoctrine()->getManager();
                $em->persist($passkey);

                $em->flush();
                $this->get('club_extra.flash')->addNotice();
            }

            return $this->redirect($this->generateUrl('club_passkey_adminpasskey_index'));
        }

        return array(
            'passkey' => $passkey,
            'form' => $form->createView(),
            'user_form' => $user_form->createView()
        );
    }

    /**
     * @Route("/reset/{id}")
     */
    public function resetAction(Passkey $passkey)
    {
        $em = $this->getDoctrine()->getManager();
        $passkey->setUser(null);

        $em->flush();

        $this->get('club_extra.flash')->addNotice();

        return $this->redirect($this->generateUrl('club_passkey_adminpasskey_index'));
    }

    /**
     * @Route("/delete/{id}")
     */
    public function deleteAction(Passkey $passkey)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($passkey);
        $em->flush();

        $this->get('club_extra.flash')->addNotice();

        return $this->redirect($this->generateUrl('club_passkey_adminpasskey_index'));
    }
}
