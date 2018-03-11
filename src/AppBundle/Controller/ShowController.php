<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 05/02/2018
 * Time: 13:50
 */

namespace AppBundle\Controller;

use AppBundle\File\FileUploader;
use AppBundle\ShowFinder\ShowFinder;
use AppBundle\Type\ShowType;
use AppBundle\Type\SearchType;
use AppBundle\Entity\Show;
use AppBundle\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route(name="show")
 */
class ShowController extends Controller
{
    /**
     * @Route("/",name="_list")
     */
    public function listAction(Request $request, ShowFinder $showFinder)
    {
        $repo = $this->getDoctrine()->getRepository(Show::class);
        $session = $request->getSession();
        if($session->has('query_search_shows')){
            $show = $showFinder->searchByName($session->get('query_search_shows'));
            $local = $show['local_database'];
            $OMDB = $show['Api_OMD'];
            $session->remove('query_search_shows');
            return $this->render('show/list.html.twig',['show' => $local, 'OMDB' => $OMDB]);
        }else{
            $show = $repo->findAll();
            $session->remove('query_search_shows');
            return $this->render('show/list.html.twig',['show' => $show]);
        }
    }

    public function categoriesAction()
    {
        $repo = $this->getDoctrine()->getRepository(Categories::class);
        $categories = $repo->findAll();
        return $this->render('show/categories.html.twig',[
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/create",name="_create")
     */
    public function createAction(Request $request, FileUploader $fileUploader)
    {
        $show = new Show();
        $form = $this->createForm(ShowType::class, $show);

        $form->handleRequest($request);
        if($form->isValid()){

            $generatedFileName = $fileUploader->upload($show->getTmpimage(),$show->getCategories()->getName());

            $show->setImage($generatedFileName);
            $show->setDatasource(Show::DATA_SOURCE_DB);

            $show->setAuthor($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($show);
            $em->flush();

            $this->addFlash('success','Create success !');

            return $this->redirectToRoute('show_list');
        }
        return $this->render('show/create.html.twig',['showForm'=>$form->createView()]);
    }

    /**
     * @Route("/update/{id}", name="_update")
     */
    public function updateAction(Show $show, Request $request, FileUploader $fileUploader)
    {
        $showForm = $this->createForm(ShowType::class, $show, ['validation_groups'=> ['update']]);

        $showForm->handleRequest($request);

        if($showForm->isValid()){
            if($show->getTmpimage() != null){
                $generatedFileName = $fileUploader->upload($show->getTmpimage(),$show->getCategories()->getName());
                $show->setImage($generatedFileName);   
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($show);
            $em->flush();
            $this->addFlash('success', 'Update success !');

            return $this->redirectToRoute('show_list');
        }

        return $this->render('show/create.html.twig', ['showForm'=>$showForm->createView()]);
    }

    /**
     * @Route("/update", name="_list_update")
     */
    public function listupdateAction()
    {
        $repo = $this->getDoctrine()->getRepository(Show::class);
        $show = $repo->findAll();
        //dump($show);die;
        return $this->render('show/list_update.html.twig',['show'=>$show]);
    }

    /**
     * @Route(name="_search")
     */
    public function searchAction(Request $request)
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        return $this->render('_includes/search.html.twig',['showForm'=>$form->createView()]);
    }

    /**
     * @Route("/find", name="_find")
     */
    public function findAction(Request $request )
    {
        /*
        $find = $request->request->get('search');
        $repo = $this->getDoctrine()->getRepository(Show::class);
        $show = $repo->findBy(
            ['name' => $find['name']]
        );
        if(empty($show)) $this->addFlash('error', 'No show find sorry...');
        return $this->render('show/list.html.twig',['show' => $show]);
        */
        $request->getSession()->set('query_search_shows',$request->request->get('search'));
        return $this->redirectToRoute('show_list');
    }

    /**
     * @Route("/delete", name="_delete")
     */
    public function deleteAction(Request $request,CsrfTokenManagerInterface $crsfTokenMan)
    {
        $doctrine = $this->getDoctrine();
        $delete = $request->request->get('show_id');
        $repo = $doctrine->getRepository(Show::class);
        $show = $repo->findOneById($delete);

        if(empty($show)){
            throw new NotFoundHttpException(sprintf('error'));
        }

        $crsfToken = new CsrfToken('delete_show',$request->request->get('_csrf_token'));

        if($crsfTokenMan->isTokenValid($crsfToken)){
            $doctrine->getManager()->remove($show);
            $doctrine->getManager()->flush();
            $this->addFlash('success','Delete success');
        }else{
            $this->addFlash('error','Token is not okay');
        }


        return $this->redirectToRoute('show_list');

    }

}