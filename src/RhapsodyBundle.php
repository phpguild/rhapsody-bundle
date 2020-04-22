<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle;

use PhpGuild\RhapsodyBundle\Configuration\Model\Action\ActionInterface;
use PhpGuild\RhapsodyBundle\DependencyInjection\Compiler\ActionModelPass;
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
            ->registerForAutoconfiguration(ActionInterface::class)
            ->addTag('rhapsody.action_model')
        ;
        $container->addCompilerPass(new ActionModelPass());

        $container->addCompilerPass(new ConfigurationPass());
    }
}
