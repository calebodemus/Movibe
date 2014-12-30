<?php

namespace Movibe\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class HomeController extends AbstractController
{
    public function indexAction()
    {
        $this->breadcrumb(null);

        $jour = date('N');

        if ($jour < 3)
        {
            $differenceJourMercredi = 7 - 3 + $jour;
        }
        else
        {
            $differenceJourMercredi = $jour - 3;
        }

        $dernierMercredi = date('Y/m/d',strtotime('-' . $differenceJourMercredi . ' days'));

        $em = $this->getDoctrine()->getManager();
        $boxOfficeDate = $em->getRepository('MovibeBackendBundle:BoxOfficeDate')->find($dernierMercredi);

        $sortiesDemarrage = $em->getRepository('MovibeBackendBundle:BoxOffice')->statByDate($boxOfficeDate);

        $nbTotalFilm = $em->getRepository('MovibeBackendBundle:Film')->nombreTotalFilm();
        $inventaireNbFilmByGenres = $em->getRepository('MovibeBackendBundle:Film')->inventaireNbFilmByGenres();

        $lastCommentaire = $em->getRepository('MovibeBackendBundle:Commentaire')->lastCommentaire();
        $lastMedia = $em->getRepository('MovibeBackendBundle:Media')->lastBandeAnnonce();

        $tabClassColor = ["bg-pink",
                            "bg-blue",
                            "bg-dark-blue",
                            "bg-green",
                            "bg-green-alt",
                            "bg-acid-green",
                            "bg-yellow",
                            "bg-yellow-muted",
                            "bg-purple",
                            "bg-grey",
                            "bg-cold-grey",
                            "bg-dark-cold-grey",
                            "bg-orange",
                            "bg-red",
                            "bg-dark-red",
                            "bg-black",
                            "bg-marine"];

        $today = new \Datetime('now');
        $annee  = $today->format('Y');
        $allGenres = $em->getRepository('MovibeBackendBundle:BoxOffice')->allGenres($annee);

        return $this->render('MovibeBackendBundle:Home:index.html.twig', array(
            'sortiesDemarrage' => $sortiesDemarrage,
            'allGenres' => $allGenres,
            'inventaireNbFilmByGenres' => $inventaireNbFilmByGenres,
            'nbTotalFilm' => $nbTotalFilm,
            'tabClassColor' => $tabClassColor,
            'lastCommentaire' => $lastCommentaire,
            'lastMedia' => $lastMedia,
        ));
    }

    public function statGenreAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $em = $this->getDoctrine()->getManager();
            $today = new \Datetime('now');
            $annee  = $today->format('Y');
            $resultat = $em->getRepository('MovibeBackendBundle:BoxOffice')->statByGenre($annee);

            $response = new JsonResponse();
            $response->setData(array(
                'resultat' => $resultat,
            ));

            return $response;
        }
    }

    public function statHomeAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $em = $this->getDoctrine()->getManager();
            $today = new \Datetime('now');
            $annee  = $today->format('Y');
            $statGenre= $em->getRepository('MovibeBackendBundle:BoxOffice')->statByGenre($annee);

            $dateDebut = $em->getRepository('MovibeBackendBundle:BoxOfficeDate')->dateTroisMois();
            $statBoxOfficeFilm = $em->getRepository('MovibeBackendBundle:BoxOffice')->boxOfficeFilm($dateDebut);

            $response = new JsonResponse();
            $response->setData(array(
                'statGenre' => $statGenre,
                'statBoxOfficeFilm' => $statBoxOfficeFilm,
            ));

            return $response;
        }
    }


    public function setPageAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {

            $page = $request->query->get('page');

            $session = $request->getSession();

            $session->set('page', $page);

            return new JsonResponse(true);
        }
    }

    public function getPageAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $session = $request->getSession();

            $page = $session->get('page');

            if (!isset($page))
            {
                $page = 'menu-home';
            }

            $session->clear('page');

            $response = new JsonResponse();
            $response->setData(array(
                'page' => $page,
            ));
            return $response;
        }
    }
}