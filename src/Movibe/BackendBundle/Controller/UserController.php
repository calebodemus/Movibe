<?php

namespace Movibe\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Movibe\BackendBundle\Entity\Genre;

/**
 * Genre controller.
 *
 */
class UserController extends AbstractController
{
    /**
     * Lists all Genre entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('MovibeBackendBundle:User')->findAll();
        $pagination = $this->pagination($users,1000);

        $pages = array();
        $pages['Utilisateurs'] = "movibe_backend_user";
        $this->breadcrumb($pages);

        return $this->render('MovibeBackendBundle:User:index.html.twig', array(
            'users' => $pagination,
        ));
    }
}
