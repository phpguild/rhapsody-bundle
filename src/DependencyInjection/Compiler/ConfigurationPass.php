<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\DependencyInjection\Compiler;

use PhpGuild\RhapsodyBundle\Configuration\ConfigurationHandler;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ConfigurationPass
 */
class ConfigurationPass implements CompilerPassInterface
{
    use PriorityTaggedServiceTrait;

    /**
     * process
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container): void
    {
        $configPasses = $this->findAndSortTaggedServices('rhapsody.configuration', $container);
        $definition = $container->getDefinition(ConfigurationHandler::class);

        foreach ($configPasses as $service) {
            $definition->addMethodCall('addConfiguration', [ $service ]);
        }

        $definition->addMethodCall('build');
    }
}
