<?php

namespace Club\BookingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Club\BookingBundle\Entity\Plan;
use Club\BookingBundle\Entity\PlanException;
use Club\BookingBundle\Form\PlanExceptionType;

/**
 * @Route("/admin/booking/plan/exception")
 */
class AdminPlanExceptionController extends Controller
{
    /**
     * @Route("/new/{id}")
     * @Template()
     */
    public function newAction(Plan $plan)
    {
        $exception = new PlanException();
        $exception->setUser($this->getUser());
        $exception->setPlan($plan);

        $form = $this->createForm(new PlanExceptionType, $exception);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($exception);
                $em->flush();

                $this->get('club_extra.flash')->addNotice();

                return $this->redirect($this->generateUrl('club_booking_adminplanexception_index', array(
                    'id' => $plan->getId()
                )));
            }
        }

        return array(
            'form' => $form->createView(),
            'plan' => $plan
        );
    }

    /**
     * @Route("/edit/{id}")
     * @Template()
     */
    public function editAction(PlanException $exception)
    {
        $form = $this->createForm(new PlanExceptionTypexception);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($exception);
                $em->flush();

                $this->get('club_extra.flash')->addNotice();

                return $this->redirect($this->generateUrl('club_booking_adminplanexception_index', array(
                    'id' => $exception->getPlan()->getId()
                )));
            }
        }

        return array(
            'form' => $form->createView(),
            'exception' => $exception,
            'plan' => $exception->getPlan()
        );
    }

    /**
     * @Route("/delete/{id}")
     */
    public function deleteAction(PlanException $exception)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($exception);
        $em->flush();

        $this->get('club_extra.flash')->addNotice();

        return $this->redirect($this->generateUrl('club_booking_adminplanexception_index', array(
            'id' => $exception->getPlan()->getId()
        )));
    }

    /**
     * @Route("/{id}")
     * @Template()
     */
    public function indexAction(Plan $plan)
    {
        $em = $this->getDoctrine()->getManager();

        return array(
            'plan' => $plan
        );
    }
}
