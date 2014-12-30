<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Form\PresseType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Movibe\BackendBundle\Entity\Presse;

/**
 * Presse controller.
 *
 */
class PresseController extends AbstractController
{
    /**
     * Lists all Presse entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $presses = $em->getRepository('MovibeBackendBundle:Presse')->findAll();
        $pagination = $this->pagination($presses,1000);

        $pages = array();
        $pages['Presses'] = "movibe_backend_presse";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Presse:index.html.twig', array(
            'presses' => $pagination,
        ));
    }
    /**
     * Creates a new Presse entity.
     *
     */
    public function createAction(Request $request)
    {
        $presse = new Presse();

        $form = $this->createCreateForm($presse);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($presse);
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Une nouvelle presse a été créée');

            return $this->redirect($this->generateUrl('movibe_backend_presse_show', array('id' => $presse->getId())));
        }

        return $this->render('MovibeBackendBundle:Presse:new.html.twig', array(
            'presse' => $presse,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Presse entity.
     *
     * @param Presse $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Presse $presse)
    {
        $form = $this->createForm(new PresseType(), $presse, array(
            'action' => $this->generateUrl('movibe_backend_presse_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Presse entity.
     *
     */
    public function newAction()
    {
        $presse = new Presse();

        $form   = $this->createCreateForm($presse);

        $pages = array();
        $pages['Presses'] = "movibe_backend_presse";
        $pages['Ajout'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Presse:new.html.twig', array(
            'presse' => $presse,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Presse entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $presse = $em->getRepository('MovibeBackendBundle:Presse')->find($id);

        if (!$presse) {
            throw $this->createNotFoundException("La presse indiquée n'a pas été trouvée.");
        }

        $pages = array();
        $pages['Presses'] = "movibe_backend_presse";
        $pages[$presse->getNom()] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Presse:show.html.twig', array(
            'presse'      => $presse
        ));
    }

    /**
     * Displays a form to edit an existing Presse entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $presse = $em->getRepository('MovibeBackendBundle:Presse')->find($id);

        if (!$presse) {
            throw $this->createNotFoundException("La presse indiquée n'a pas été trouvée.");
        }

        $editForm = $this->createEditForm($presse);

        $pages = array();
        $pages['Presses'] = "movibe_backend_presse";
        $pages['Edition'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Presse:edit.html.twig', array(
            'presse'      => $presse,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Presse entity.
     *
     * @param Presse $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Presse $presse)
    {
        $form = $this->createForm(new PresseType(), $presse, array(
            'action' => $this->generateUrl('movibe_backend_presse_update', array('id' => $presse->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Edit'));

        return $form;
    }
    /**
     * Edits an existing Presse entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $presse = $em->getRepository('MovibeBackendBundle:Presse')->find($id);

        if (!$presse) {
            throw $this->createNotFoundException("La presse indiquée n'a pas été trouvée.");
        }

        $editForm = $this->createEditForm($presse);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','La presse sélectionnée a été modifiée');

            return $this->redirect($this->generateUrl('movibe_backend_presse_show', array('id' => $id)));
        }

        return $this->render('MovibeBackendBundle:Presse:edit.html.twig', array(
            'presse'      => $presse,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Presse entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $presse = $em->getRepository('MovibeBackendBundle:Presse')->find($id);

        if (!$presse) {
            throw $this->createNotFoundException("La presse indiquée n'a pas été trouvée.");
        }

        $em->remove($presse);
        $em->flush();


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(true);
        }
        else
        {
            $request->getSession()->getFlashbag()->add('message','La presse sélectionnée a été supprimée');
            return $this->redirect($this->generateUrl('movibe_backend_presse'));
        }
    }
}
