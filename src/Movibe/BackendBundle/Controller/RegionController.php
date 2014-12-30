<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Form\RegionType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Movibe\BackendBundle\Entity\Region;

/**
 * Region controller.
 *
 */
class RegionController extends AbstractController
{
    /**
     * Lists all Region entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $regions = $em->getRepository('MovibeBackendBundle:Region')->findAll();
        $pagination = $this->pagination($regions,1000);

        $pages = array();
        $pages['Regions'] = "movibe_backend_region";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Region:index.html.twig', array(
            'regions' => $pagination,
        ));
    }
    /**
     * Creates a new Region entity.
     *
     */
    public function createAction(Request $request)
    {
        $region = new Region();

        $form = $this->createCreateForm($region);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $nom_uppercase = strtoupper($request->request->get('movibe_backendbundle_region')['nom']);
            $region->setNomUppercase($nom_uppercase);

            $em = $this->getDoctrine()->getManager();
            $em->persist($region);
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Une nouvelle region a été créée');

            return $this->redirect($this->generateUrl('movibe_backend_region_show', array('id' => $region->getId())));
        }
        else
        {
            $validator = $this->get('validator');
            $errors = $validator->validate($form);

            foreach($errors as $e)
            {
               echo $e->getMessage();
            }
        }

        return $this->render('MovibeBackendBundle:Region:new.html.twig', array(
            'region' => $region,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Region entity.
     *
     * @param Region $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Region $region)
    {
        $form = $this->createForm(new RegionType(), $region, array(
            'action' => $this->generateUrl('movibe_backend_region_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Region entity.
     *
     */
    public function newAction()
    {
        $region = new Region();

        $form   = $this->createCreateForm($region);

        $pages = array();
        $pages['Regions'] = "movibe_backend_region";
        $pages['Création'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Region:new.html.twig', array(
            'region' => $region,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Region entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $region = $em->getRepository('MovibeBackendBundle:Region')->find($id);

        if (!$region) {
            throw $this->createNotFoundException("La region indiquée n'a pas été trouvée.");
        }

        $pages = array();
        $pages['Regions'] = "movibe_backend_region";
        $pages[$region->getNom()] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Region:show.html.twig', array(
            'region' => $region,
        ));

    }

    /**
     * Displays a form to edit an existing Region entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $region = $em->getRepository('MovibeBackendBundle:Region')->find($id);

        if (!$region) {
            throw $this->createNotFoundException("La region indiquée n'a pas été trouvée.");
        }

        $editForm = $this->createEditForm($region);

        $pages = array();
        $pages['Regions'] = "movibe_backend_region";
        $pages['Edition'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Region:edit.html.twig', array(
            'region'    => $region,
            'edit_form' => $editForm->createView(),
        ));

    }

    /**
     * Creates a form to edit a Region entity.
     *
     * @param Region $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Region $region)
    {
        $form = $this->createForm(new RegionType(), $region, array(
            'action' => $this->generateUrl('movibe_backend_region_update', array('id' => $region->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Edit'));

        return $form;
    }
    /**
     * Edits an existing Region entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $region = $em->getRepository('MovibeBackendBundle:Region')->find($id);

        if (!$region) {
            throw $this->createNotFoundException("La region indiquée n'a pas été trouvée.");
        }

        $editForm = $this->createEditForm($region);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $nom_uppercase = strtoupper($request->request->get('movibe_backendbundle_region')['nom']);
            $region->setNomUppercase($nom_uppercase);

            $em->flush();

            $request->getSession()->getFlashbag()->add('message','La region sélectionnée a été modifiée');

            return $this->redirect($this->generateUrl('movibe_backend_region_show', array('id' => $id)));
        }

        return $this->render('MovibeBackendBundle:Region:edit.html.twig', array(
            'region'      => $region,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Region entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $region = $em->getRepository('MovibeBackendBundle:Region')->find($id);

        if (!$region) {
            throw $this->createNotFoundException("La region indiquée n'a pas été trouvée.");
        }

        $em->remove($region);
        $em->flush();


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(true);
        }
        else
        {
            $request->getSession()->getFlashbag()->add('message','La region sélectionnée a été supprimée');
            return $this->redirect($this->generateUrl('movibe_backend_region'));
        }
    }
}
