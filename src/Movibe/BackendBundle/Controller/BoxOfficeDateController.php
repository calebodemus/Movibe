<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Entity\BoxOfficeDate;
use Movibe\BackendBundle\Form\BoxOfficeDateType;
use Movibe\BackendBundle\Form\BoxOfficeType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Movibe\BackendBundle\Entity\BoxOffice;

/**
 * BoxOfficeDate controller.
 *
 */
class BoxOfficeDateController extends AbstractController
{

    /**
     * Creates a new BoxOfficeDate entity.
     *
     */
    public function createAction(Request $request, $date)
    {
        $dt = str_replace("-","/",$date);
        $em = $this->getDoctrine()->getManager();

        $boxOfficeDate = $this->initBoxOfficeDate($dt);

        $form = $this->createCreateForm($boxOfficeDate, $date);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em->persist($boxOfficeDate);
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Un nouveau boxOffice a été créé');

            return $this->redirect($this->generateUrl('movibe_backend_boxOfficeDate_new'));
        }

        $boxOffices = $boxOfficeDate->getBoxOffices();

        return $this->render('MovibeBackendBundle:BoxOfficeDate:new.html.twig', array(
            'boxOfficeDate' => $boxOfficeDate,
            'form'   => $form->createView(),
            'boxOffices' => $boxOffices,
        ));
    }

    /**
     * Creates a form to create a BoxOffice entity.
     *
     * @param BoxOfficeDate $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(BoxOfficeDate $boxOfficeDate, $date)
    {
        $form = $this->createForm(new BoxOfficeDateType('date'), $boxOfficeDate, array(
            'action' => $this->generateUrl('movibe_backend_boxOfficeDate_create', array('date' => $date)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Ajouter'));

        return $form;
    }

    /**
     * Displays a form to create a new BoxOfficeDate entity.
     *
     */
    public function newAction()
    {

        $boxOfficeDate = $this->initBoxOfficeDate(null);

        $form   = $this->createCreateForm($boxOfficeDate, 'XXX');

        $boxOffices = $boxOfficeDate->getBoxOffices();

        $pages = array();
        $pages['Box Office'] = "movibe_backend_boxOfficeDate_new";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:BoxOfficeDate:new.html.twig', array(
            'boxOfficeDate' => $boxOfficeDate,
            'form'   => $form->createView(),
            'boxOffices' => $boxOffices,
        ));
    }

    public function initBoxOfficeDate($date)
    {
        $em = $this->getDoctrine()->getManager();

        if (isset($date))
        {

            $boxOfficeDate = $em->getRepository('MovibeBackendBundle:BoxOfficeDate')->find($date);

            if (!$boxOfficeDate)
            {
                $dt = new \Datetime($date);
                $boxOfficeDate = new BoxOfficeDate();
                $boxOfficeDate->setDateBox($dt);
            }
        }
        else
        {
            $boxOfficeDate = new BoxOfficeDate();
        }

        return $boxOfficeDate;
    }

    public function showBoxOfficesAction(Request $request, $date)
    {
        $em = $this->getDoctrine()->getManager();
        $date = str_replace("-","/",$date);
        $boxOfficedate = $em->getRepository('MovibeBackendBundle:BoxOfficeDate')->find($date);

        if (!$boxOfficedate) {
            throw $this->createNotFoundException("Le boxOffice indiqué n'a pas été trouvé.");
        }


        if ($request->isXmlHttpRequest())
        {
            if (!$boxOfficedate)
            {
                return new JsonResponse(false);
            }
            else
            {
                $boxOffices = $boxOfficedate->getBoxOffices();
                $resultat = array();

                foreach ($boxOffices as $key => $boxOffice)
                {
                    $statEntree = $em->getRepository('MovibeBackendBundle:BoxOffice')->statByFilm($boxOffice->getFilm());
                    $resultat[$key] = array('id' => $boxOffice->getId(),'film' => $boxOffice->getFilm()->getTitre(), 'entree' => $boxOffice->getEntree(), 'stat' => $statEntree);
                }
                $reponse = new JsonResponse();
                $reponse->setData(array('resultat' => $resultat));

                return $reponse;
            }
        }
    }
}
