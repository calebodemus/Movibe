<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Form\CouleurType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Movibe\BackendBundle\Entity\Couleur;

/**
 * Couleur controller.
 *
 */
class CouleurController extends AbstractController
{
    /**
     * Lists all Couleur entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $couleurs = $em->getRepository('MovibeBackendBundle:Couleur')->findAll();
        $pagination = $this->pagination($couleurs,1000);

        $pages = array();
        $pages['Couleurs'] = "movibe_backend_couleur";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Couleur:index.html.twig', array(
            'couleurs' => $pagination,
        ));
    }
    /**
     * Creates a new Couleur entity.
     *
     */
    public function createAction(Request $request)
    {
        $couleur = new Couleur();

        $form = $this->createCreateForm($couleur);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($couleur);
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Une nouvelle couleur a été créée');

            return $this->redirect($this->generateUrl('movibe_backend_couleur_show', array('id' => $couleur->getId())));
        }

        return $this->render('MovibeBackendBundle:Couleur:new.html.twig', array(
            'couleur' => $couleur,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Couleur entity.
     *
     * @param Couleur $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Couleur $couleur)
    {
        $form = $this->createForm(new CouleurType(), $couleur, array(
            'action' => $this->generateUrl('movibe_backend_couleur_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Couleur entity.
     *
     */
    public function newAction()
    {
        $couleur = new Couleur();

        $form   = $this->createCreateForm($couleur);

        $pages = array();
        $pages['Couleurs'] = "movibe_backend_couleur";
        $pages['Ajout'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Couleur:new.html.twig', array(
            'couleur' => $couleur,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Couleur entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $couleur = $em->getRepository('MovibeBackendBundle:Couleur')->find($id);

        if (!$couleur) {
            throw $this->createNotFoundException("La couleur indiquée n'a pas été trouvée.");
        }

        $pages = array();
        $pages['Couleurs'] = "movibe_backend_couleur";
        $pages[$couleur->getNom()] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Couleur:show.html.twig', array(
            'couleur'      => $couleur
        ));
    }

    /**
     * Displays a form to edit an existing Couleur entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $couleur = $em->getRepository('MovibeBackendBundle:Couleur')->find($id);

        if (!$couleur) {
            throw $this->createNotFoundException("La couleur indiquée n'a pas été trouvée.");
        }

        $editForm = $this->createEditForm($couleur);

        $pages = array();
        $pages['Couleurs'] = "movibe_backend_couleur";
        $pages['Edition'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Couleur:edit.html.twig', array(
            'couleur'      => $couleur,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Couleur entity.
     *
     * @param Couleur $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Couleur $couleur)
    {
        $form = $this->createForm(new CouleurType(), $couleur, array(
            'action' => $this->generateUrl('movibe_backend_couleur_update', array('id' => $couleur->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Edit'));

        return $form;
    }
    /**
     * Edits an existing Couleur entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $couleur = $em->getRepository('MovibeBackendBundle:Couleur')->find($id);

        if (!$couleur) {
            throw $this->createNotFoundException("La couleur indiquée n'a pas été trouvée.");
        }

        $editForm = $this->createEditForm($couleur);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','La couleur sélectionnée a été modifiée');

            return $this->redirect($this->generateUrl('movibe_backend_couleur_show', array('id' => $id)));
        }

        return $this->render('MovibeBackendBundle:Couleur:edit.html.twig', array(
            'couleur'      => $couleur,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Couleur entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $couleur = $em->getRepository('MovibeBackendBundle:Couleur')->find($id);

        if (!$couleur) {
            throw $this->createNotFoundException("La couleur indiquée n'a pas été trouvée.");
        }

        $em->remove($couleur);
        $em->flush();


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(true);
        }
        else
        {
            $request->getSession()->getFlashbag()->add('message','La couleur sélectionnée a été supprimée');
            return $this->redirect($this->generateUrl('movibe_backend_couleur'));
        }
    }
}
