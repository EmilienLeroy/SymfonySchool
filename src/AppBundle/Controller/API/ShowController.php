<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 20/02/2018
 * Time: 11:36
 */

namespace AppBundle\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Serializer\SerializerInterface;
use AppBundle\Entity\Categories;
use Symfony\Component\HttpFoundation\Response;

class ShowController extends Controller
{
    /**
     * @Method({"GET"})
     * @Route("/shows", name="api_show_list")
     */
    public function listAction(SerializerInterface $serializer)
    {
        $shows = $this->getDoctrine()->getRepository('AppBundle::Show')->findAll();

        $data = $serializer->serialize($shows, 'json');

        return new Response($data);
    }
}