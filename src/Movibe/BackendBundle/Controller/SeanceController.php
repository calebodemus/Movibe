<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Entity\Search;
use Movibe\BackendBundle\Form\SeanceType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Movibe\BackendBundle\Entity\Seance;

/**
 * Seance controller.
 *
 */
class SeanceController extends AbstractController
{

    /**
     * Creates a new Seance entity.
     *
     */
    public function createAction(Request $request, $type)
    {
        $em = $this->getDoctrine()->getManager();

        $seance = new Seance();

        switch ($type)
        {
            case 'film':
                $element = $seance->getFilm();
                break;
            case 'cinema':
                $element = $seance->getCinema();
                    break;
        }
        $idt = $element->getId();

        $form = $this->createCreateForm($seance, $type);
        $form->handleRequest($request);

        if ($form->isValid()) {


            $em->persist($seance);
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Un nouveau seance a été créé');

            return $this->redirect($this->generateUrl('movibe_backend_seance_new', array('type' => $type, 'idt' => $idt)));
        }

        $seances = $em->getRepository('MovibeBackendBundle:Seance')->seanceByElement($type, $idt);

        return $this->render('MovibeBackendBundle:Seance:new.html.twig', array(
            'seance' => $seance,
            'form'   => $form->createView(),
            'seances' => $seances,
            'element' => $element,
            'type' => $type
        ));
    }

    /**
     * Creates a form to create a Seance entity.
     *
     * @param Seance $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Seance $seance, $type)
    {
        $form = $this->createForm(new SeanceType($type), $seance, array(
            'action' => $this->generateUrl('movibe_backend_seance_create', array('type' => $type)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Ajouter'));

        return $form;
    }

    /**
     * Displays a form to create a new Seance entity.
     *
     */
    public function newAction($type, $idt)
    {
        $seance = new Seance();

        $em = $this->getDoctrine()->getManager();

        switch ($type)
        {
            case 'film':
                $element = $em->getRepository('MovibeBackendBundle:Film')->find($idt);
                $element-> searchPromotion();
                $seance->setFilm($element);
                break;
            case 'cinema':
                $element = $em->getRepository('MovibeBackendBundle:Cinema')->find($idt);
                $seance->setCinema($element);
                break;
        }

        $seances = $em->getRepository('MovibeBackendBundle:Seance')->seanceByElement($type, $idt);

        $form   = $this->createCreateForm($seance, $type);

        $pages = array();
        $pages['Seances'] = "movibe_backend_seance";
        $pages['Création'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Seance:new.html.twig', array(
            'seance' => $seance,
            'form'   => $form->createView(),
            'seances' => $seances,
            'element' => $element,
            'type' => $type
        ));
    }

    /**
     * Displays a form to edit an existing Seance entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $seance = $em->getRepository('MovibeBackendBundle:Seance')->find($id);

        if (!$seance) {
            throw $this->createNotFoundException("Le seance indiqué n'a pas été trouvé.");
        }

        if ($seance->getFilm())
        {
            $element = $seance->getFilm();
            $type = 'film';
        }
        elseif ($seance->getPersonne())
        {
            $element = $seance->getPersonne();
            $type = 'personne';
        }

        $seances = $em->getRepository('MovibeBackendBundle:Seance')->sortDescByDate($type, $element->getId());

        $editForm = $this->createEditForm($seance);

        $pages = array();
        $pages['Regions'] = "movibe_backend_region";
        $pages['Edition'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Seance:edit.html.twig', array(
            'seance'      => $seance,
            'edit_form'   => $editForm->createView(),
            'element' => $element,
            'type' => $type,
            'seances' => $seances
        ));
    }

    /**
     * Creates a form to edit a Seance entity.
     *
     * @param Seance $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Seance $seance)
    {
        $form = $this->createForm(new SeanceType(), $seance, array(
            'action' => $this->generateUrl('movibe_backend_seance_update', array('id' => $seance->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Edit'));

        return $form;
    }
    /**
     * Edits an existing Seance entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $seance = $em->getRepository('MovibeBackendBundle:Seance')->find($id);

        if (!$seance) {
            throw $this->createNotFoundException("Le seance indiqué n'a pas été trouvé.");
        }

        $editForm = $this->createEditForm($seance);
        $editForm->handleRequest($request);

        if ($seance->getFilm())
        {
            $element = $seance->getFilm();
            $type = 'film';
        }
        elseif ($seance->getPersonne())
        {
            $element = $seance->getPersonne();
            $type = 'personne';
        }

        if ($editForm->isValid()) {
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Le seance sélectionné a été modifié');

            return $this->redirect($this->generateUrl('movibe_backend_seance_new', array('type' => $type, 'idt' => $element->getId())));
        }

        return $this->render('MovibeBackendBundle:Seance:edit.html.twig', array(
            'seance'      => $seance,
            'edit_form'   => $editForm->createView(),
            'element' => $element,
            'type' => $type
        ));
    }
    /**
     * Deletes a Seance entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $seance = $em->getRepository('MovibeBackendBundle:Seance')->find($id);

        if (!$seance) {
            throw $this->createNotFoundException("Le seance indiqué n'a pas été trouvé.");
        }

        $em->remove($seance);
        $em->flush();


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(true);
        }
        else
        {
            $request->getSession()->getFlashbag()->add('message','Le seance sélectionné a été supprimé');
            return $this->redirect($this->generateUrl('movibe_backend_seance'));
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

                    case 'cinemas':
                        while (isset($value[$i]))
                        {
                            $cinema =  $value[$i];
                            $value[$i] = $cinema->to_json();
                            $result[] = $value[$i];
                            $i++;
                        }
                        $resultat['cinemas'] = $value;
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

        return $this->render('MovibeBackendBundle:Seance:search.html.twig', array());
    }
}
