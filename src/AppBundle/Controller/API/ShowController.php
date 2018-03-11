<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 20/02/2018
 * Time: 11:36
 */

namespace AppBundle\Controller\API;

use AppBundle\Entity\Show;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\Serializer\SerializerInterface;
use AppBundle\Entity\Categories;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializationContext;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    /**
     * @Method({"POST"})
     * @Route("/shows", name="post")
     */
    public function createAction(Request $request, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        //deserialize the body json from the request into a show entity
        $data = $serializer->deserialize($request->getContent(), Show::class, 'json');
        //Set the db source from our db
        $data->setDatasource(Show::DATA_SOURCE_DB);
        
        $error = $validator->validate($data);
        if($error->count() == 0){

            //get the category
            $category = $this->getDoctrine()
                ->getRepository(Categories::class)
                ->findOneBy(['name' => $data->getCategories()->getName()]);

            //get the user
            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(['fullname' => $data->getAuthor()->getFullname()]);

            //set the data find into the show entity
            $data->setCategories($category);
            $data->setAuthor($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();
            return new Response('OK', Response::HTTP_CREATED,['Content-Type' => 'application/json']);
        }
        return new Response('no',Response::HTTP_BAD_REQUEST,['Content-Type'=>'application/json']);
    }

    /**
     * @Method({"PUT"})
     * @Route("/shows/{id}", name="put")
     */
    public function updateAction(Show $show,Request $request, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $data = $serializer->deserialize($request->getContent(),Show::class,'json');
        $error = $validator->validate($data);

        if($error->count() == 0){
            //get the category
            if($data->getCategories() != null){
                $category = $this->getDoctrine()
                    ->getRepository(Categories::class)
                    ->findOneBy(['name' => $data->getCategories()->getName()]);
                $data->setCategories($category);
                }
            //get the user
            if($data->getAuthor() != null){
                $user = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->findOneBy(['fullname' => $data->getAuthor()->getFullname()]);
                $data->setAuthor($user);    
            }
            
            $show->updateShow($data);
            $this->getDoctrine()->getManager()->flush();
            return new Response('OK', Response::HTTP_CREATED,['Content-Type' => 'application/json']);
        }else{
            return new Response('no',Response::HTTP_BAD_REQUEST, ['Content-Type' => 'application/json']);
        }
    }

    
    /**
     * @Method({"DELETE"})
     * @Route("/shows/{id}", name="delete")
     */
    public function deleteAction($id)
    {
        $shows = $this->getDoctrine()
            ->getRepository(Show::class)
            ->findOneByid($id);
        if($shows != null){
            $this->getDoctrine()->getManager()->remove($shows);
            $this->getDoctrine()->getManager()->flush();
            return new Response('OK', Response::HTTP_CREATED,['Content-Type' => 'application/json']);    
        }else{
            return new Response('no',Response::HTTP_BAD_REQUEST, ['Content-Type' => 'application/json']);
        }
    }
}