<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 19/02/2018
 * Time: 11:53
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


/**
 * Class LoginController
 * @package AppBundle\Controller
 * @Route(name="security_")
 */
class LoginController extends Controller
{
    /**
     * @Route("/login",name="login")
     */
    public function loginAction(AuthenticationUtils $authUtils)
    {
        return $this->render('security/login.html.twig',[
            'error' => $authUtils->getLastAuthenticationError(),
            'user' => $authUtils->getLastUsername()
        ]);
    }

    /**
     * @Route("/login_check",name="login_check")
     */
    public function loginCheckAction()
    {
        //nothing
    }

    /**
     * @Route("/logout",name="logout")
     */
    public function logoutAction()
    {

    }
}