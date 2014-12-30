<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Form\LangueType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Movibe\BackendBundle\Entity\Langue;

/**
 * Langue controller.
 *
 */
class LangueController extends AbstractController
{
    /**
     * Lists all Langue entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $langues = $em->getRepository('MovibeBackendBundle:Langue')->findAll();
        $pagination = $this->pagination($langues,1000);

        $pages = array();
        $pages['Langues'] = "movibe_backend_langue";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Langue:index.html.twig', array(
            'langues' => $pagination,
        ));
    }
    /**
     * Creates a new Langue entity.
     *
     */
    public function createAction(Request $request)
    {
        $langue = new Langue();

        $form = $this->createCreateForm($langue);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($langue);
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Une nouvelle langue a été créée');

            return $this->redirect($this->generateUrl('movibe_backend_langue_show', array('id' => $langue->getId())));
        }

        return $this->render('MovibeBackendBundle:Langue:new.html.twig', array(
            'langue' => $langue,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Langue entity.
     *
     * @param Langue $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Langue $langue)
    {
        $form = $this->createForm(new LangueType(), $langue, array(
            'action' => $this->generateUrl('movibe_backend_langue_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Langue entity.
     *
     */
    public function newAction()
    {
        $langue = new Langue();

        $form   = $this->createCreateForm($langue);

        $pages = array();
        $pages['Langues'] = "movibe_backend_langue";
        $pages['Ajout'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Langue:new.html.twig', array(
            'langue' => $langue,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Langue entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $langue = $em->getRepository('MovibeBackendBundle:Langue')->find($id);

        if (!$langue) {
            throw $this->createNotFoundException("La langue indiquée n'a pas été trouvée.");
        }

        $pages = array();
        $pages['Langues'] = "movibe_backend_langue";
        $pages[$langue->getNom()] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Langue:show.html.twig', array(
            'langue'      => $langue
        ));
    }

    /**
     * Displays a form to edit an existing Langue entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $langue = $em->getRepository('MovibeBackendBundle:Langue')->find($id);

        if (!$langue) {
            throw $this->createNotFoundException("La langue indiquée n'a pas été trouvée.");
        }

        $editForm = $this->createEditForm($langue);

        $pages = array();
        $pages['Langues'] = "movibe_backend_langue";
        $pages['Edition'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Langue:edit.html.twig', array(
            'langue'      => $langue,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Langue entity.
     *
     * @param Langue $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Langue $langue)
    {
        $form = $this->createForm(new LangueType(), $langue, array(
            'action' => $this->generateUrl('movibe_backend_langue_update', array('id' => $langue->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Edit'));

        return $form;
    }
    /**
     * Edits an existing Langue entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $langue = $em->getRepository('MovibeBackendBundle:Langue')->find($id);

        if (!$langue) {
            throw $this->createNotFoundException("La langue indiquée n'a pas été trouvée.");
        }

        $editForm = $this->createEditForm($langue);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','La langue sélectionnée a été modifiée');

            return $this->redirect($this->generateUrl('movibe_backend_langue_show', array('id' => $id)));
        }

        return $this->render('MovibeBackendBundle:Langue:edit.html.twig', array(
            'langue'      => $langue,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Langue entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $langue = $em->getRepository('MovibeBackendBundle:Langue')->find($id);

        if (!$langue) {
            throw $this->createNotFoundException("La langue indiquée n'a pas été trouvée.");
        }

        $em->remove($langue);
        $em->flush();


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(true);
        }
        else
        {
            $request->getSession()->getFlashbag()->add('message','La langue sélectionnée a été supprimée');
            return $this->redirect($this->generateUrl('movibe_backend_langue'));
        }
    }
}
