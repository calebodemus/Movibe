<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Form\SocieteType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Movibe\BackendBundle\Entity\Societe;

/**
 * Societe controller.
 *
 */
class SocieteController extends AbstractController
{
    /**
     * Lists all Societe entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $societes = $em->getRepository('MovibeBackendBundle:Societe')->findAll();
        $pagination = $this->pagination($societes,1000);

        $pages = array();
        $pages['Sociétés'] = "movibe_backend_societe";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Societe:index.html.twig', array(
            'societes' => $pagination,
        ));
    }
    /**
     * Creates a new Societe entity.
     *
     */
    public function createAction(Request $request)
    {
        $societe = new Societe();

        $form = $this->createCreateForm($societe);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($societe);
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Votre société a bien été créée');

            return $this->redirect($this->generateUrl('movibe_backend_societe_show', array('id' => $societe->getId())));
        }

        return $this->render('MovibeBackendBundle:Societe:new.html.twig', array(
            'societe' => $societe,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Societe entity.
     *
     * @param Societe $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Societe $societe)
    {
        $form = $this->createForm(new SocieteType(), $societe, array(
            'action' => $this->generateUrl('movibe_backend_societe_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Societe entity.
     *
     */
    public function newAction()
    {
        $societe = new Societe();

        $form   = $this->createCreateForm($societe);

        $pages = array();
        $pages['Sociétés'] = "movibe_backend_societe";
        $pages['Creation'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Societe:new.html.twig', array(
            'societe' => $societe,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Societe entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $societe = $em->getRepository('MovibeBackendBundle:Societe')->find($id);

        if (!$societe) {
            throw $this->createNotFoundException("La société n'a pas été trouvée.");
        }

        $pages = array();
        $pages['Sociétés'] = "movibe_backend_societe";
        $pages[$societe->getNom()] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Societe:show.html.twig', array(
            'societe'      => $societe
        ));
    }

    /**
     * Displays a form to edit an existing Societe entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $societe = $em->getRepository('MovibeBackendBundle:Societe')->find($id);

        if (!$societe) {
            throw $this->createNotFoundException("La société n'a pas été trouvée.");
        }

        $editForm = $this->createEditForm($societe);

        $pages = array();
        $pages['Sociétés'] = "movibe_backend_societe";
        $pages['Edition'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Societe:edit.html.twig', array(
            'societe'      => $societe,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Societe entity.
     *
     * @param Societe $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Societe $societe)
    {
        $form = $this->createForm(new SocieteType(), $societe, array(
            'action' => $this->generateUrl('movibe_backend_societe_update', array('id' => $societe->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Edit'));

        return $form;
    }
    /**
     * Edits an existing Societe entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $societe = $em->getRepository('MovibeBackendBundle:Societe')->find($id);

        if (!$societe) {
            throw $this->createNotFoundException("La société n'a pas été trouvée.");
        }

        $editForm = $this->createEditForm($societe);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Votre sociétée a bien été modifiée');

            return $this->redirect($this->generateUrl('movibe_backend_societe_show', array('id' => $id)));
        }

        return $this->render('MovibeBackendBundle:Societe:edit.html.twig', array(
            'societe'      => $societe,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Societe entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $societe = $em->getRepository('MovibeBackendBundle:Societe')->find($id);

        if (!$societe) {
            throw $this->createNotFoundException("La société n'a pas été trouvée.");
        }

        $em->remove($societe);
        $em->flush();


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(true);
        }
        else
        {
            $request->getSession()->getFlashbag()->add('message','Votre société a bien été supprimée');
            return $this->redirect($this->generateUrl('movibe_backend_societe'));
        }
    }
}
