<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\DependencyInjection;

use PhpGuild\ResourceBundle\DependencyInjection\ResourceConfigurationTrait;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 */
class Configuration implements ConfigurationInterface
{
    use ResourceConfigurationTrait;

    /**
     * getConfigTreeBuilder
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('rhapsody');
        $rootNode = $treeBuilder->getRootNode();

        $this->addResourceConfiguration($rootNode);

        return $treeBuilder;
    }
}
