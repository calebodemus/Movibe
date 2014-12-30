<?php

namespace Movibe\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class AbstractController extends Controller
{
    protected $em;

    public function preExecute()
    {
        $this->em = $this->getDoctrine()->getManager();
    }

    public function pagination($data,$limit = 30)
    {
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $data,
            $this->get('request')->query->get('page', 1),
            $limit
        );

        return $pagination;
    }

    public function breadcrumb($pages=null)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('<i class="fa fa-home"></i>', $this->generateUrl('movibe_backend_homepage'));


        if (isset($pages))
        {
            foreach ($pages as $key => $value){
                if ($value != '')
                {
                    $breadcrumbs->addItem($key, $this->generateUrl($value));
                }
                else
                {
                    $breadcrumbs->addItem($key);
                }
            }

        }

    }

}
?>