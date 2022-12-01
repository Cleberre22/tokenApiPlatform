<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;

class RequestListener
{

    // public function __construct(
    //     private Environment $twig
    // )
    // {
        
    // }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        $currentUri = $request->getRequestUri();

    
        if (str_starts_with($currentUri, "/api/")) {
            // dd("ok");
        }



    }
}