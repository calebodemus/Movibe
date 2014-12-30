<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Form\SeanceFilmType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Movibe\BackendBundle\Entity\Film;

/**
 * Film controller.
 *
 */
class SeanceFilmController extends AbstractController
{
    /**
     * Creates a new Film entity.
     *
     */
    public function createAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $film = $em->getRepository('MovibeBackendBundle:Film')->find($id);

        $form = $this->createCreateForm($film);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em->persist($film);

            $em->flush();

            $request->getSession()->getFlashbag()->add('message','De nouvelles séances ont été rajoutées au film.');

            return $this->redirect($this->generateUrl('movibe_backend_seanceFilm_new', array('id' => $film->getId())));
        }

        $seances = $film->getSeances();

        return $this->render('MovibeBackendBundle:Seance:new.html.twig', array(
            'film' => $film,
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
    private function createCreateForm(Film $film)
    {
        $form = $this->createForm(new SeanceFilmType('film'), $film, array(
            'action' => $this->generateUrl('movibe_backend_seanceFilm_create', array( 'id' => $film->getId())),
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
        $film = $em->getRepository('MovibeBackendBundle:Film')->find($id);
        $film->searchPromotion();
        $seances = $film->getSeances();

        $form   = $this->createCreateForm($film);

        $pages = array();
        $pages['Seances'] = "movibe_backend_seance_search";
        $pages['Creation'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Seance:new.html.twig', array(
            'film' => $film,
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
            return $this->redirect($this->generateUrl('movibe_backend_seanceFilm_new', array('id' => $seance->getId())));
        }
    }
}
