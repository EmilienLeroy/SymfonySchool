<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 19/03/2018
 * Time: 13:31
 */

namespace AppBundle\Serializer\Handler;


use JMS\Serializer\GraphNavigator;
use JMS\Serializer\JsonDeserializationVisitor;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ShowHandler implements SubscriberInterface
{
    private $doctrine;
    private $tokenStorage;


    public function __construct(ManagerRegistry $doctrine, TokenStorageInterface $tokenStorage)
    {
        $this->doctrine = $doctrine;
        $this->tokenStorage = $tokenStorage;
    }

    public function getSubscribingMethods()
    {

        return[
            [
                'event' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'method' => 'deserialize',
                'type' => 'AppBundle\Entity\Show', // if no class, subscribe to every serialization
                'format' => 'json'
            ],
        ];
    }

    public function deserialize(JsonDeserializationVisitor $deserializationVisitor, $data)
    {
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

        $show->setCategories($category);

        $user = $this->tokenStorage->getToken()->getUser();
        $show->setAuthor($user);

        return $show;
    }
}