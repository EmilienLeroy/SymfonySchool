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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;


/**
 * Class CategoryController
 * @package AppBundle\Controller\API
 * @Route(name="api_categories_")
 */
class CategoryController extends Controller
{
    /**
     * @Method({"GET"})
     * @Route("/categories", name="list")
     */
    public function listAction(SerializerInterface $serializer)
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Categories')->findAll();

        $data = $serializer->serialize($categories,'json');

        return new Response($data, Response::HTTP_OK, ['Content-Type' => 'application\json']);
    }

    /**
     * @Method({"GET"})
     * @Route("/categories/{id}", name="get")
     */
    public function getAction(Categories $categories, SerializerInterface $serializer)
    {
        $data = $serializer->serialize($categories,'json');

        return new Response($data, Response::HTTP_OK, ['Content-Type' => 'application\json']);
    }

    /**
     * @Method({"POST"})
     * @Route("/categories", name="post")
     */
    public function createAction(Request $request, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $data = $serializer->deserialize($request->getContent(), Categories::class, 'json');

        $error = $validator->validate($data);
        if($error->count() == 0){
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            return new Response('OK', Response::HTTP_CREATED,['Content-Type' => 'application/json']);
        }
        return new Response('no',Response::HTTP_BAD_REQUEST, ['Content-Type' => 'application/json']);
    }

    /**
     * @Method({"PUT"})
     * @Route("/categories/{id}", name="put")
     */
    public function updateAction(Categories $categories,Request $request, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $data = $serializer->deserialize($request->getContent(),Categories::class,'json');
        $error = $validator->validate($data);

        if($error->count() == 0){
            $categories->updateCategories($data);
            $this->getDoctrine()->getManager()->flush();
            return new Response('OK', Response::HTTP_CREATED,['Content-Type' => 'application/json']);
        }
        return new Response('no',Response::HTTP_BAD_REQUEST, ['Content-Type' => 'application/json']);
    }
}