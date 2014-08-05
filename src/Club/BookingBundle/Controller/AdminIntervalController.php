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
     * @Route("/{id}")
     * @Template()
     */
    public function indexAction(\Club\BookingBundle\Entity\Field $field)
    {
        $data = array(
            'same_layout_every_day' => $field->getSameLayoutEveryDay()
        );

        $form = $this->createFormBuilder($data)
            ->add('same_layout_every_day', 'checkbox', array(
                'label_attr' => array(
                    'class' => 'col-sm-2'
                ),
                'required' => false
            ))
            ->getForm();

        $data_all = $this->getIntervalDefaultArray($field, 'all');
        $data_monday = $this->getIntervalDefaultArray($field, 'monday');
        $data_tuesday = $this->getIntervalDefaultArray($field, 'tuesday');
        $data_wednesday = $this->getIntervalDefaultArray($field, 'wednesday');
        $data_thursday = $this->getIntervalDefaultArray($field, 'thursday');
        $data_friday = $this->getIntervalDefaultArray($field, 'friday');
        $data_saturday = $this->getIntervalDefaultArray($field, 'saturday');
        $data_sunday = $this->getIntervalDefaultArray($field, 'sunday');

        $form_all = $this->getIntervalForm($data_all, 'all');
        $form_monday = $this->getIntervalForm($data_monday, 'monday');
        $form_tuesday = $this->getIntervalForm($data_tuesday, 'tuesday');
        $form_wednesday = $this->getIntervalForm($data_wednesday, 'wednesday');
        $form_thursday = $this->getIntervalForm($data_thursday, 'thursday');
        $form_friday = $this->getIntervalForm($data_friday, 'friday');
        $form_saturday = $this->getIntervalForm($data_saturday, 'saturday');
        $form_sunday = $this->getIntervalForm($data_sunday, 'sunday');

        if ($this->getRequest()->getMethod() == 'POST') {
            $em = $this->getDoctrine()->getManager();

            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $data = $form->getData();

                $field->setSameLayoutEveryDay($data['same_layout_every_day']);

                if ($data['same_layout_every_day']) {
                    $form_all->bind($this->getRequest());

                    if ($form_all->isValid()) {
                        $d = $form_all->getData();

                        $fl = json_encode(array('all' => $d));
                        if (md5($fl) != md5($field->getFieldLayout())) {

                            for ($day = 1; $day <= 7; $day++) {
                                $intervals = preg_split("/\n/", $d['available_timeslots']);
                                foreach ($intervals as $interval) {
                                    $interval = trim($interval);

                                    $this->buildInterval($field, $day, $interval);
                                }
                            }
                        }

                        $this->post($field, $fl);
                        $em->flush();

                        return $this->redirect($this->generateUrl('club_booking_adminfield_index'));
                    }
                } else { // not all in the same day
                    $form_monday->bind($this->getRequest());
                    $form_tuesday->bind($this->getRequest());
                    $form_wednesday->bind($this->getRequest());
                    $form_thursday->bind($this->getRequest());
                    $form_friday->bind($this->getRequest());
                    $form_saturday->bind($this->getRequest());
                    $form_sunday->bind($this->getRequest());

                    $fl = json_encode(array(
                        'monday' => $form_monday->getData(),
                        'tuesday' => $form_tuesday->getData(),
                        'wednesday' => $form_wednesday->getData(),
                        'thursday' => $form_thursday->getData(),
                        'friday' => $form_friday->getData(),
                        'saturday' => $form_saturday->getData(),
                        'sunday' => $form_sunday->getData()
                    ));

                    if (md5($fl) != md5($field->getFieldLayout())) {

                            for ($day = 1; $day <= 7; $day++) {
                                switch ($day) {
                                case 1:
                                    $d = $form_monday->getData();
                                    break;
                                case 2:
                                    $d = $form_tuesday->getData();
                                    break;
                                case 3:
                                    $d = $form_wednesday->getData();
                                    break;
                                case 4:
                                    $d = $form_thursday->getData();
                                    break;
                                case 5:
                                    $d = $form_friday->getData();
                                    break;
                                case 6:
                                    $d = $form_saturday->getData();
                                    break;
                                case 7:
                                    $d = $form_sunday->getData();
                                    break;
                                }

                                $intervals = preg_split("/\n/", $d['available_timeslots']);
                                foreach ($intervals as $interval) {
                                    $interval = trim($interval);

                                    $this->buildInterval($field, $day, $interval);
                                }
                            }
                    }

                    $this->post($field, $fl);
                    $em->flush();

                    return $this->redirect($this->generateUrl('club_booking_adminfield_index'));

                }
            }
        }

        return array(
            'field' => $field,
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

    protected function getIntervalForm($data, $prefix)
    {
        return $this->get('form.factory')->createNamedBuilder($prefix, 'form', $data)
            ->add('available_timeslots', 'textarea')
            ->add('interval')
            ->add('open')
            ->add('close')
            ->getForm();
    }

    protected function getIntervalDefaultArray(\Club\BookingBundle\Entity\Field $field, $day)
    {
        $r = json_decode($field->getFieldLayout());

        $r = (isset($r->$day))
            ? $r->$day
            : false;

        $open = new \DateTime();
        if (!isset($r->open)) {
            $open->setTime(8,0,0);
        } else {
            $n = preg_split("/:/", $r->open);
            $open->setTime($n[0],$n[1],0);
        }

        $close = new \DateTime();
        if (!isset($r->close)) {
            $close->setTime(20,0,0);
        } else {
            $n = preg_split("/:/", $r->close);
            $close->setTime($n[0],$n[1],0);
        }

        if (!isset($r->interval)) {
            $interval = new \DateInterval('PT60M');
            $range = new \DatePeriod($open, $interval, $close);

            $available = '';
            foreach ($range as $dt) {
                $work = clone $dt;

                $available .= $work->format('H:i').'-';
                $work->modify('+'.$interval->i.' minute');
                $available .= $work->format('H:i')."\n";
            }
        } else {
            $interval = new \DateInterval('PT'.$r->interval.'M');
            $available = $r->available_timeslots;
        }


        return array(
            'open' => $open->format('H:i'),
            'close' => $close->format('H:i'),
            'interval' => $interval->i,
            'available_timeslots' => $available
        );
    }

    protected function buildInterval(\Club\BookingBundle\Entity\Field $field, $day, $interval)
    {
        $n = preg_split("/-/", $interval);

        $n_start = preg_split("/:/", $n[0]);
        $n_end = preg_split("/:/", $n[1]);

        $start = new \DateTime();
        $start->setTime($n_start[0], $n_start[1], 0);
        $end = new \DateTime();
        $end->setTime($n_end[0], $n_end[1], 0);

        $interval = new \Club\BookingBundle\Entity\Interval();
        $interval->setField($field);
        $interval->setDay($day);
        $interval->setStartTime(clone $start);
        $interval->setStopTime(clone $end);
        $interval->setValidFrom(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($interval);

        return $interval;
    }

    protected function post(\Club\BookingBundle\Entity\Field $field, $fl)
    {
        $em = $this->getDoctrine()->getManager();

        $field->setFieldLayout($fl);
        $em->persist($field);

        $intervals = $em->getRepository('ClubBookingBundle:Interval')->findBy(array(
            'valid_to' => null,
            'field' => $field->getId()
        ));
        foreach ($intervals as $interval) {
            $interval->setValidTo(new \DateTime());
            $em->persist($interval);
        }
    }
}
