<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Form\PersonneType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Movibe\BackendBundle\Entity\Personne;

/**
 * Personne controller.
 *
 */
class PersonneController extends AbstractController
{
    /**
     * Lists all Personne entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $personnes = $em->getRepository('MovibeBackendBundle:Personne')->findAll();

        foreach ($personnes as $personne)
        {
            $tab = $em->getRepository('MovibeBackendBundle:Image')->promotionPersonne($personne->getId());
            $promotion = $tab[0];
            $personne->setPromotion($promotion);
        }

        $pagination = $this->pagination($personnes,1000);

        $pages = array();
        $pages['Personnes'] = "movibe_backend_personne";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Personne:index.html.twig', array(
            'personnes' => $pagination,
        ));
    }
    /**
     * Creates a new Personne entity.
     *
     */
    public function createAction(Request $request)
    {
        $personne = new Personne();
        $em = $this->getDoctrine()->getManager();


        if (isset($request->request->get('movibe_backendbundle_personne')['cityNaissance']))
        {
            $ville_id = $request->request->get('movibe_backendbundle_personne')['cityNaissance'];

            $ville = $em->getRepository('MovibeBackendBundle:Ville')->getVille($ville_id);

            $req = $request->request->get('movibe_backendbundle_personne');
            $req['villeNaissance'] = $ville;
            $req['regionNaissance'] = "";
            $req['departementNaissance'] = "";
            $req['cityNaissance'] = "";

            $request->request->set('movibe_backendbundle_personne',$req);
        }

        $form = $this->createCreateForm($personne);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $images = $personne->getImages();
            foreach ($images as $image)
            {
                $car_replace = array(':','\\','/','?','<','>','"','*','|');
                $titre = str_replace($car_replace,' ',$personne->getPrenom() . ' ' . $personne->getNom());
                $image->setFolder("Personne/" . $titre);
            }


            $em->persist($personne);
            $em->flush();

            if ($images)
            {
                foreach ($images as $image)
                {
                    $image->addPersonne($personne);
                    $em->persist($image);
                    $em->flush();
                }
            }

            $request->getSession()->getFlashbag()->add('message','Une nouvelle personne a été créée');

            return $this->redirect($this->generateUrl('movibe_backend_personne_show', array('id' => $personne->getId())));
        }

