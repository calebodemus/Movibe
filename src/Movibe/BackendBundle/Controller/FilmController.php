<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Form\FilmType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Movibe\BackendBundle\Entity\Film;

/**
 * Film controller.
 *
 */
class FilmController extends AbstractController
{
    /**
     * Lists all Film entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $films = $em->getRepository('MovibeBackendBundle:Film')->findAll();

        foreach ($films as $film)
        {
            $tab= $em->getRepository('MovibeBackendBundle:Image')->promotionFilm($film->getId());
            if (isset($tab[0]))
            {
                $promotion = $tab[0];
                $film->setPromotion($promotion);
            }
        }

        $pages = array();
        $pages['Films'] = "movibe_backend_film";
        $this->breadcrumb($pages);

        $pagination = $this->pagination($films,1000);

        return $this->render('MovibeBackendBundle:Film:index.html.twig', array(
            'films' => $pagination
        ));
    }
    /**
     * Creates a new Film entity.
     *
     */
    public function createAction(Request $request)
    {
        $film = new Film();

        $form = $this->createCreateForm($film);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $images = $film->getImages();
            foreach ($images as $image)
            {
                $car_replace = array(':','\\','/','?','<','>','"','*','|');
                $titre = str_replace($car_replace,' ',$film->getTitre());
                $image->setFolder("Film/" . $titre);
            }


            $filmSocieteMetiers = $film->getFilmSocieteMetiers();
            $film->setFilmSocieteMetiers();

            $em = $this->getDoctrine()->getManager();
            $em->persist($film);

            $em->flush();


            if ($filmSocieteMetiers)
            {
                foreach ($filmSocieteMetiers as $filmSocieteMetier)
                {
                    $filmSocieteMetier->setFilm($film);
                    $em->persist($filmSocieteMetier);
                }
                $em->flush();
            }


            $request->getSession()->getFlashbag()->add('message','Un nouveau film a été créé');

            return $this->redirect($this->generateUrl('movibe_backend_film_show', array('id' => $film->getId())));
        }

        return $this->render('MovibeBackendBundle:Film:new.html.twig', array(
            'film' => $film,
            'form'   => $form->createView(),
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
        $form = $this->createForm(new FilmType(), $film, array(
            'action' => $this->generateUrl('movibe_backend_film_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Film entity.
     *
     */
    public function newAction()
    {
        $film = new Film();

        $form   = $this->createCreateForm($film);

        $pages = array();
        $pages['Films'] = "movibe_backend_film";
        $pages['Création'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Film:new.html.twig', array(
            'film' => $film,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Film entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $film = $em->getRepository('MovibeBackendBundle:Film')->find($id);

        if (!$film) {
            throw $this->createNotFoundException("Le film indiqué n'a pas été trouvé.");
        }

        $film->dispatchCasting();
        $film->searchPromotion();
        $film->searchAffiches();

        $castings = $film->getCastings();

        foreach($castings as $casting)
        {
            $tab = $em->getRepository('MovibeBackendBundle:Image')->promotionPersonne($casting->getPersonne()->getId());
            if (isset($tab[0]))
            {
                $promotion = $tab[0];
                $casting->getPersonne()->setPromotion($promotion);
            }
        }

        $film->setCastings($castings);

        $pages = array();
        $pages['Films'] = "movibe_backend_film";
        $pages[$film->getTitre()] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Film:show.html.twig', array(
            'film' => $film
        ));
    }

    /**
     * Displays a form to edit an existing Film entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $film = $em->getRepository('MovibeBackendBundle:Film')->find($id);

        if (!$film) {
            throw $this->createNotFoundException("La film indiqué n'a pas été trouvé.");
        }

        $film->imagesPath('small');
        $film->dispatchCasting();
        $film->promotionPersonnes();

        $editForm = $this->createEditForm($film);

        $pages = array();
        $pages['Films'] = "movibe_backend_film";
        $pages[$film->getTitre()] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Film:edit.html.twig', array(
            'film'      => $film,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Film entity.
     *
     * @param Film $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Film $film)
    {
        $form = $this->createForm(new FilmType(), $film, array(
            'action' => $this->generateUrl('movibe_backend_film_update', array('id' => $film->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Edit'));

        return $form;
    }
    /**
     * Edits an existing Film entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $film = $em->getRepository('MovibeBackendBundle:Film')->find($id);

        $old_critiques = clone $film->getCritiques();
        $old_medias = clone $film->getMedias();
        $old_images = clone $film->getImages();
        $old_castings = clone $film->getCastings();
        $old_filmSocieteMetiers = clone $film->getFilmSocieteMetiers();


        if (!$film) {
            throw $this->createNotFoundException("Le film indiqué n'a pas été trouvé.");
        }

        $editForm = $this->createEditForm($film);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $images = $film->getImages();
            foreach ($images as $image)
            {
                $car_replace = array(':','\\','/','?','<','>','"','*','|');
                $titre = str_replace($car_replace,' ',$film->getTitre());
                $image->setFolder("Film/" . $titre);
            }

            $film->initCastings();

            $em->flush();

            $new_critiques = $film->getCritiques();
            $new_medias = $film->getMedias();
            $new_images = $film->getImages();
            $new_castings = $film->getCastings();
            $new_filmSocieteMetiers = $film->getFilmSocieteMetiers();

            $tab = $film->verificationRemoveElement($old_critiques, $new_critiques);
            $this->deleteElement($tab);

            $tab = $film->verificationRemoveElement($old_medias, $new_medias);
            $this->deleteElement($tab);

            $tab = $film->verificationRemoveElement($old_images, $new_images);
            $this->deleteElement($tab);

            $tab = $film->verificationRemoveElement($old_castings, $new_castings);
            $this->deleteElement($tab);

            $tab = $film->verificationRemoveElement($old_filmSocieteMetiers, $new_filmSocieteMetiers);
            $this->deleteElement($tab);

            $em->flush();


            $request->getSession()->getFlashbag()->add('message','Le film sélectionné a été modifié');

            return $this->redirect($this->generateUrl('movibe_backend_film_show', array('id' => $id)));
        }

        $film->imagesPath('small');
        $film->dispatchCasting();
        $film->promotionPersonnes();

        return $this->render('MovibeBackendBundle:Film:edit.html.twig', array(
            'film'      => $film,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Film entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $film = $em->getRepository('MovibeBackendBundle:Film')->find($id);

        if (!$film) {
            throw $this->createNotFoundException("Le film indiqué n'a pas été trouvé.");
        }

        $images = $film->getImages();

        foreach ($images as $img)
        {
            $car_replace = array(':','\\','/','?','<','>','"','*','|');
            $titre = str_replace($car_replace,' ',$film->getTitre());
            $img->setFolder("Film/" . $titre);
        }


        $em->remove($film);
        $em->flush();


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(true);
        }
        else
        {
            $request->getSession()->getFlashbag()->add('message','Le film sélectionné a été supprimé');
            return $this->redirect($this->generateUrl('movibe_backend_film'));
        }
    }

    public function deleteElement($tab)
    {
        $em = $this->getDoctrine()->getManager();
        foreach ($tab as $element)
        {
            $em->remove($element);
        }
    }
}
