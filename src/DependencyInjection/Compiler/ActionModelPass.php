<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\DependencyInjection\Compiler;

use PhpGuild\RhapsodyBundle\Configuration\Handler\ActionModelHandler;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ActionModelPass
 */
class ActionModelPass implements CompilerPassInterface
{
    use PriorityTaggedServiceTrait;

    /**
     * process
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container): void
    {
        $configPasses = $this->findAndSortTaggedServices('rhapsody.action_model', $container);
        $definition = $container->getDefinition(ActionModelHandler::class);

        foreach ($configPasses as $service) {
            $definition->addMethodCall('addModel', [ $service ]);
        }
    }
}
