<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Form\CinemaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Movibe\BackendBundle\Entity\Cinema;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Cinema controller.
 *
 */
class CinemaController extends AbstractController
{
    /**
     * Lists all Cinema entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cinemas = $em->getRepository('MovibeBackendBundle:Cinema')->findAll();
        $pagination = $this->pagination($cinemas,1000);

        $pages = array();
        $pages['Cinemas'] = "";
        $this->breadcrumb($pages);

        $session->set('menu', 'menu-ref');

        return $this->render('MovibeBackendBundle:Cinema:index.html.twig', array(
            'cinemas' => $pagination,
        ));
    }
    /**
     * Creates a new Cinema entity.
     *
     */
    public function createAction(Request $request)
    {
        $cinema = new Cinema();

        $ville_id = $request->request->get('movibe_backendbundle_cinema')['city'];
        $em = $this->getDoctrine()->getManager();
        $ville = $em->getRepository('MovibeBackendBundle:Cinema')->getVille($ville_id);

        $req = $request->request->get('movibe_backendbundle_cinema');
        $req['ville'] = $ville;
        $req['departement'] = "";
        $req['city'] = "";

        $request->request->set('movibe_backendbundle_cinema',$req);

        $form = $this->createCreateForm($cinema);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($cinema);
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Un nouveau cinema a été créé');

            return $this->redirect($this->generateUrl('movibe_backend_cinema_show', array('id' => $cinema->getId())));
        }

        return $this->render('MovibeBackendBundle:Cinema:new.html.twig', array(
            'cinema' => $cinema,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Cinema entity.
     *
     * @param Cinema $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Cinema $cinema)
    {
        $form = $this->createForm(new CinemaType(), $cinema, array(
            'action' => $this->generateUrl('movibe_backend_cinema_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Cinema entity.
     *
     */
    public function newAction()
    {
        $cinema = new Cinema();

        $form   = $this->createCreateForm($cinema);

        $pages = array();
        $pages['Cinemas'] = "movibe_backend_cinema";
        $pages['Création'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Cinema:new.html.twig', array(
            'cinema' => $cinema,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Cinema entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $cinema = $em->getRepository('MovibeBackendBundle:Cinema')->find($id);

        if (!$cinema) {
            throw $this->createNotFoundException("Le cinema indiqué n'a pas été trouvé.");
        }

        $pages = array();
        $pages['Cinemas'] = "movibe_backend_cinema";
        $pages[$cinema->getNom()] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Cinema:show.html.twig', array(
            'cinema'      => $cinema
        ));
    }

    /**
     * Displays a form to edit an existing Cinema entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $cinema = $em->getRepository('MovibeBackendBundle:Cinema')->find($id);

        if (!$cinema) {
            throw $this->createNotFoundException("Le cinema indiqué n'a pas été trouvé.");
        }

        $editForm = $this->createEditForm($cinema);

        $pages = array();
        $pages['Cinemas'] = "movibe_backend_cinema";
        $pages['Edition'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Cinema:edit.html.twig', array(
            'cinema'      => $cinema,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Cinema entity.
     *
     * @param Cinema $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Cinema $cinema)
    {
        $form = $this->createForm(new CinemaType(), $cinema, array(
            'action' => $this->generateUrl('movibe_backend_cinema_update', array('id' => $cinema->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Edit'));

        return $form;
    }
    /**
     * Edits an existing Cinema entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $cinema = $em->getRepository('MovibeBackendBundle:Cinema')->find($id);

        if (!$cinema) {
            throw $this->createNotFoundException("Le cinema indiqué n'a pas été trouvé.");
        }

        $ville_id = $request->request->get('movibe_backendbundle_cinema')['city'];
        $ville = $em->getRepository('MovibeBackendBundle:Cinema')->getVille($ville_id);

        $req = $request->request->get('movibe_backendbundle_cinema');
        $req['ville'] = $ville;
        $req['departement'] = "";
        $req['city'] = "";

        $request->request->set('movibe_backendbundle_cinema',$req);

        $editForm = $this->createEditForm($cinema);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Le cinema sélectionné a été modifié');

            return $this->redirect($this->generateUrl('movibe_backend_cinema_show', array('id' => $id)));
        }

        return $this->render('MovibeBackendBundle:Cinema:edit.html.twig', array(
            'cinema'      => $cinema,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Cinema entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $cinema = $em->getRepository('MovibeBackendBundle:Cinema')->find($id);

        if (!$cinema) {
            throw $this->createNotFoundException("Le cinema indiqué n'a pas été trouvé.");
        }

        $em->remove($cinema);
        $em->flush();


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponseJsonResponse(true);
        }
        else
        {
            $request->getSession()->getFlashbag()->add('message','Le cinema sélectionné a été supprimé');
            return $this->redirect($this->generateUrl('movibe_backend_cinema'));
        }
    }

    public function regionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $list_departement = $em->getRepository('MovibeBackendBundle:Cinema')->listDepartementByRegion($id);

        $list = array();

        foreach ($list_departement as $departement)
        {
            $dep = array();
            $dep['id'] = $departement->getId();
            $dep['nom'] = $departement->getNom();
            $dep['code'] = $departement->getCode();

            $list[] = $dep;
        }

        $response = new JsonResponse();
        $response->setData(array(
            'data' => $list,
        ));

        return $response;
    }

    public function departementAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $list_ville = $em->getRepository('MovibeBackendBundle:Cinema')->listVilleByDepartement($id);

        $list = array();

        foreach ($list_ville as $ville)
        {
            $dep = array();
            $dep['id'] = $ville->getId();
            $dep['nom'] = $ville->getNom();
            $dep['code-postal'] = $ville->getCodePostal();

            $list[] = $dep;
        }

        $response = new JsonResponse();
        $response->setData(array(
            'data' => $list,
        ));

        return $response;
    }
}
