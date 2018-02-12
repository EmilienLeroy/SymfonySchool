<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 12/02/2018
 * Time: 13:57
 */

namespace AppBundle\DependencyInjection;


use AppBundle\ShowFinder\ShowFinder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ShowFinderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        //Recupere la definition de showFinder pour lui ajouter les services
        $showFinderDefinition = $container->findDefinition(ShowFinder::class);

        //Recupere les ID des service ou le tags est show.finder
        $showFinderTaggedServices = $container->findTaggedServiceIds('show.finder');

        //Pour chaque service
        foreach ($showFinderTaggedServices as $showFinderTaggedServiceID => $showFinderTags){

            //Creation d'une réference (representation d'un service) avec la clé du tableau
            $service = new Reference($showFinderTaggedServiceID);

            //Ajout de la methode addFinder sur le service AppBundle\ShowFinder\Showfinder
            $showFinderDefinition->addMethodCall('addFinder',[$service]);
        }
    }
}