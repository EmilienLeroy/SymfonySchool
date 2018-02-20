<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 20/02/2018
 * Time: 11:36
 */

namespace AppBundle\Controller\API;

use AppBundle\Entity\Show;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\Serializer\SerializerInterface;
use AppBundle\Entity\Categories;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializationContext;

/**
 * Class ShowController
 * @package AppBundle\Controller\API
 * @Route(name="api_show_")
 */
class ShowController extends Controller
{
    /**
     * @Method({"GET"})
     * @Route("/shows", name="list")
     */
    public function listAction(SerializerInterface $serializer)
    {
        $shows = $this->getDoctrine()->getRepository('AppBundle:Show')->findAll();
        $serialzationContext = SerializationContext::create();
        $data = $serializer->serialize($shows,'json',$serialzationContext->setGroups(['show']));

        return new Response($data, Response::HTTP_OK, ['Content-Type' => 'application\json']);
    }

    /**
     * @Method({"GET"})
     * @Route("/shows/{id}", name="get")
     */
    public function getAction(Show $shows, SerializerInterface $serializer)
    {
        $serialzationContext = SerializationContext::create();
        $data = $serializer->serialize($shows,'json',$serialzationContext->setGroups(['show']));

        return new Response($data, Response::HTTP_OK, ['Content-Type' => 'application\json']);
    }
}