<?php

namespace Movibe\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Movibe\BackendBundle\Entity\Search;

/**
 * Pays controller.
 *
 */
class SearchController extends AbstractController
{
    /**
     * Lists all Pays entities.
     *
     */
    public function indexAction(Request $request)
    {
        $recherche = $request->query->get('search');

        $search = new Search();
        $search->setCategorie('all');
        $search->setRecherche($recherche);

        $em = $this->getDoctrine()->getManager();
        $em->getRepository('MovibeBackendBundle:Search')->search($search);

        $resultats = $search->getResultat();

        $pagination = $this->pagination($resultats,20);

        $pages = array();
        $pages['Recherche'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Search:index.html.twig', array(
            'resultats' => $pagination,
        ));
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

            $result = $em->getRepository('MovibeBackendBundle:Search')->formatJson($resultat);

            $response = new JsonResponse();
            $response->setData(array(
                'resultat' => $result,
            ));

            return $response;
        }
    }
}
