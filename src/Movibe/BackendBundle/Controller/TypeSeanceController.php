<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Form\TypeSeanceType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Movibe\BackendBundle\Entity\TypeSeance;

/**
 * TypeSeance controller.
 *
 */
class TypeSeanceController extends AbstractController
{
    /**
     * Lists all TypeSeance entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $typeSeances = $em->getRepository('MovibeBackendBundle:TypeSeance')->findAll();
        $pagination = $this->pagination($typeSeances,1000);

        $pages = array();
        $pages['Types de Séance '] = "movibe_backend_typeSeance";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:TypeSeance:index.html.twig', array(
            'typeSeances' => $pagination,
        ));
    }
    /**
     * Creates a new TypeSeance entity.
     *
     */
    public function createAction(Request $request)
    {
        $typeSeance = new TypeSeance();

        $form = $this->createCreateForm($typeSeance);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeSeance);
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Un nouveau type de séance a été créé');

            return $this->redirect($this->generateUrl('movibe_backend_typeSeance_show', array('id' => $typeSeance->getId())));
        }

        return $this->render('MovibeBackendBundle:TypeSeance:new.html.twig', array(
            'typeSeance' => $typeSeance,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TypeSeance entity.
     *
     * @param TypeSeance $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TypeSeance $typeSeance)
    {
        $form = $this->createForm(new TypeSeanceType(), $typeSeance, array(
            'action' => $this->generateUrl('movibe_backend_typeSeance_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new TypeSeance entity.
     *
     */
    public function newAction()
    {
        $typeSeance = new TypeSeance();

        $form   = $this->createCreateForm($typeSeance);

        $pages = array();
        $pages['Types de Séance '] = "movibe_backend_typeSeance";
        $pages['Creation'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:TypeSeance:new.html.twig', array(
            'typeSeance' => $typeSeance,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TypeSeance entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $typeSeance = $em->getRepository('MovibeBackendBundle:TypeSeance')->find($id);

        if (!$typeSeance) {
            throw $this->createNotFoundException("Le type de séance indiqué n'a pas été trouvé.");
        }

        $pages = array();
        $pages['Types de Séance '] = "movibe_backend_typeSeance";
        $pages[$typeSeance->getNom()] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:TypeSeance:show.html.twig', array(
            'typeSeance'      => $typeSeance
        ));
    }

    /**
     * Displays a form to edit an existing TypeSeance entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $typeSeance = $em->getRepository('MovibeBackendBundle:TypeSeance')->find($id);

        if (!$typeSeance) {
            throw $this->createNotFoundException("Le type de séance indiqué n'a pas été trouvé.");
        }

        $editForm = $this->createEditForm($typeSeance);

        $pages = array();
        $pages['Types de Séance '] = "movibe_backend_typeSeance";
        $pages['Edition'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:TypeSeance:edit.html.twig', array(
            'typeSeance'      => $typeSeance,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a TypeSeance entity.
     *
     * @param TypeSeance $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(TypeSeance $typeSeance)
    {
        $form = $this->createForm(new TypeSeanceType(), $typeSeance, array(
            'action' => $this->generateUrl('movibe_backend_typeSeance_update', array('id' => $typeSeance->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Edit'));

        return $form;
    }
    /**
     * Edits an existing TypeSeance entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $typeSeance = $em->getRepository('MovibeBackendBundle:TypeSeance')->find($id);

        if (!$typeSeance) {
            throw $this->createNotFoundException("Le type de séance indiqué n'a pas été trouvé.");
        }

        $editForm = $this->createEditForm($typeSeance);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Le type de séance sélectionné a été modifié');

            return $this->redirect($this->generateUrl('movibe_backend_typeSeance_show', array('id' => $id)));
        }

        return $this->render('MovibeBackendBundle:TypeSeance:edit.html.twig', array(
            'typeSeance'      => $typeSeance,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a TypeSeance entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $typeSeance = $em->getRepository('MovibeBackendBundle:TypeSeance')->find($id);

        if (!$typeSeance) {
            throw $this->createNotFoundException("Le type de séance indiqué n'a pas été trouvé.");
        }

        $em->remove($typeSeance);
        $em->flush();


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(true);
        }
        else
        {
            $request->getSession()->getFlashbag()->add('message','Le type de séance sélectionné a été supprimé');
            return $this->redirect($this->generateUrl('movibe_backend_typeSeance'));
        }
    }
}
