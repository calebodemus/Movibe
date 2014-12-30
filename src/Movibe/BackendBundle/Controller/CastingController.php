<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Form\CastingType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Movibe\BackendBundle\Entity\Casting;

/**
 * Casting controller.
 *
 */
class CastingController extends AbstractController
{
    /**
     * Lists all Casting entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $castings = $em->getRepository('MovibeBackendBundle:Casting')->findAll();


        return $this->render('MovibeBackendBundle:Casting:index.html.twig', array(
            'castings' => $castings,
        ));
    }
    /**
     * Creates a new Casting entity.
     *
     */
    public function createAction(Request $request)
    {
        $casting = new Casting();

        $ville_id = $request->request->get('movibe_backendbundle_casting')['city'];
        $em = $this->getDoctrine()->getManager();
        $ville = $em->getRepository('MovibeBackendBundle:Casting')->getVille($ville_id);

        $req = $request->request->get('movibe_backendbundle_casting');
        $req['ville'] = $ville;
        $req['departement'] = "";
        $req['city'] = "";

        $request->request->set('movibe_backendbundle_casting',$req);

        $form = $this->createCreateForm($casting);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($casting);
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Un nouveau casting a été créé');

            return $this->redirect($this->generateUrl('movibe_backend_casting_show', array('id' => $casting->getId())));
        }

        return $this->render('MovibeBackendBundle:Casting:new.html.twig', array(
            'casting' => $casting,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Casting entity.
     *
     * @param Casting $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Casting $casting)
    {
        $form = $this->createForm(new CastingType(), $casting, array(
            'action' => $this->generateUrl('movibe_backend_casting_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Casting entity.
     *
     */
    public function newAction()
    {
        $casting = new Casting();

        $form   = $this->createCreateForm($casting);

        return $this->render('MovibeBackendBundle:Casting:new.html.twig', array(
            'casting' => $casting,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Casting entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $casting = $em->getRepository('MovibeBackendBundle:Casting')->find($id);

        if (!$casting) {
            throw $this->createNotFoundException("Le casting indiqué n'a pas été trouvé.");
        }

        return $this->render('MovibeBackendBundle:Casting:show.html.twig', array(
            'casting'      => $casting
        ));
    }

    /**
     * Displays a form to edit an existing Casting entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $casting = $em->getRepository('MovibeBackendBundle:Casting')->find($id);

        if (!$casting) {
            throw $this->createNotFoundException("Le casting indiqué n'a pas été trouvé.");
        }


        $editForm = $this->createEditForm($casting);

        return $this->render('MovibeBackendBundle:Casting:edit.html.twig', array(
            'casting'      => $casting,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Casting entity.
     *
     * @param Casting $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Casting $casting)
    {
        $form = $this->createForm(new CastingType(), $casting, array(
            'action' => $this->generateUrl('movibe_backend_casting_update', array('id' => $casting->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Edit'));

        return $form;
    }
    /**
     * Edits an existing Casting entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $casting = $em->getRepository('MovibeBackendBundle:Casting')->find($id);

        if (!$casting) {
            throw $this->createNotFoundException("Le casting indiqué n'a pas été trouvé.");
        }

        $ville_id = $request->request->get('movibe_backendbundle_casting')['city'];
        $ville = $em->getRepository('MovibeBackendBundle:Casting')->getVille($ville_id);

        $req = $request->request->get('movibe_backendbundle_casting');
        $req['ville'] = $ville;
        $req['departement'] = "";
        $req['city'] = "";

        $request->request->set('movibe_backendbundle_casting',$req);

        $editForm = $this->createEditForm($casting);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Le casting sélectionné a été modifié');

            return $this->redirect($this->generateUrl('movibe_backend_casting_show', array('id' => $id)));
        }

        return $this->render('MovibeBackendBundle:Casting:edit.html.twig', array(
            'casting'      => $casting,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Casting entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $casting = $em->getRepository('MovibeBackendBundle:Casting')->find($id);

        if (!$casting) {
            throw $this->createNotFoundException("Le casting indiqué n'a pas été trouvé.");
        }

        $em->remove($casting);
        $em->flush();


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponseJsonResponse(true);
        }
        else
        {
            $request->getSession()->getFlashbag()->add('message','Le casting sélectionné a été supprimé');
            return $this->redirect($this->generateUrl('movibe_backend_casting'));
        }
    }

    public function regionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $list_departement = $em->getRepository('MovibeBackendBundle:Casting')->listDepartementByRegion($id);

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
        $list_ville = $em->getRepository('MovibeBackendBundle:Casting')->listVilleByDepartement($id);

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
