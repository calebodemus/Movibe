<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Form\DepartementType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Movibe\BackendBundle\Entity\Departement;

/**
 * Departement controller.
 *
 */
class DepartementController extends AbstractController
{
    /**
     * Lists all Departement entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $departements = $em->getRepository('MovibeBackendBundle:Departement')->findAll();
        $pagination = $this->pagination($departements,1000);

        $pages = array();
        $pages['Departements'] = "movibe_backend_departement";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Departement:index.html.twig', array(
            'departements' => $pagination,
        ));
    }
    /**
     * Creates a new Departement entity.
     *
     */
    public function createAction(Request $request)
    {
        $departement = new Departement();

        $form = $this->createCreateForm($departement);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $nom_uppercase = strtoupper($request->request->get('movibe_backendbundle_departement')['nom']);
            $departement->setNomUppercase($nom_uppercase);

            $em = $this->getDoctrine()->getManager();
            $em->persist($departement);
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Un nouveau departement a été créé');

            return $this->redirect($this->generateUrl('movibe_backend_departement_show', array('id' => $departement->getId())));
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

        return $this->render('MovibeBackendBundle:Departement:new.html.twig', array(
            'departement' => $departement,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Departement entity.
     *
     * @param Departement $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Departement $departement)
    {
        $form = $this->createForm(new DepartementType(), $departement, array(
            'action' => $this->generateUrl('movibe_backend_departement_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Departement entity.
     *
     */
    public function newAction()
    {
        $departement = new Departement();

        $form   = $this->createCreateForm($departement);

        $pages = array();
        $pages['Departements'] = "movibe_backend_departement";
        $pages['Ajout'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Departement:new.html.twig', array(
            'departement' => $departement,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Departement entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $departement = $em->getRepository('MovibeBackendBundle:Departement')->find($id);

        if (!$departement) {
            throw $this->createNotFoundException("Le departement indiqué n'a pas été trouvé.");
        }

        $pages = array();
        $pages['Departements'] = "movibe_backend_departement";
        $pages[$departement->getNom()] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Departement:show.html.twig', array(
            'departement'      => $departement
        ));
    }

    /**
     * Displays a form to edit an existing Departement entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $departement = $em->getRepository('MovibeBackendBundle:Departement')->find($id);

        if (!$departement) {
            throw $this->createNotFoundException("Le departement indiqué n'a pas été trouvé.");
        }

        $editForm = $this->createEditForm($departement);

        $pages = array();
        $pages['Departements'] = "movibe_backend_departement";
        $pages['Edition'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Departement:edit.html.twig', array(
            'departement'      => $departement,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Departement entity.
     *
     * @param Departement $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Departement $departement)
    {
        $form = $this->createForm(new DepartementType(), $departement, array(
            'action' => $this->generateUrl('movibe_backend_departement_update', array('id' => $departement->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Edit'));

        return $form;
    }
    /**
     * Edits an existing Departement entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $departement = $em->getRepository('MovibeBackendBundle:Departement')->find($id);

        if (!$departement) {
            throw $this->createNotFoundException("Le departement indiqué n'a pas été trouvé.");
        }

        $editForm = $this->createEditForm($departement);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $nom_uppercase = strtoupper($request->request->get('movibe_backendbundle_departement')['nom']);
            $departement->setNomUppercase($nom_uppercase);

            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Le departement sélectionné a été modifié');

            return $this->redirect($this->generateUrl('movibe_backend_departement_show', array('id' => $id)));
        }

        return $this->render('MovibeBackendBundle:Departement:edit.html.twig', array(
            'departement'      => $departement,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Departement entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $departement = $em->getRepository('MovibeBackendBundle:Departement')->find($id);

        if (!$departement) {
            throw $this->createNotFoundException("Le departement indiqué n'a pas été trouvé.");
        }

        $em->remove($departement);
        $em->flush();


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(true);
        }
        else
        {
            $request->getSession()->getFlashbag()->add('message','Le departement sélectionné a été supprimé');
            return $this->redirect($this->generateUrl('movibe_backend_departement'));
        }
    }
}
