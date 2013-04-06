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

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $data = $form->getData();

                if ($data['same_layout_all_days']) {
                    $form_all->bind($this->getRequest());

                    $d = $form_all->getData();
                    var_dump($d);die();
                } else {
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
