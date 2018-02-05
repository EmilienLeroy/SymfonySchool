<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 05/02/2018
 * Time: 13:50
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ShowController extends Controller
{
    /**
     * @Route("/show",name="show_list")
     */
    public function listAction()
    {
        return $this->render('show/list.html.twig');
    }

    public function categoriesAction()
    {
        return $this->render('show/categories.html.twig',[
            'categories' => ['Web design','HTML','EHEH','JS','CSS','TUTO']
        ]);
    }

    /**
     * @Route("/create",name="create")
     */
    public function createAction()
    {
        return $this->render('show/create.html.twig');
    }
}