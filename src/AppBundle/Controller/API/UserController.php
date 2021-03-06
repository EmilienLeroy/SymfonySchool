<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 20/02/2018
 * Time: 14:03
 */

namespace AppBundle\Controller\API;


use AppBundle\Entity\User;
use JMS\Serializer\DeserializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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

    /**
     * @Method({"POST"})
     * @Route("/users", name="post")
     */
    public function createAction(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, EncoderFactoryInterface $encoderFactory)
    {
        $serialzationContext = DeserializationContext::create();
        $data = $serializer->deserialize($request->getContent(),User::class,'json',$serialzationContext->setGroups(['user','user_create']));
        $error = $validator->validate($data);

        if($error->count() == 0){
            $encoder = $encoderFactory->getEncoder($data);
            $password = $encoder->encodePassword($data->getPassword(),null);
            $data->setPassword($password);
            $data->setRoles(explode(', ', $data->getRoles()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            return new Response('OK: User created', Response::HTTP_CREATED,['Content-Type' => 'application/json']);
        }
        return new Response('Error: '.$error,Response::HTTP_BAD_REQUEST, ['Content-Type' => 'application/json']);
    }

    /**
     * @Method({"PUT"})
     * @Route("/users/{id}", name="put")
     */
    public function updateAction(User $user, Request $request, SerializerInterface $serializer, ValidatorInterface $validator, EncoderFactoryInterface $encoderFactory)
    {
        $data = $serializer->deserialize($request->getContent(),User::class,'json');
        $error = $validator->validate($data);

       if($error->count() == 0){
           if($data->getPassword() != null){
                $encoder = $encoderFactory->getEncoder($user);
                $hashPassword = $encoder->encodePassword($data->getPassword(),null);
                $data->setPassword($hashPassword);
           }
           $user->updateUser($data);
           $this->getDoctrine()->getManager()->flush();
           return new Response('OK: User update', Response::HTTP_ACCEPTED,['Content-Type' => 'application/json']);
       }else{
             return new Response('Error:'.$error,Response::HTTP_BAD_REQUEST, ['Content-Type' => 'application/json']);
       }
    }

    /**
     * @Method({"DELETE"})
     * @Route("/users/{id}", name="delete")
     */
    public function deleteAction($id)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneByid($id);
        if($user != null){
            $this->getDoctrine()->getManager()->remove($user);
            $this->getDoctrine()->getManager()->flush();
            return new Response('OK: User delete', Response::HTTP_OK,['Content-Type' => 'application/json']);    
        }else{
            return new Response('Error: User not delete',Response::HTTP_BAD_REQUEST, ['Content-Type' => 'application/json']);
        }
    }
}