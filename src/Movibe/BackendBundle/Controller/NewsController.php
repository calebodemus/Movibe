<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Entity\Film;
use Movibe\BackendBundle\Entity\Personne;
use Movibe\BackendBundle\Entity\Search;
use Movibe\BackendBundle\Form\NewsType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Movibe\BackendBundle\Entity\News;

/**
 * News controller.
 *
 */
class NewsController extends AbstractController
{
    /**
     * Lists all News entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $news_list = $em->getRepository('MovibeBackendBundle:News')->findAll();
        $pagination = $this->pagination($news_list,1000);

        $pages = array();
        $pages['News'] = "movibe_backend_news";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:News:index.html.twig', array(
            'news_list' => $pagination,
        ));
    }
    /**
     * Creates a new News entity.
     *
     */
    public function createAction(Request $request, $type, $id)
    {
        $news = new News();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createCreateForm($news, $type, $id);

        switch ($type)
        {
            case 'personne':
                $personne = $em->getRepository('MovibeBackendBundle:Personne')->find($id);
                $news->addPersonne($personne);
                break;
            case 'film':
                $film = $em->getRepository('MovibeBackendBundle:Film')->find($id);
                $news->setFilm($film);
                break;
        }

        $form->handleRequest($request);

        if ($form->isValid()) {

            $news->setDateCreation(new \DateTime('now'));
            $em->persist($news);
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Une nouvelle news a été créée');

            return $this->redirect($this->generateUrl('movibe_backend_news_show', array('id' => $news->getId(), 'type' => $type, 'idt' => $id)));
        }

        return $this->render('MovibeBackendBundle:News:new.html.twig', array(
            'news' => $news,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a News entity.
     *
     * @param News $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(News $news, $type, $idt)
    {
        $form = $this->createForm(new NewsType($type,$idt), $news, array(
            'action' => $this->generateUrl('movibe_backend_news_create', array('idt' => $idt,'type' => $type)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new News entity.
     *
     */
    public function newAction($type, $idt)
    {
        $news = new News();

        $form = $this->createCreateForm($news,$type,$idt);

        $pages = array();
        $pages['News'] = "movibe_backend_news";
        $pages['Création'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:News:new.html.twig', array(
            'news' => $news,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a News entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $news = $em->getRepository('MovibeBackendBundle:News')->find($id);

        if (!$news) {
            throw $this->createNotFoundException("La news indiquée n'a pas été trouvée.");
        }

        $pages = array();
        $pages['News'] = "movibe_backend_news";
        $pages[$news->getId()] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:News:show.html.twig', array(
            'news' => $news
        ));
    }

    /**
     * Displays a form to edit an existing News entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $news = $em->getRepository('MovibeBackendBundle:News')->find($id);

        if (!$news) {
            throw $this->createNotFoundException("La news indiquée n'a pas été trouvée.");
        }

        if ($news->getFilm())
        {
            $type = 'film';
            $idt = $news->getFilm()->getId();
        }
        else
        {
            $type = 'personne';
            $personnes = $news->getPersonnes();
            $idt = $personnes[0]->getId();
        }

        $editForm = $this->createEditForm($news, $type, $idt);

        $pages = array();
        $pages['News'] = "movibe_backend_news";
        $pages['Edition'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:News:edit.html.twig', array(
            'news'      => $news,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a News entity.
     *
     * @param News $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(News $news, $type, $idt)
    {
        $form = $this->createForm(new NewsType($type,$idt), $news, array(
            'action' => $this->generateUrl('movibe_backend_news_update', array('id' => $news->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Edit'));

        return $form;
    }
    /**
     * Edits an existing News entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $news = $em->getRepository('MovibeBackendBundle:News')->find($id);

        if (!$news) {
            throw $this->createNotFoundException("La news indiquée n'a pas été trouvée.");
        }

        if ($news->getFilm())
        {
            $type = 'film';
            $idt = $news->getFilm()->getId();
        }
        else
        {
            $type = 'personne';
            $personnes = $news->getPersonnes();
            $idt = $personnes[0]->getId();
        }

        $editForm = $this->createEditForm($news, $type, $idt);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','La news sélectionnée a été modifiée');


            return $this->redirect($this->generateUrl('movibe_backend_news_show', array('id' => $id)));
        }

        return $this->render('MovibeBackendBundle:News:edit.html.twig', array(
            'news'      => $news,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a News entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('MovibeBackendBundle:News')->find($id);

        if (!$news) {
            throw $this->createNotFoundException("La news indiquée n'a pas été trouvée.");
        }

        $em->remove($news);
        $em->flush();


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(true);
        }
        else
        {
            $request->getSession()->getFlashbag()->add('message','La news sélectionnée a été supprimée');
            return $this->redirect($this->generateUrl('movibe_backend_news'));
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
        $pages['News'] = "movibe_backend_news";
        $pages['Search'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:News:search.html.twig', array());
    }

}
