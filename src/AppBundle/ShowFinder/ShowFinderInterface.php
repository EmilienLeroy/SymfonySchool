<?php

namespace AppBundle\ShowFinder;


interface ShowFinderInterface
{
    /**
     * Returns an array of show
     * @param String $query the query typed by the user
     * @return array $result The result got from the implementation of the ShowFinder
     */
    public function findByName($query);

    /**
     * Return the same name of theimplementation of the show finder
     *
     * @Return String Same
     */
    public function getName();
}