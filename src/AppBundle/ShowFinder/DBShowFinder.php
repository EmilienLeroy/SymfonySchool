<?php


namespace AppBundle\ShowFinder;

use Symfony\Bridge\Doctrine\RegistryInterface;

class DBShowFinder implements ShowFinderInterface
{
    private $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function findByName($query)
    {
        return $this->doctrine->getRepository('AppBundle:Show')->findByName($query);
    }

    public function getName()
    {
        return 'local_database';
    }
}