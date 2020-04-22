<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\DependencyInjection\Compiler;

use PhpGuild\RhapsodyBundle\Configuration\ConfigurationProcessor;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ConfigurationPass
 */
class ConfigurationPass implements CompilerPassInterface
{
    /**
     * process
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container): void
    {
        $definition = $container->getDefinition(ConfigurationProcessor::class);
        $definition->addMethodCall('build');
    }
}
