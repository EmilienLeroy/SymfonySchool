<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 05/02/2018
 * Time: 13:50
 */

namespace AppBundle\Controller;

use AppBundle\Type\ShowType;
use AppBundle\Entity\Show;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route(name="show")
 */
class ShowController extends Controller
{
    /**
     * @Route("/show",name="_list")
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
     * @Route("/create",name="_create")
     */
    public function createAction(Request $request)
    {
        $show = new Show();
        $form = $this->createForm(ShowType::class, $show);

        $form->handleRequest($request);
        if($form->isValid()){

            $generatedFileName = time().''.$show->getCategories()->getName().'.'.$show->getImage()->guessClientExtension();
            $path = $this->getParameter('kernel.project_dir').'/web'.$this->getParameter('upload_directory_file');


            $show->getImage()->move($path, $generatedFileName);

            $show->setImage($generatedFileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($show);
            $em->flush();

            $this->addFlash('success','victoire ehehe');

            return $this->redirectToRoute('show_list');
        }
        return $this->render('show/create.html.twig',['showForm'=>$form->createView()]);
    }
}