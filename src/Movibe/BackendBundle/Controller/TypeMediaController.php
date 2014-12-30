<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Form\TypeMediaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Movibe\BackendBundle\Entity\TypeMedia;

/**
 * TypeMedia controller.
 *
 */
class TypeMediaController extends AbstractController
{
    /**
     * Lists all TypeMedia entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $typeMedias = $em->getRepository('MovibeBackendBundle:TypeMedia')->findAll();
        $pagination = $this->pagination($typeMedias,1000);

        $pages = array();
        $pages['Types de Média '] = "movibe_backend_typeMedia";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:TypeMedia:index.html.twig', array(
            'typeMedias' => $pagination,
        ));
    }
    /**
     * Creates a new TypeMedia entity.
     *
     */
    public function createAction(Request $request)
    {
        $typeMedia = new TypeMedia();

        $form = $this->createCreateForm($typeMedia);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeMedia);
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Un nouveau type de Media a été créé');

            return $this->redirect($this->generateUrl('movibe_backend_typeMedia_show', array('id' => $typeMedia->getId())));
        }

        return $this->render('MovibeBackendBundle:TypeMedia:new.html.twig', array(
            'typeMedia' => $typeMedia,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TypeMedia entity.
     *
     * @param TypeMedia $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TypeMedia $typeMedia)
    {
        $form = $this->createForm(new TypeMediaType(), $typeMedia, array(
            'action' => $this->generateUrl('movibe_backend_typeMedia_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new TypeMedia entity.
     *
     */
    public function newAction()
    {
        $typeMedia = new TypeMedia();

        $form   = $this->createCreateForm($typeMedia);

        $pages = array();
        $pages['Types de Média '] = "movibe_backend_typeMedia";
        $pages['Creation'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:TypeMedia:new.html.twig', array(
            'typeMedia' => $typeMedia,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TypeMedia entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $typeMedia = $em->getRepository('MovibeBackendBundle:TypeMedia')->find($id);

        if (!$typeMedia) {
            throw $this->createNotFoundException("Le type de Media indiqué n'a pas été trouvé.");
        }

        $pages = array();
        $pages['Types de Média '] = "movibe_backend_typeMedia";
        $pages[$typeMedia->getLibelle()] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:TypeMedia:show.html.twig', array(
            'typeMedia'      => $typeMedia
        ));
    }

    /**
     * Displays a form to edit an existing TypeMedia entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $typeMedia = $em->getRepository('MovibeBackendBundle:TypeMedia')->find($id);

        if (!$typeMedia) {
            throw $this->createNotFoundException("Le type de Media indiqué n'a pas été trouvé.");
        }

        $editForm = $this->createEditForm($typeMedia);

        $pages = array();
        $pages['Types de Média '] = "movibe_backend_typeMedia";
        $pages['Edition'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:TypeMedia:edit.html.twig', array(
            'typeMedia'      => $typeMedia,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a TypeMedia entity.
     *
     * @param TypeMedia $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(TypeMedia $typeMedia)
    {
        $form = $this->createForm(new TypeMediaType(), $typeMedia, array(
            'action' => $this->generateUrl('movibe_backend_typeMedia_update', array('id' => $typeMedia->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Edit'));

        return $form;
    }
    /**
     * Edits an existing TypeMedia entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $typeMedia = $em->getRepository('MovibeBackendBundle:TypeMedia')->find($id);

        if (!$typeMedia) {
            throw $this->createNotFoundException("Le type de Media indiqué n'a pas été trouvé.");
        }

        $editForm = $this->createEditForm($typeMedia);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Le type de Media sélectionné a été modifié');

            return $this->redirect($this->generateUrl('movibe_backend_typeMedia_show', array('id' => $id)));
        }

        return $this->render('MovibeBackendBundle:TypeMedia:edit.html.twig', array(
            'typeMedia'      => $typeMedia,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a TypeMedia entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $typeMedia = $em->getRepository('MovibeBackendBundle:TypeMedia')->find($id);

        if (!$typeMedia) {
            throw $this->createNotFoundException("Le type de Media indiqué n'a pas été trouvé.");
        }

        $em->remove($typeMedia);
        $em->flush();


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(true);
        }
        else
        {
            $request->getSession()->getFlashbag()->add('message','Le type de Media sélectionné a été supprimé');
            return $this->redirect($this->generateUrl('movibe_backend_typeMedia'));
        }
    }
}
