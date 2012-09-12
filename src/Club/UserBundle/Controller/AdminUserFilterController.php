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

        $form_filter = new \Club\UserBundle\Filter\UserFilter($filter);
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
     * @Route("/quick")
     */
    public function quickAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $form = $this->createForm(new \Club\UserBundle\Form\Search());

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $user = $form->get('user')->getData();
                return $this->redirect($this->generateUrl('admin_user_edit', array( 'id' => $user->getId() )));
            } else {
                foreach ($form->get('user')->getErrors() as $error) {
                    $this->get('session')->setFlash('error', $error->getMessage());
                }
            }
        }

        return $this->redirect($this->generateUrl('admin_user'));
    }

    /**
     * @Route("/filter/reset/{id}")
     */
    public function resetAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $filter = $em->find('ClubUserBundle:Filter',$id);
        $em->getRepository('ClubUserBundle:Filter')->deleteAttributes($filter);

        return $this->redirect($this->generateUrl('admin_user'));
    }

    public function getFilterAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repos = $em->getRepository('ClubUserBundle:Filter');

        $filters = $repos->findBy(array(
            'user' => $this->get('security.context')->getToken()->getUser()
        ));

        $filter = $this->getActiveFilter();

        $form_filters = $this->buildFormFilters($filter);
        $form_filter = $this->buildFormFilter($filter);
        $form = $this->getForm($form_filter);

        return $this->render('ClubUserBundle:Filter:form.html.twig', array(
            'filter' => $filter,
            'form' => $form->createView(),
            'form_filters' => $form_filters->createView()
        ));
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

    private function buildFormFilters(\Club\UserBundle\Entity\Filter $filter = null)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repos = $em->getRepository('ClubUserBundle:Filter');

        $filters = $repos->findBy(array(
            'user' => $this->get('security.context')->getToken()->getUser()
        ));

        $qb = $em->createQueryBuilder()
            ->select('f')
            ->from('ClubUserBundle:Filter','f')
            ->where('f.user = :user')
            ->setParameter('user',$this->get('security.context')->getToken()->getUser()->getId())
            ->orderBy('f.filter_name');

        $arr = array();

        if ($filter)
            $arr['filter'] = $filter;

        return $this->createFormBuilder($arr)
            ->add('filter','entity',array(
                'class' => 'ClubUserBundle:Filter',
                'query_builder' => $qb
            ))
            ->getForm();
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
