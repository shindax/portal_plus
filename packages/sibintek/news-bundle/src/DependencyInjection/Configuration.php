<?php

namespace Sibintek\NewsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('news');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                    ->scalarNode('storage')
//                    ->isRequired()
                    ->defaultValue('c:/temp/storage/')
            ->end()
        ;
        return $treeBuilder;
    }
}
