<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 19/03/2018
 * Time: 13:31
 */

namespace AppBundle\Serializer\Listener;

use AppBundle\Entity\Show;
use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\PreDeserializeEvent;
use JMS\Serializer\Exception\LogicException;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\DateTime;


class ShowListener implements \JMS\Serializer\EventDispatcher\EventSubscriberInterface
{
    private $doctrine;
    private $tokenStorage;


    public function __construct(ManagerRegistry $doctrine, TokenStorageInterface $tokenStorage)
    {
        $this->doctrine = $doctrine;
        $this->tokenStorage = $tokenStorage;
    }


    public static function getSubscribedEvents()
    {
        return[
            [
                'event' => Events::PRE_DESERIALIZE,
                'method' => 'preDeserialize',
                'class' => 'AppBundle\\Entity\\Show', // if no class, subscribe to every serialization
                'format' => 'json'
            ],
        ];
    }

    public function preDeserialize(preDeserializeEvent $event)
    {
        $data = $event->getData();
        dump($data);die;
        $show = new Show();
        $show
            ->setName($data['name'])
            ->getAbstract($data['abstract'])
            ->setCountry($data['country'])
            ->setDate(new DateTime($data['date']))
            ->setImage($data['image'])
        ;

        $em = $this->getDoctrine()->getManager();

        if(!$category = $em->getRepository('AppBundle:Categoy')->findOneBy($data['category']['id'])){
            throw new  LogicException('erororor');
        }

        $show->setCategories($data['category']);

        $user = $this->tokenStorage->getUser();
        $show->setAuthor($user);
    }
}