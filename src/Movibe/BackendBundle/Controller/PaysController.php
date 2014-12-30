<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Form\PaysType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Movibe\BackendBundle\Entity\Pays;

/**
 * Pays controller.
 *
 */
class PaysController extends AbstractController
{
    /**
     * Lists all Pays entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pays_list = $em->getRepository('MovibeBackendBundle:Pays')->findAll();
        $pagination = $this->pagination($pays_list,1000);

        $pages = array();
        $pages['Pays'] = "movibe_backend_pays";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Pays:index.html.twig', array(
            'pays_list' => $pagination,
        ));
    }
    /**
     * Creates a new Pays entity.
     *
     */
    public function createAction(Request $request)
    {
        $pays = new Pays();

        $form = $this->createCreateForm($pays);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pays);
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Un nouveau pays a été créé');

            return $this->redirect($this->generateUrl('movibe_backend_pays_show', array('code' => $pays->getCode())));
        }

        return $this->render('MovibeBackendBundle:Pays:new.html.twig', array(
            'pays' => $pays,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Pays entity.
     *
     * @param Pays $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Pays $pays)
    {
        $form = $this->createForm(new PaysType(), $pays, array(
            'action' => $this->generateUrl('movibe_backend_pays_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Pays entity.
     *
     */
    public function newAction()
    {
        $pays = new Pays();

        $form   = $this->createCreateForm($pays);

        $pages = array();
        $pages['Pays'] = "movibe_backend_pays";
        $pages['Ajout'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Pays:new.html.twig', array(
            'pays' => $pays,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Pays entity.
     *
     */
    public function showAction($code)
    {
        $em = $this->getDoctrine()->getManager();

        $pays = $em->getRepository('MovibeBackendBundle:Pays')->find($code);

        if (!$pays) {
            throw $this->createNotFoundException("Le pays indiqué n'a pas été trouvé.");
        }

        $pages = array();
        $pages['Pays'] = "movibe_backend_pays";
        $pages[$pays->getNom()] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Pays:show.html.twig', array(
            'pays'      => $pays
        ));
    }

    /**
     * Displays a form to edit an existing Pays entity.
     *
     */
    public function editAction($code)
    {
        $em = $this->getDoctrine()->getManager();

        $pays = $em->getRepository('MovibeBackendBundle:Pays')->find($code);

        if (!$pays) {
            throw $this->createNotFoundException("Le pays indiqué n'a pas été trouvé.");
        }

        $editForm = $this->createEditForm($pays);

        $pages = array();
        $pages['Pays'] = "movibe_backend_pays";
        $pages['Edition'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Pays:edit.html.twig', array(
            'pays'      => $pays,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Pays entity.
     *
     * @param Pays $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Pays $pays)
    {
        $form = $this->createForm(new PaysType(), $pays, array(
            'action' => $this->generateUrl('movibe_backend_pays_update', array('code' => $pays->getCode())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Edit'));

        return $form;
    }
    /**
     * Edits an existing Pays entity.
     *
     */
    public function updateAction(Request $request, $code)
    {
        $em = $this->getDoctrine()->getManager();

        $pays = $em->getRepository('MovibeBackendBundle:Pays')->find($code);

        if (!$pays) {
            throw $this->createNotFoundException("Le pays indiqué n'a pas été trouvé.");
        }

        $editForm = $this->createEditForm($pays);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Le pays sélectionné a été modifié');

            return $this->redirect($this->generateUrl('movibe_backend_pays_show', array('code' => $code)));
        }

        return $this->render('MovibeBackendBundle:Pays:edit.html.twig', array(
            'pays'      => $pays,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Pays entity.
     *
     */
    public function deleteAction(Request $request, $code)
    {
        $em = $this->getDoctrine()->getManager();
        $pays = $em->getRepository('MovibeBackendBundle:Pays')->find($code);

        if (!$pays) {
            throw $this->createNotFoundException("Le pays indiqué n'a pas été trouvé.");
        }

        $em->remove($pays);
        $em->flush();


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(true);
        }
        else
        {
            $request->getSession()->getFlashbag()->add('message','Le pays sélectionné a été supprimé');
            return $this->redirect($this->generateUrl('movibe_backend_pays'));
        }
    }

    public function fichiersAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $pays_list = $em->getRepository('MovibeBackendBundle:Pays')->findAll();

        $flag = $em->getRepository('MovibeBackendBundle:Pays')->filePaysUpload($pays_list);

        if (!$flag)
        {
            $request->getSession()->getFlashbag()->add('message','La MAJ du fichier a échoué.');
        }

        return $this->render('MovibeBackendBundle:Pays:index.html.twig', array(
            'pays_list' => $pays_list,
        ));
    }

}
