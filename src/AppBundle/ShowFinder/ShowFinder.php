<?php


namespace AppBundle\ShowFinder;


class ShowFinder
{

    private $finders;

    public function searchByName($query)
    {
        $tmp = [];
        foreach ($this->finders as $finder){
            $tmp[$finder->getName()] = $finder->findByName($query);
        }
        return $tmp;
    }

    public function addFinder($finder)
    {
        $this->finders[] = $finder;
    }
}