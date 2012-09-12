<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin/user/filter")
 */
class AdminUserFilterController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $filter = $this->getActiveFilter();

        $form_filter = $this->buildFormFilter($filter);
        $form = $this->getForm($form_filter);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($this->getRequest());

            if ($form->isValid()) {
                $data = $form->getData();
                $filter = $this->syncFilters($filter,$data);
            }

            return $this->redirect($this->generateUrl('admin_user'));
        }

        return array(
            'filter' => $filter,
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/filter/reset/{id}")
     */
    public function resetAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $filter = $em->find('ClubUserBundle:Filter',$id);
        $em->getRepository('ClubUserBundle:Filter')->deleteAttributes($filter);

        return $this->redirect($this->generateUrl('club_user_adminuserfilter_index'));
    }

    /**
     * Syncronize form filter with database object
     */
    private function syncFilters($filter,$data)
    {
        foreach ($data as $key => $value) {
            switch ($key) {
            case 'location':
                $str = '';
                foreach ($value as $l) {
                    $str .= $l->getId().',';
                }
                $str = preg_replace("/,$/","",$str);
                $str = ($str != '') ? $str : null;
                $this->syncColumn($filter, $key, $str);

                break;
            case 'subscription_start':
                $value = ($value != '') ? serialize($value) : null;
                $this->syncColumn($filter, $key, $value);
                break;
            default:
                $value = ($value != '') ? $value : null;
                $this->syncColumn($filter, $key, $value);
                break;
            }
        }

        $em = $this->getDoctrine()->getEntityManager();
        $em->flush();
    }

    /**
     * Syncronize a data column
     */
    private function syncColumn($filter, $column, $value)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $attr = $em->getRepository('ClubUserBundle:FilterAttribute')->findOneBy(array(
            'filter' => $filter->getId(),
            'attribute' => $column
        ));

        if (!strlen($value) && $attr) {
            $em->remove($attr);
        } elseif (strlen($value)) {
            if (!$attr) {
                $attr = new \Club\UserBundle\Entity\FilterAttribute();
                $attr->setFilter($filter);
                $attr->setAttribute($column);
            }
            $attr->setValue($value);
            $em->persist($attr);
        }
    }

    /**
     * Get the users active filter object
     * If none exists initialize a new one
     */
    private function getActiveFilter()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $filter = $em->getRepository('ClubUserBundle:Filter')->findActive(
            $this->get('security.context')->getToken()->getUser()
        );

        return $filter;
    }

    /**
     * Build the form filter
     */
    private function buildFormFilter(\Club\UserBundle\Entity\Filter $filter)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $form_filter = new \Club\UserBundle\Filter\UserFilter();

        foreach ($filter->getAttributes() as $attribute) {
            $key = $attribute->getAttribute();

            switch ($key) {
            case 'subscription_start':
                if ($attribute->getValue() != '')
                    $form_filter->subscription_start = unserialize($attribute->getValue());
                break;
            case 'location':
                $res = new \Doctrine\Common\Collections\ArrayCollection();
                $locations = $em->getRepository('ClubUserBundle:Location')->getByIds(explode(",", $attribute->getValue()));

                foreach ($locations as $location) {
                    $res[] = $location;
                }

                $form_filter->location = $res;
                break;
            default:
                $form_filter->$key = $attribute->getValue();
                break;
            }
        }

        return $form_filter;
    }

    private function getForm($form_filter)
    {
        $form = $this->createForm(new \Club\UserBundle\Form\Filter(), $form_filter);

        return $form;
    }
}
