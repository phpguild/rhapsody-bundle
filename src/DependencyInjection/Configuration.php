<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * getConfigTreeBuilder
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('rhapsody');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('contexts')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('theme')->end()
                            ->arrayNode('resources')
                                ->normalizeKeys(false)
                                ->useAttributeAsKey('name', false)
                                ->defaultValue([])
                                ->prototype('variable')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
