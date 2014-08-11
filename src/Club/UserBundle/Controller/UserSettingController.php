<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/{_locale}/user/setting")
 */
class UserSettingController extends Controller
{
    /**
     * @Route("")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $settings = $em->getRepository('ClubUserBundle:UserSetting')->getUserArray($this->getUser());
        $form = $this->getForm($settings);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $this->sync($form->getData());

                $em->flush();
                $this->get('club_extra.flash')->addNotice();

                $this->get('club_user.user')->updateUserSettings();

                return $this->redirect($this->generateUrl('club_user_usersetting_index',
                    array('_locale' => $this->getRequest()->getLocale())
                ));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    protected function sync(array $data)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        foreach ($data as $key=>$value) {
            $attr = $em->getRepository('ClubUserBundle:UserSetting')->findOneBy(array(
                'user' => $user->getId(),
                'attribute' => $key
            ));

            if ($attr && !strlen($value)) {
                $em->remove($attr);
            } elseif (!$attr && strlen($value)) {
                $attr = new \Club\UserBundle\Entity\UserSetting();
                $attr->setUser($user);
                $attr->setAttribute($key);

                $attr->setValue($value);
                $em->persist($attr);
            } elseif (strlen($value)) {
                $attr->setValue($value);
                $em->persist($attr);
            }
        }
    }

    protected function getForm(array $settings)
    {
        $boolean = array(
            0 => 'No',
            1 => 'Yes'
        );
        $languages = array(
            'da' => 'Danish',
            'en' => 'English'
        );

        $attr = array(
            'class' => 'form-control'
        );
        $label_attr = array(
            'class' => 'col-sm-2'
        );

        $form  = $this->createFormBuilder($settings)
            ->add('receive_email_on_booking', 'choice', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'choices' => $boolean,
                'required' => false,
            ))
            ->add('public_booking_activity', 'choice', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'choices' => $boolean,
                'required' => false
            ))
            ->add('language', 'language', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'choices' => $languages,
                'required' => false
            ))
            ->add('dateformat', 'language', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'required' => false
            ))
            ->add('timezone', 'timezone', array(
                'attr' => $attr,
                'label_attr' => $label_attr,
                'required' => false
            ))
            ->getForm()
            ;

        return $form;
    }
}
