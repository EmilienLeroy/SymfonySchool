<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 20/02/2018
 * Time: 14:03
 */

namespace AppBundle\Controller\API;


use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializationContext;

/**
 * Class UserController
 * @package AppBundle\Controller\API
 * @Route(name="api_user_")
 */
class UserController extends Controller
{

    /**
     * @Method({"GET"})
     * @Route("/users",name="list")
     */
    public function listAction(SerializerInterface $serializer)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        $serialzationContext = SerializationContext::create();
        $data = $serializer->serialize($user,'json',$serialzationContext->setGroups(['user']));
        return new Response($data, Response::HTTP_OK, ['Content-Type' => 'application\json']);
    }

    /**
     * @Method({"GET"})
     * @Route("/users/{id}", name="get")
     */
    public function getAction(User $user,SerializerInterface $serializer)
    {
        $serialzationContext = SerializationContext::create();
        $data = $serializer->serialize($user,'json',$serialzationContext->setGroups(['user']));
        return new Response($data, Response::HTTP_OK, ['Content-Type' => 'application\json']);
    }
}