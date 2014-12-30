<?php

namespace Movibe\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityRepository;

use Movibe\BackendBundle\Entity\Metier;
use Movibe\BackendBundle\Form\MetierType;

/**
 * Metier controller.
 *
 */
class MetierController extends AbstractController
{

    protected $ind;

    public function preExecute()
    {
        $request = $this->get('request_stack')->getCurrentRequest();
        $session = $request->getSession();
        $this->ind = $session->get('metier');

    }


    /**
     * Lists all Metier entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();


        if ($this->ind == true)
        {
            $metiers = $em->getRepository('MovibeBackendBundle:Metier')->showMetiers();
        }
        else
        {
            $metiers = $em->getRepository('MovibeBackendBundle:Metier')->showParents();
        }
        $pagination = $this->pagination($metiers,1000);

        $pages = array();
        $pages['Metiers'] = "movibe_backend_metier";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Metier:index.html.twig', array(
            'metiers' => $pagination,
        ));
    }
    /**
     * Creates a new Metier entity.
     *
     */
    public function createAction(Request $request)
    {
        $metier = new Metier();

        $form = $this->createCreateForm($metier);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($metier);
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Votre métier a bien été créé');

            return $this->redirect($this->generateUrl('movibe_backend_metier_show', array('id' => $metier->getId())));
        }

        return $this->render('MovibeBackendBundle:Metier:new.html.twig', array(
            'metier' => $metier,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Metier entity.
     *
     * @param Metier $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Metier $metier)
    {
        $form = $this->createForm(new MetierType(), $metier, array(
            'action' => $this->generateUrl('movibe_backend_metier_create'),
            'method' => 'POST',
        ));

        if ($this->ind == true)
        {
            $form->add('parent','entity',array(
                'class' => 'Movibe\BackendBundle\Entity\Metier',
                'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->where('u.parent is NULL')
                            ->orderBy('u.nom', 'ASC');},
                'property' => 'nom',
                'expanded' => false,
                'multiple' => false,
            ));
        }
        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Metier entity.
     *
     */
    public function newAction()
    {
        $metier = new Metier();

        $form   = $this->createCreateForm($metier);

        $pages = array();
        $pages['Metiers'] = "movibe_backend_metier";
        $pages['Ajout'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Metier:new.html.twig', array(
            'metier' => $metier,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Metier entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $metier = $em->getRepository('MovibeBackendBundle:Metier')->find($id);

        if (!$metier) {
            throw $this->createNotFoundException("Le métier n'a pas été trouvé.");
        }

        $pages = array();
        $pages['Metiers'] = "movibe_backend_metier";
        $pages[$metier->getNom()] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Metier:show.html.twig', array(
            'metier'      => $metier
        ));
    }

    /**
     * Displays a form to edit an existing Metier entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $metier = $em->getRepository('MovibeBackendBundle:Metier')->find($id);

        if (!$metier) {
            throw $this->createNotFoundException("Le métier n'a pas été trouvé.");
        }

        $editForm = $this->createEditForm($metier);

        $pages = array();
        $pages['Metiers'] = "movibe_backend_metier";
        $pages['Edition'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Metier:edit.html.twig', array(
            'metier'      => $metier,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Metier entity.
    *
    * @param Metier $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Metier $metier)
    {
        $form = $this->createForm(new MetierType(), $metier, array(
            'action' => $this->generateUrl('movibe_backend_metier_update', array('id' => $metier->getId())),
            'method' => 'POST',
        ));

        if ($this->ind == true)
        {
            $form->add('parent','entity',array(
                'class' => 'Movibe\BackendBundle\Entity\Metier',
                'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->where('u.parent is NULL')
                            ->orderBy('u.nom', 'ASC');},
                'property' => 'nom',
                'expanded' => false,
                'multiple' => false,
            ));
        }

        $form->add('submit', 'submit', array('label' => 'Edit'));

        return $form;
    }
    /**
     * Edits an existing Metier entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $metier = $em->getRepository('MovibeBackendBundle:Metier')->find($id);

        if (!$metier) {
            throw $this->createNotFoundException("Le métier n'a pas été trouvé.");
        }

        $editForm = $this->createEditForm($metier);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $request->getSession()->getFlashbag()->add('message','Votre métier a bien été modifié');

            return $this->redirect($this->generateUrl('movibe_backend_metier_show', array('id' => $id)));
        }

        return $this->render('MovibeBackendBundle:Metier:edit.html.twig', array(
            'metier'      => $metier,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Metier entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $metier = $em->getRepository('MovibeBackendBundle:Metier')->find($id);

        if (!$metier) {
            throw $this->createNotFoundException("Le métier n'a pas été trouvé.");
        }

        $em->remove($metier);
        $em->flush();

        $request->getSession()->getFlashbag()->add('message','Votre métier a bien été supprimé');


        return $this->redirect($this->generateUrl('movibe_backend_metier'));
    }

    public function metiersAction(Request $request)
    {
        $session = $request->getSession();
        $session->set('metier',1);

        $em = $this->getDoctrine()->getManager();
        $metiers = $em->getRepository('MovibeBackendBundle:Metier')->showMetiers();
        $pagination = $this->pagination($metiers,1000);

        $pages = array();
        $pages['Metiers'] = "movibe_backend_metier";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Metier:index.html.twig', array(
            'metiers' => $pagination,
        ));
    }

    public function parentsAction(Request $request)
    {
        $session = $request->getSession();
        $session->set('metier',0);

        $em = $this->getDoctrine()->getManager();
        $metiers = $em->getRepository('MovibeBackendBundle:Metier')->showParents();
        $pagination = $this->pagination($metiers,1000);

        $pages = array();
        $pages['Metiers'] = "movibe_backend_metier";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Metier:index.html.twig', array(
            'metiers' => $pagination,
        ));
    }
}
