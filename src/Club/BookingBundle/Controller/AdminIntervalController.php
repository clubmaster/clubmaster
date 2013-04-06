<?php

namespace Club\BookingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/admin/booking/interval")
 */
class AdminIntervalController extends Controller
{
    /**
     * @Route("/{field_id}")
     * @Template()
     */
    public function indexAction($field_id)
    {
        $em = $this->getDoctrine()->getManager();

        $field = $em->find('ClubBookingBundle:Field', $field_id);
        $intervals = $em->getRepository('ClubBookingBundle:Interval')->findValidByField($field);

        return array(
            'intervals' => $intervals,
            'field' => $field
        );
    }

    /**
     * @Route("/{field_id}/new")
     * @Template()
     */
    public function newAction($field_id)
    {
        $em = $this->getDoctrine()->getManager();

        $field = $em->find('ClubBookingBundle:Field', $field_id);
        $interval = new \Club\BookingBundle\Entity\Interval();
        $interval->setField($field);
        $res = $this->process($interval);

        if ($res instanceOf RedirectResponse)

            return $res;

        return array(
            'form' => $res->createView(),
            'field' => $field
        );
    }

    /**
     * @Route("/edit/{id}")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $interval = $em->find('ClubBookingBundle:Interval',$id);

        $res = $this->process($interval);

        if ($res instanceOf RedirectResponse)

            return $res;

        return array(
            'interval' => $interval,
            'form' => $res->createView()
        );
    }

    /**
     * @Route("/delete/{id}")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $interval = $em->find('ClubBookingBundle:Interval',$this->getRequest()->get('id'));

        $em->remove($interval);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_booking_admininterval_index', array('field_id' => $interval->getField()->getId())));
    }

    protected function process($interval)
    {
        $form = $this->getForm($interval);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($interval);
                $em->flush();

                $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

                return $this->redirect($this->generateUrl('club_booking_admininterval_index', array('field_id' => $interval->getField()->getId())));
            }
        }

        return $form;
    }

    /**
     * @Route("/{field_id}/manage")
     * @Template()
     */
    public function manageAction($field_id)
    {
        $data = array(
            'same_layout_all_days' => true
        );

        $form = $this->createFormBuilder($data)
            ->add('same_layout_all_days', 'checkbox')
            ->getForm();

        $data_all = $this->getIntervalDefaultArray();
        $data_monday = $this->getIntervalDefaultArray();
        $data_tuesday = $this->getIntervalDefaultArray();
        $data_wednesday = $this->getIntervalDefaultArray();
        $data_thursday = $this->getIntervalDefaultArray();
        $data_friday = $this->getIntervalDefaultArray();
        $data_saturday = $this->getIntervalDefaultArray();
        $data_sunday = $this->getIntervalDefaultArray();

        $form_all = $this->getIntervalForm($data_all, 'all');
        $form_monday = $this->getIntervalForm($data_monday, 'monday');
        $form_tuesday = $this->getIntervalForm($data_tuesday, 'tuesday');
        $form_wednesday = $this->getIntervalForm($data_wednesday, 'wednesday');
        $form_thursday = $this->getIntervalForm($data_thursday, 'thursday');
        $form_friday = $this->getIntervalForm($data_friday, 'friday');
        $form_saturday = $this->getIntervalForm($data_saturday, 'saturday');
        $form_sunday = $this->getIntervalForm($data_sunday, 'sunday');

        return array(
            'form' => $form->createView(),
            'form_all' => $form_all->createView(),
            'form_monday' => $form_monday->createView(),
            'form_tuesday' => $form_tuesday->createView(),
            'form_wednesday' => $form_wednesday->createView(),
            'form_thursday' => $form_thursday->createView(),
            'form_friday' => $form_friday->createView(),
            'form_saturday' => $form_saturday->createView(),
            'form_sunday' => $form_sunday->createView(),
        );
    }

    protected function getForm($interval)
    {
        return $this->createFormBuilder($interval)
            ->add('day', 'choice', array(
                'choices' => $this->get('club_booking.interval')->getDays()
            ))
            ->add('start_time')
            ->add('stop_time')
            ->add('field')
            ->add('valid_from', 'jquery_datetime', array(
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ))
            ->add('valid_to', 'jquery_datetime', array(
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ))
            ->getForm();
    }

    protected function getIntervalForm($data, $prefix)
    {
        return $this->get('form.factory')->createNamedBuilder($prefix, 'form', $data)
            ->add('available_timeslots', 'textarea')
            ->add('interval')
            ->add('open')
            ->add('close')
            ->getForm();
    }

    protected function getIntervalDefaultArray()
    {
        $open = new \DateTime();
        $open->setTime(8,0,0);
        $close = new \DateTime();
        $close->setTime(20,0,0);

        $interval = new \DateInterval('PT60M');
        $range = new \DatePeriod($open, $interval, $close);

        $available = '';
        foreach ($range as $dt) {
            $work = clone $dt;

            $available .= $work->format('H:i').'-';
            $work->modify('+'.$interval->i.' minute');
            $available .= $work->format('H:i')."\n";
        }

        return array(
            'open' => $open->format('H:i'),
            'close' => $close->format('H:i'),
            'interval' => $interval->i,
            'available_timeslots' => $available
        );
    }
}
