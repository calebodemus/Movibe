<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Form\HoraireType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Movibe\BackendBundle\Entity\Horaire;

/**
 * Horaire controller.
 *
 */
class HoraireController extends AbstractController
{
    /**
     * Lists all Horaire entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $horaires = $em->getRepository('MovibeBackendBundle:Horaire')->findAll();
        $pagination = $this->pagination($horaires,1000);


        return $this->render('MovibeBackendBundle:Horaire:index.html.twig', array(
            'horaires' => $pagination,
        ));
    }
    /**
     * Creates a new Horaire entity.
     *
     */
    public function createAction(Request $request)
    {
        $horaire = new Horaire();

        $form = $this->createCreateForm($horaire);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $heures = $horaire->getHeures();
            $horaire->setHeures();

            $em = $this->getDoctrine()->getManager();
            $em->persist($horaire);
            $em->flush();

            if ($heures)
            {
                foreach ($heures as $heure )
                {
                    $heure->setHoraire($horaire);
                    $em->persist($heure);
                    $em->flush();
                }
            }

            $request->getSession()->getFlashbag()->add('message','Un nouveau pack horaire a été créé');

            return $this->redirect($this->generateUrl('movibe_backend_horaire_show', array('id' => $horaire->getId())));
        }

        return $this->render('MovibeBackendBundle:Horaire:new.html.twig', array(
            'horaire' => $horaire,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Horaire entity.
     *
     * @param Horaire $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Horaire $horaire)
    {
        $form = $this->createForm(new HoraireType(), $horaire, array(
            'action' => $this->generateUrl('movibe_backend_horaire_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Horaire entity.
     *
     */
    public function newAction()
    {
        $horaire = new Horaire();

        $form   = $this->createCreateForm($horaire);

        return $this->render('MovibeBackendBundle:Horaire:new.html.twig', array(
            'horaire' => $horaire,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Horaire entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $horaire = $em->getRepository('MovibeBackendBundle:Horaire')->find($id);

        if (!$horaire) {
            throw $this->createNotFoundException("Le pack horaire indiqué n'a pas été trouvé.");
        }

        return $this->render('MovibeBackendBundle:Horaire:show.html.twig', array(
            'horaire'      => $horaire
        ));
    }

    /**
     * Displays a form to edit an existing Horaire entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $horaire = $em->getRepository('MovibeBackendBundle:Horaire')->find($id);

        if (!$horaire) {
            throw $this->createNotFoundException("Le pack horaire indiqué n'a pas été trouvé.");
        }


        $editForm = $this->createEditForm($horaire);

        return $this->render('MovibeBackendBundle:Horaire:edit.html.twig', array(
            'horaire'      => $horaire,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Horaire entity.
     *
     * @param Horaire $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Horaire $horaire)
    {

        $form = $this->createForm(new HoraireType(), $horaire, array(
            'action' => $this->generateUrl('movibe_backend_horaire_update', array('id' => $horaire->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Edit'));

        return $form;
    }


    /**
     * Edits an existing Horaire entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();



        $horaire = $em->getRepository('MovibeBackendBundle:Horaire')->find($id);

         if (!$horaire) {
            throw $this->createNotFoundException("Le pack horaire indiqué n'a pas été trouvé.");
        }

        //$class = $em->getClassMetadata(get_class($horaire));
        //$assoc = $class->getAssociationMapping("heures");
        //$col = $class->getFieldMapping('heures');

        $editForm = $this->createEditForm($horaire);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $oldHeures = $horaire->getOldHeures();

            if ($oldHeures)
            {
                foreach ($oldHeures as $oh)
                {
                    $em->remove($oh);
                }
            }

            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Le pack horaire sélectionné a été modifié');

            return $this->redirect($this->generateUrl('movibe_backend_horaire_show', array('id' => $id)));
        }

        return $this->render('MovibeBackendBundle:Horaire:edit.html.twig', array(
            'horaire'      => $horaire,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Horaire entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $horaire = $em->getRepository('MovibeBackendBundle:Horaire')->find($id);

        if (!$horaire) {
            throw $this->createNotFoundException("Le pack horaire indiqué n'a pas été trouvé.");
        }

        $em->remove($horaire);
        $em->flush();


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(true);
        }
        else
        {
            $request->getSession()->getFlashbag()->add('message','Le pack horaire sélectionné a été supprimé');
            return $this->redirect($this->generateUrl('movibe_backend_horaire'));
        }
    }
}
