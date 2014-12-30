<?php


namespace Movibe\BackendBundle\Listener;



use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class PreMethodListener
{
    public function preMethod(FilterControllerEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST == $event->getRequestType())
        {
            $controller = $event->getController();
            if (isset($controller[0]))
            {
                $controller = $controller[0];
                if (method_exists($controller, "preExecute"))
                {
                    $controller->preExecute();
                }
            }
        }

    }
}