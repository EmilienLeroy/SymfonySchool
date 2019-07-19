<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 19/03/2018
 * Time: 15:30
 */

namespace AppBundle\Listener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiExceptionListener implements EventSubscriberInterface
{

    const EXCEPTION_CODE = 'nooooo error';

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => ['processExceptionForApi',1]
        ];
    }

    public function  processExceptionForApi(GetResponseForExceptionEvent $event)
    {

        $request = $event->getRequest();
        $routeName = $request->attributes->get('_route');
        $api = substr($routeName,0,3);

        if($api !== 'api'){
            return;
        }

        $data = [
            'code' => self::EXCEPTION_CODE,
            'message' => $event->getException()->getMessage()
        ];

        $response = new JsonResponse($data, Response::HTTP_INTERNAL_SERVER_ERROR);
        $event->setResponse($response);
    }
}