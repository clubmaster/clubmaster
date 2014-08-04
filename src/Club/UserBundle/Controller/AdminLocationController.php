<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Club\UserBundle\Entity\Location;
use Club\UserBundle\Form\LocationType;

/**
 * @Route("/{_locale}/admin")
 */
class AdminLocationController extends Controller
{
    /**
     * @Template()
     * @Route("/location", name="admin_location")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $locations = $em->getRepository('ClubUserBundle:Location')->getRoots();

        return array(
            'locations' => $locations
        );
    }

    /**
     * @Template()
     * @Route("/location/new", name="admin_location_new")
     */
    public function newAction()
    {
        $location = new Location();
        $res = $this->process($location);

        if ($res instanceOf RedirectResponse)

            return $res;

        return array(
            'form' => $res->createView()
        );
    }

    /**
     * @Template()
     * @Route("/location/edit/{id}", name="admin_location_edit")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $location = $em->find('ClubUserBundle:Location',$id);

        $res = $this->process($location);

        if ($res instanceOf RedirectResponse)

            return $res;

        return array(
            'location' => $location,
            'form' => $res->createView()
        );
    }

    /**
     * @Route("/location/delete/{id}", name="admin_location_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $location = $em->find('ClubUserBundle:Location',$this->getRequest()->get('id'));

        $em->remove($location);
        $em->flush();

        $this->get('club_extra.flash')->addNotice();

        return $this->redirect($this->generateUrl('admin_location'));
    }

    protected function process($location)
    {
        $form = $this->createForm(new LocationType(), $location);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($location);
                $em->flush();

                $this->get('club_extra.flash')->addNotice();

                return $this->redirect($this->generateUrl('admin_location'));
            }
        }

        return $form;
    }
}
