<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Entity\Search;
use Movibe\BackendBundle\Form\CommentaireType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Movibe\BackendBundle\Entity\Commentaire;

/**
 * Commentaire controller.
 *
 */
class CommentaireController extends AbstractController
{

    /**
     * Creates a new Commentaire entity.
     *
     */
    public function createAction(Request $request, $type, $idt)
    {
        $em = $this->getDoctrine()->getManager();

        $commentaire = new Commentaire();

        $form = $this->createCreateForm($commentaire, $type, $idt);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $commentaire->setDateCreation(new \DateTime('now'));
            $commentaire->setDateModification(new \DateTime('now'));
            $commentaire->setVotePour(0);
            $commentaire->setVoteContre(0);
            $commentaire->setUser($this->getUser());

            switch ($type)
            {
                case 'personne':
                    $commentaire->setPersonne($em->getRepository('MovibeBackendBundle:Personne')->find($idt));
                    break;
                case 'film':
                    $commentaire->setFilm($em->getRepository('MovibeBackendBundle:Film')->find($idt));
                    break;
            }


            $em->persist($commentaire);
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Un nouveau commentaire a été créé');

            return $this->redirect($this->generateUrl('movibe_backend_commentaire_new', array('type' => $type, 'idt' => $idt)));
        }

        $commentaires = $em->getRepository('MovibeBackendBundle:Commentaire')->sortDescByDate($type, $idt);

        switch ($type)
        {
            case 'film':
                $element = $em->getRepository('MovibeBackendBundle:Film')->find($idt);
                break;
            case 'personne':
                $element = $em->getRepository('MovibeBackendBundle:Personne')->find($idt);
                break;
        }

        return $this->render('MovibeBackendBundle:Commentaire:new.html.twig', array(
            'commentaire' => $commentaire,
            'form'   => $form->createView(),
            'type' => $type,
            'commentaires' => $commentaires,
            'element' => $element
        ));
    }

    /**
     * Creates a form to create a Commentaire entity.
     *
     * @param Commentaire $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Commentaire $commentaire, $type, $idt)
    {
        $form = $this->createForm(new CommentaireType(), $commentaire, array(
            'action' => $this->generateUrl('movibe_backend_commentaire_create', array('idt' => $idt,'type' => $type)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Ajouter'));

        return $form;
    }

    /**
     * Displays a form to create a new Commentaire entity.
     *
     */
    public function newAction($type, $idt)
    {
        $commentaire = new Commentaire();

        $em = $this->getDoctrine()->getManager();

        switch ($type)
        {
            case 'film':
                $element = $em->getRepository('MovibeBackendBundle:Film')->find($idt);
                break;
            case 'personne':
                $element = $em->getRepository('MovibeBackendBundle:Personne')->find($idt);
                break;
        }

        $commentaires = $em->getRepository('MovibeBackendBundle:Commentaire')->sortDescByDate($type, $idt);
        $element-> searchPromotion();
        $form   = $this->createCreateForm($commentaire, $type, $idt);

        $pages = array();
        $pages['Commentaires'] = "movibe_backend_commentaire_search";
        $pages['Création'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Commentaire:new.html.twig', array(
            'commentaire' => $commentaire,
            'form'   => $form->createView(),
            'commentaires' => $commentaires,
            'element' => $element,
            'type' => $type
        ));
    }

    /**
     * Displays a form to edit an existing Commentaire entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $commentaire = $em->getRepository('MovibeBackendBundle:Commentaire')->find($id);

        if (!$commentaire) {
            throw $this->createNotFoundException("Le commentaire indiqué n'a pas été trouvé.");
        }

        if ($commentaire->getFilm())
        {
            $element = $commentaire->getFilm();
            $type = 'film';
        }
        elseif ($commentaire->getPersonne())
        {
            $element = $commentaire->getPersonne();
            $type = 'personne';
        }

        $commentaires = $em->getRepository('MovibeBackendBundle:Commentaire')->sortDescByDate($type, $element->getId());

        $editForm = $this->createEditForm($commentaire);

        $pages = array();
        $pages['Commentaires'] = "movibe_backend_commentaire_search";
        $pages['Edition'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Commentaire:edit.html.twig', array(
            'commentaire'      => $commentaire,
            'edit_form'   => $editForm->createView(),
            'element' => $element,
            'type' => $type,
            'commentaires' => $commentaires
        ));
    }

    /**
     * Creates a form to edit a Commentaire entity.
     *
     * @param Commentaire $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Commentaire $commentaire)
    {
        $form = $this->createForm(new CommentaireType(), $commentaire, array(
            'action' => $this->generateUrl('movibe_backend_commentaire_update', array('id' => $commentaire->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Edit'));

        return $form;
    }
    /**
     * Edits an existing Commentaire entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $commentaire = $em->getRepository('MovibeBackendBundle:Commentaire')->find($id);

        if (!$commentaire) {
            throw $this->createNotFoundException("Le commentaire indiqué n'a pas été trouvé.");
        }

        $editForm = $this->createEditForm($commentaire);
        $editForm->handleRequest($request);

        if ($commentaire->getFilm())
        {
            $element = $commentaire->getFilm();
            $type = 'film';
        }
        elseif ($commentaire->getPersonne())
        {
            $element = $commentaire->getPersonne();
            $type = 'personne';
        }

        if ($editForm->isValid()) {
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Le commentaire sélectionné a été modifié');

            return $this->redirect($this->generateUrl('movibe_backend_commentaire_new', array('type' => $type, 'idt' => $element->getId())));
        }

        return $this->render('MovibeBackendBundle:Commentaire:edit.html.twig', array(
            'commentaire'      => $commentaire,
            'edit_form'   => $editForm->createView(),
            'element' => $element,
            'type' => $type
        ));
    }
    /**
     * Deletes a Commentaire entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository('MovibeBackendBundle:Commentaire')->find($id);

        if (!$commentaire) {
            throw $this->createNotFoundException("Le commentaire indiqué n'a pas été trouvé.");
        }

        $em->remove($commentaire);
        $em->flush();


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(true);
        }
        else
        {
            $request->getSession()->getFlashbag()->add('message','Le commentaire sélectionné a été supprimé');
            return $this->redirect($this->generateUrl('movibe_backend_commentaire'));
        }
    }

    public function searchAction(Request $request)
    {

        if ($request->isXmlHttpRequest())
        {
            $search = new Search();

            $search->setCategorie($request->query->get('categorie'));
            $search->setRecherche($request->query->get('recherche'));

            $em = $this->getDoctrine()->getManager();
            $em->getRepository('MovibeBackendBundle:Search')->search($search);

            $resultat = $search->getResultat();
            $result = array();

            foreach ($resultat as $key => $value)
            {
                $i=0;
                switch ($key)
                {
                    case 'films':
                        while (isset($value[$i]))
                        {
                            $film =  $value[$i];
                            $film->searchPromotion();
                            $value[$i] = $film->to_json();
                            $result[] = $value[$i];
                            $i++;
                        }
                        $resultat['films'] = $value;
                        break;

                    case 'personnes':
                        while (isset($value[$i]))
                        {
                            $personne =  $value[$i];
                            $personne->searchPromotion();
                            $value[$i] = $personne->to_json();
                            $result[] = $value[$i];
                            $i++;
                        }
                        $resultat['personnes'] = $value;
                        break;

                    case 'users':
                        break;
                }
            }


            $response = new JsonResponse();
            $response->setData(array(
                'resultat' => $result,
            ));

            return $response;
        }

        $pages = array();
        $pages['Commentaires'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Commentaire:search.html.twig', array());
    }
}
