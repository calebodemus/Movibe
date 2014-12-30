<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Form\SeanceCinemaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Movibe\BackendBundle\Entity\Cinema;

/**
 * Film controller.
 *
 */
class SeanceCinemaController extends AbstractController
{
    /**
     * Creates a new Film entity.
     *
     */
    public function createAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $cinema = $em->getRepository('MovibeBackendBundle:Cinema')->find($id);

        $form = $this->createCreateForm($cinema);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em->persist($cinema);

            $em->flush();

            $request->getSession()->getFlashbag()->add('message','De nouvelles séances ont été rajoutées au cinema.');

            return $this->redirect($this->generateUrl('movibe_backend_seanceCinema_new', array('id' => $cinema->getId())));
        }

        $seances = $cinema->getSeances();

        return $this->render('MovibeBackendBundle:Seance:new.html.twig', array(
            'cinema' => $cinema,
            'form'   => $form->createView(),
            'seances' => $seances,
        ));
    }

    /**
     * Creates a form to create a Film entity.
     *
     * @param Film $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Cinema $cinema)
    {
        $form = $this->createForm(new SeanceCinemaType('cinema'), $cinema, array(
            'action' => $this->generateUrl('movibe_backend_seanceCinema_create', array( 'id' => $cinema->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Film entity.
     *
     */
    public function newAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $cinema = $em->getRepository('MovibeBackendBundle:Cinema')->find($id);
        $seances = $cinema->getSeances();

        $form   = $this->createCreateForm($cinema);

        $pages = array();
        $pages['Seances'] = "movibe_backend_seance_search";
        $pages['Creation'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Seance:new.html.twig', array(
            'cinema' => $cinema,
            'form' => $form->createView(),
            'seances' => $seances,
        ));
    }

    /**
     * Deletes a Film entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $seance = $em->getRepository('MovibeBackendBundle:Seance')->find($id);

        if (!$seance) {
            throw $this->createNotFoundException("La séance indiquée n'a pas été trouvée.");
        }

        $em->remove($seance);
        $em->flush();


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(true);
        }
        else
        {
            $request->getSession()->getFlashbag()->add('message','La séance sélectionnée a été supprimée');
            return $this->redirect($this->generateUrl('movibe_backend_seanceCinema_new', array('id' => $seance->getId())));
        }
    }
}
