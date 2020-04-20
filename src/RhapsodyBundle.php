<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle;

use PhpGuild\RhapsodyBundle\Configuration\ConfigurationInterface;
use PhpGuild\RhapsodyBundle\DependencyInjection\Compiler\ConfigurationPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class RhapsodyBundle
 */
class RhapsodyBundle extends Bundle
{
    /**
     * build
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container): void
    {
        $container
            ->registerForAutoconfiguration(ConfigurationInterface::class)
            ->addTag('rhapsody.configuration')
        ;
        $container->addCompilerPass(new ConfigurationPass());
    }
}
