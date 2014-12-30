<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Form\TypeFilmType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Movibe\BackendBundle\Entity\TypeFilm;

/**
 * TypeFilm controller.
 *
 */
class TypeFilmController extends AbstractController
{
    /**
     * Lists all TypeFilm entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $typeFilms = $em->getRepository('MovibeBackendBundle:TypeFilm')->findAll();
        $pagination = $this->pagination($typeFilms,1000);

        $pages = array();
        $pages['Types de Film '] = "movibe_backend_typeFilm";
        $pages['Creation'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:TypeFilm:index.html.twig', array(
            'typeFilms' => $pagination,
        ));
    }
    /**
     * Creates a new TypeFilm entity.
     *
     */
    public function createAction(Request $request)
    {
        $typeFilm = new TypeFilm();

        $form = $this->createCreateForm($typeFilm);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeFilm);
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Un nouveau type de Film a été créé');

            return $this->redirect($this->generateUrl('movibe_backend_typeFilm_show', array('id' => $typeFilm->getId())));
        }

        return $this->render('MovibeBackendBundle:TypeFilm:new.html.twig', array(
            'typeFilm' => $typeFilm,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TypeFilm entity.
     *
     * @param TypeFilm $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TypeFilm $typeFilm)
    {
        $form = $this->createForm(new TypeFilmType(), $typeFilm, array(
            'action' => $this->generateUrl('movibe_backend_typeFilm_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new TypeFilm entity.
     *
     */
    public function newAction()
    {
        $typeFilm = new TypeFilm();

        $form   = $this->createCreateForm($typeFilm);

        $pages = array();
        $pages['Types de Film '] = "movibe_backend_typeFilm";
        $pages['Creation'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:TypeFilm:new.html.twig', array(
            'typeFilm' => $typeFilm,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TypeFilm entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $typeFilm = $em->getRepository('MovibeBackendBundle:TypeFilm')->find($id);

        if (!$typeFilm) {
            throw $this->createNotFoundException("Le type de Film indiqué n'a pas été trouvé.");
        }

        $pages = array();
        $pages['Types de Film '] = "movibe_backend_typeFilm";
        $pages[$typeFilm->getNom()] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:TypeFilm:show.html.twig', array(
            'typeFilm'      => $typeFilm
        ));
    }

    /**
     * Displays a form to edit an existing TypeFilm entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $typeFilm = $em->getRepository('MovibeBackendBundle:TypeFilm')->find($id);

        if (!$typeFilm) {
            throw $this->createNotFoundException("Le type de Film indiqué n'a pas été trouvé.");
        }

        $editForm = $this->createEditForm($typeFilm);

        $pages = array();
        $pages['Types de Film '] = "movibe_backend_typeFilm";
        $pages['Edition'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:TypeFilm:edit.html.twig', array(
            'typeFilm'      => $typeFilm,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a TypeFilm entity.
     *
     * @param TypeFilm $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(TypeFilm $typeFilm)
    {
        $form = $this->createForm(new TypeFilmType(), $typeFilm, array(
            'action' => $this->generateUrl('movibe_backend_typeFilm_update', array('id' => $typeFilm->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Edit'));

        return $form;
    }
    /**
     * Edits an existing TypeFilm entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $typeFilm = $em->getRepository('MovibeBackendBundle:TypeFilm')->find($id);

        if (!$typeFilm) {
            throw $this->createNotFoundException("Le type de Film indiqué n'a pas été trouvé.");
        }

        $editForm = $this->createEditForm($typeFilm);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Le type de Film sélectionné a été modifié');

            return $this->redirect($this->generateUrl('movibe_backend_typeFilm_show', array('id' => $id)));
        }

        return $this->render('MovibeBackendBundle:TypeFilm:edit.html.twig', array(
            'typeFilm'      => $typeFilm,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a TypeFilm entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $typeFilm = $em->getRepository('MovibeBackendBundle:TypeFilm')->find($id);

        if (!$typeFilm) {
            throw $this->createNotFoundException("Le type de Film indiqué n'a pas été trouvé.");
        }

        $em->remove($typeFilm);
        $em->flush();


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(true);
        }
        else
        {
            $request->getSession()->getFlashbag()->add('message','Le type de Film sélectionné a été supprimé');
            return $this->redirect($this->generateUrl('movibe_backend_typeFilm'));
        }
    }
}
