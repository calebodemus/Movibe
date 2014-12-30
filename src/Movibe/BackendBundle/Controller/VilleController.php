<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Form\VilleType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Movibe\BackendBundle\Entity\Ville;

/**
 * Ville controller.
 *
 */
class VilleController extends AbstractController
{
    /**
     * Lists all Ville entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        //$villes = $em->getRepository('MovibeBackendBundle:Ville')->findAll();
        //$villes = $em->getRepository('MovibeBackendBundle:Ville')->showAll();

        $villes = $em->createQuery('SELECT a FROM MovibeBackendBundle:Ville a');
        $pagination = $this->pagination($villes,1000);

        $pages = array();
        $pages['Villes'] = "movibe_backend_ville";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Ville:index.html.twig',array('villes' => $pagination));
        /*
        return $this->render('MovibeBackendBundle:Ville:index.html.twig', array(
            'villes' => $villes,
        ));*/

    }

    /**
     * Creates a form to create a Ville entity.
     *
     * @param Ville $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Ville $ville)
    {
        $form = $this->createForm(new VilleType(), $ville, array(
            'action' => $this->generateUrl('movibe_backend_ville_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Ville entity.
     *
     */
    public function newAction()
    {
        $ville = new Ville();

        $form   = $this->createCreateForm($ville);

        $pages = array();
        $pages['Villes'] = "movibe_backend_ville";
        $pages['Création'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Ville:new.html.twig', array(
            'ville' => $ville,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ville entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $ville = $em->getRepository('MovibeBackendBundle:Ville')->find($id);

        if (!$ville) {
            throw $this->createNotFoundException("La ville indiquée n'a pas été trouvée.");
        }

        $pages = array();
        $pages['Villes'] = "movibe_backend_ville";
        $pages[$ville->getNom()] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Ville:show.html.twig', array(
            'ville'      => $ville
        ));
    }

    /**
     * Displays a form to edit an existing Ville entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $ville = $em->getRepository('MovibeBackendBundle:Ville')->find($id);

        if (!$ville) {
            throw $this->createNotFoundException("La ville indiquée n'a pas été trouvée.");
        }

        $editForm = $this->createEditForm($ville);

        $pages = array();
        $pages['Villes'] = "movibe_backend_ville";
        $pages['Edition'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Ville:edit.html.twig', array(
            'ville'      => $ville,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Ville entity.
     *
     * @param Ville $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Ville $ville)
    {
        $form = $this->createForm(new VilleType(), $ville, array(
            'action' => $this->generateUrl('movibe_backend_ville_update', array('id' => $ville->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Edit'));

        return $form;
    }

    /**
     * Edits an existing Ville entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $ville = $em->getRepository('MovibeBackendBundle:Ville')->find($id);

        if (!$ville) {
            throw $this->createNotFoundException("La ville indiquée n'a pas été trouvée.");
        }

        $editForm = $this->createEditForm($ville);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $nom_uppercase = strtoupper($request->request->get('movibe_backendbundle_ville')['nom']);
            $ville->setNomUppercase($nom_uppercase);

            $em->flush();

            $request->getSession()->getFlashbag()->add('message','La ville sélectionnée a été modifiée');

            return $this->redirect($this->generateUrl('movibe_backend_ville_show', array('id' => $id)));
        }

        return $this->render('MovibeBackendBundle:Ville:edit.html.twig', array(
            'ville'      => $ville,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Ville entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $ville = $em->getRepository('MovibeBackendBundle:Ville')->find($id);

        if (!$ville) {
            throw $this->createNotFoundException("La ville indiquée n'a pas été trouvée.");
        }

        $em->remove($ville);
        $em->flush();


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(true);
        }
        else
        {
            $request->getSession()->getFlashbag()->add('message','La ville sélectionnée a été supprimée');
            return $this->redirect($this->generateUrl('movibe_backend_ville'));
        }
    }

    /**
    * Creates a new Ville entity.
     *
     */
    public function createAction(Request $request)
    {
        $ville = new Ville();

        $form = $this->createCreateForm($ville);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $nom_uppercase = strtoupper($request->request->get('movibe_backendbundle_ville')['nom']);
            $ville->setNomUppercase($nom_uppercase);

            $em = $this->getDoctrine()->getManager();
            $em->persist($ville);
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Une nouvelle ville a été créée');

            return $this->redirect($this->generateUrl('movibe_backend_ville_show', array('id' => $ville->getId())));
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

        return $this->render('MovibeBackendBundle:Ville:new.html.twig', array(
            'ville' => $ville,
            'form'   => $form->createView(),
        ));
    }
}
