<?php

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use AppBundle\Type\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;


/**
 * Class UserController
 * @package AppBundle\Controller
 * @Route("/user", name="user_")
 */
class UserController extends Controller
{
    /**
     * @Route("/create",name="create")
     */
    public function createAction(Request $request, EncoderFactoryInterface $encoderFactory)
    {
        $user = new User();
        $userform = $this->createForm(UserType::class,$user);

        $userform->handleRequest($request);

        if($userform->isValid()){
            $em = $this->getDoctrine()->getManager();

            $encoder = $encoderFactory->getEncoder($user);
            $hashPassword = $encoder->encodePassword($user->getPassword(),null);
            $user->setPassword($hashPassword);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success','User create successfully');

            return $this->redirectToRoute('show_list');
        }

        return $this->render('user/create.html.twig',['userForm' => $userform->createView()]);
    }

}