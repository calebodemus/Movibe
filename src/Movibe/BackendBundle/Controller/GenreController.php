<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Form\GenreType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Movibe\BackendBundle\Entity\Genre;

/**
 * Genre controller.
 *
 */
class GenreController extends AbstractController
{
    /**
     * Lists all Genre entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $genres = $em->getRepository('MovibeBackendBundle:Genre')->findAll();
        $pagination = $this->pagination($genres,1000);

        $pages = array();
        $pages['Genres'] = "movibe_backend_genre";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Genre:index.html.twig', array(
            'genres' => $pagination,
        ));
    }
    /**
     * Creates a new Genre entity.
     *
     */
    public function createAction(Request $request)
    {
        $genre = new Genre();

        $form = $this->createCreateForm($genre);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($genre);
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Un nouveau genre a été créé');

            return $this->redirect($this->generateUrl('movibe_backend_genre_show', array('id' => $genre->getId())));
        }

        return $this->render('MovibeBackendBundle:Genre:new.html.twig', array(
            'genre' => $genre,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Genre entity.
     *
     * @param Genre $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Genre $genre)
    {
        $form = $this->createForm(new GenreType(), $genre, array(
            'action' => $this->generateUrl('movibe_backend_genre_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Genre entity.
     *
     */
    public function newAction()
    {
        $genre = new Genre();

        $form   = $this->createCreateForm($genre);

        $pages = array();
        $pages['Genres'] = "movibe_backend_genre";
        $pages['Ajout'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Genre:new.html.twig', array(
            'genre' => $genre,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Genre entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $genre = $em->getRepository('MovibeBackendBundle:Genre')->find($id);

        if (!$genre) {
            throw $this->createNotFoundException("Le genre indiqué n'a pas été trouvé.");
        }

        $pages = array();
        $pages['Genres'] = "movibe_backend_genre";
        $pages[$genre->getNom()] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Genre:show.html.twig', array(
            'genre'      => $genre
        ));
    }

    /**
     * Displays a form to edit an existing Genre entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $genre = $em->getRepository('MovibeBackendBundle:Genre')->find($id);

        if (!$genre) {
            throw $this->createNotFoundException("Le genre indiqué n'a pas été trouvé.");
        }

        $editForm = $this->createEditForm($genre);

        $pages = array();
        $pages['Genres'] = "movibe_backend_genre";
        $pages['Edition'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Genre:edit.html.twig', array(
            'genre'      => $genre,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Genre entity.
     *
     * @param Genre $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Genre $genre)
    {
        $form = $this->createForm(new GenreType(), $genre, array(
            'action' => $this->generateUrl('movibe_backend_genre_update', array('id' => $genre->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Edit'));

        return $form;
    }
    /**
     * Edits an existing Genre entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $genre = $em->getRepository('MovibeBackendBundle:Genre')->find($id);

        if (!$genre) {
            throw $this->createNotFoundException("Le genre indiqué n'a pas été trouvé.");
        }

        $editForm = $this->createEditForm($genre);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Le genre sélectionné a été modifié');

            return $this->redirect($this->generateUrl('movibe_backend_genre_show', array('id' => $id)));
        }

        return $this->render('MovibeBackendBundle:Genre:edit.html.twig', array(
            'genre'      => $genre,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Genre entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $genre = $em->getRepository('MovibeBackendBundle:Genre')->find($id);

        if (!$genre) {
            throw $this->createNotFoundException("Le genre indiqué n'a pas été trouvé.");
        }

        $em->remove($genre);
        $em->flush();


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(true);
        }
        else
        {
            $request->getSession()->getFlashbag()->add('message','Le genre sélectionné a été supprimé');
            return $this->redirect($this->generateUrl('movibe_backend_genre'));
        }
    }
}
