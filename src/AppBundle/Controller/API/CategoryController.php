<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 20/02/2018
 * Time: 11:36
 */

namespace AppBundle\Controller\API;

use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Categories;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * @Method({"GET"})
     * @Route("/categories", name="api_categories_list")
     */
    public function listAction(SerializerInterface $serializer)
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Categories')->findAll();

        $data = $serializer->serialize($categories,'json');

        return new Response($data, Response::HTTP_OK, ['Content-Type' => 'application\json']);
    }
}