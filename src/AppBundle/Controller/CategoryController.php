<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Categories;
use AppBundle\Type\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/category", name="category_")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/create", name="create")
     */
    public function createAction(Request $request)
    {
        $category = new Categories();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('success','victoire ehehe');

            return $this->redirectToRoute('show_list');
        }
        return $this->render("category/create.html.twig",['categoryForm'=>$form->createView()]);
    }
}