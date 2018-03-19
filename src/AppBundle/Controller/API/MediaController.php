<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 19/03/2018
 * Time: 08:41
 */

namespace AppBundle\Controller\API;


use AppBundle\File\FileUploader;
use AppBundle\Entity\Media;
use AppBundle\Type\MediaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;

/**
 * @Route("/media", name="media_")
 */
class MediaController extends Controller
{
    /**
     * @Route("/")
     * @Method({"POST"})
     */
    public function uploadAction(Request $request, FileUploader $fileUploader,RouterInterface $router)
    {
        $media = new Media();
        //$form = $this->createForm(MediaType::class, $media);
        //$form->handleRequest($request);

        $media->setFile($request->files->get('file'));

        //validate media object



        $generatedFileName = $fileUploader->upload($media->getFile(),time());
        $path = $this->getParameter('upload_directory_file').'/web/'.$generatedFileName;

        $baseUrl = $router->getContext()->getScheme().'://'.$router->getContext()->getHost();

        $media->setPath($baseUrl.$path);
        $em = $this->getDoctrine()->getManager();
        $em->persist($media);
        $em->flush();
        /*
        if($form->isValid()){
            $generatedFileName = $fileUploader->upload($media->getTmpimage(),time());
            $path = $this->getParameter('upload_directory_file').'/web/'.$generatedFileName;

            $media->setImage($request->getBaseUrl(),$path);
            return new Response('Evan', Response::HTTP_CREATED,['Content-Type' => 'application/json']);
        }*/

        return new Response($media->getPath(), Response::HTTP_CREATED,['Content-Type' => 'application/json']);
    }
}