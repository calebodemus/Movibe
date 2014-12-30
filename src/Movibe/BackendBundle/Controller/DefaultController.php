<?php

namespace Movibe\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MovibeBackendBundle:Default:index.html.twig', array('name' => $name));
    }
}