        return $this->render('MovibeBackendBundle:Personne:new.html.twig', array(
            'personne' => $personne,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Personne entity.
     *
     * @param Personne $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Personne $personne)
    {
        $form = $this->createForm(new PersonneType(), $personne, array(
            'action' => $this->generateUrl('movibe_backend_personne_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Personne entity.
     *
     */
    public function newAction()
    {
        $personne = new Personne();

        $form   = $this->createCreateForm($personne);

        $pages = array();
        $pages['Personnes'] = "movibe_backend_personne";
        $pages['Création'] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Personne:new.html.twig', array(
            'personne' => $personne,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Personne entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $personne = $em->getRepository('MovibeBackendBundle:Personne')->find($id);

        if (!$personne) {
            throw $this->createNotFoundException("La personne indiquée n'a pas été trouvée.");
        }

        foreach ($personne->getCastings() as $casting)
        {
            $casting->getFilm()->searchPromotion();
        }

        $personne->searchPromotion();

        $tab= $em->getRepository('MovibeBackendBundle:Image')->promotionPersonne($id);
        $promotion = $tab[0];

        $autres = $em->getRepository('MovibeBackendBundle:Image')->autrePersonne($id);

        $pages = array();
        $pages['Personnes'] = "movibe_backend_personne";
        $pages[$personne->getPrenom() . " " . $personne->getNom()] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Personne:show.html.twig', array(
            'personne' => $personne, 'promotion' => $promotion, 'autres' => $autres
        ));
    }

    /**
     * Displays a form to edit an existing Personne entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $personne = $em->getRepository('MovibeBackendBundle:Personne')->find($id);

        if (!$personne) {
            throw $this->createNotFoundException("La personne indiquée n'a pas été trouvée.");
        }


        $editForm = $this->createEditForm($personne);

        $pages = array();
        $pages['Personnes'] = "movibe_backend_personne";
        $pages[$personne->getPrenom() . " " . $personne->getNom()] = "";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:Personne:edit.html.twig', array(
            'personne'      => $personne,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Personne entity.
     *
     * @param Personne $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Personne $personne)
    {
        $form = $this->createForm(new PersonneType(), $personne, array(
            'action' => $this->generateUrl('movibe_backend_personne_update', array('id' => $personne->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Edit'));

        return $form;
    }
    /**
     * Edits an existing Personne entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $personne = $em->getRepository('MovibeBackendBundle:Personne')->find($id);

        $old_images = clone $personne->getImages();

        if (!$personne) {
            throw $this->createNotFoundException("La personne indiquée n'a pas été trouvée.");
        }

        $editForm = $this->createEditForm($personne);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $images = $personne->getImages();
            foreach ($images as $image)
            {
                $car_replace = array(':','\\','/','?','<','>','"','*','|');
                $titre = str_replace($car_replace,' ',$personne->getPrenom() . ' ' . $personne->getNom());
                $image->setFolder("Personne/" . $titre);
            }

            $em->flush();

            if ($images)
            {
                foreach ($images as $image)
                {
                    $test = $image->verifPersonne($personne);

                    if (!$test)
                    {
                        $image->addPersonne($personne);
                        $em->persist($image);
                        $em->flush();
                    }
                }
            }

            if ($old_images)
            {
                foreach ($old_images as $old_image)
                {
                    $test = $personne->verifImage($old_image);
                    if (!$test)
                    {
                        $old_image->removePersonne($personne);
                        $em->remove($old_image);
                        $em->flush();
                    }
                }
            }

            $request->getSession()->getFlashbag()->add('message','La personne sélectionnée a été modifiée');

            return $this->redirect($this->generateUrl('movibe_backend_personne_show', array('id' => $id)));
        }

        return $this->render('MovibeBackendBundle:Personne:edit.html.twig', array(
            'personne'      => $personne,
            'edit_form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a Personne entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $personne = $em->getRepository('MovibeBackendBundle:Personne')->find($id);

        if (!$personne) {
            throw $this->createNotFoundException("La personne indiquée n'a pas été trouvée.");
        }

        $images = $personne->getImages();

        foreach ($images as $img)
        {
            $car_replace = array(':','\\','/','?','<','>','"','*','|');
            $titre = str_replace($car_replace,' ',$personne->getPrenom() . ' ' . $personne->getNom());
            $img->setFolder("Personne/" . $titre);
        }

        $em->remove($personne);
        $em->flush();


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(true);
        }
        else
        {
            $request->getSession()->getFlashbag()->add('message','La personne sélectionnée a été supprimée');
            return $this->redirect($this->generateUrl('movibe_backend_personne'));
        }
    }

    public function selectAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $personne = $em->getRepository('MovibeBackendBundle:Personne')->find($id);

        if (!$personne) {
            throw $this->createNotFoundException("La personne indiquée n'a pas été trouvée.");
        }

        $tab= $em->getRepository('MovibeBackendBundle:Image')->promotionPersonne($id);
        $promotion = $tab[0];

        if ($request->isXmlHttpRequest())
        {
            $response = new JsonResponse();
             $response->setData(array(
                'data' => $promotion->getWebPath('small'),
            ));

            return $response;
        }
    }

    public function paysAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $list_region = $em->getRepository('MovibeBackendBundle:Region')->listRegionByPays($id);

        $list = array();

        foreach ($list_region as $region)
        {
            $reg = array();
            $reg['id'] = $region->getId();
            $reg['nom'] = $region->getNom();

            $list[] = $reg;
        }

        $response = new JsonResponse();
        $response->setData(array(
            'data' => $list,
        ));

        return $response;
    }


    public function regionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $list_departement = $em->getRepository('MovibeBackendBundle:Departement')->listDepartementByRegion($id);

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
        $list_ville = $em->getRepository('MovibeBackendBundle:Ville')->listVilleByDepartement($id);

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
