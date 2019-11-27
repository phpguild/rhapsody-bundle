<?php

namespace PhpGuild\RhapsodyBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
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
        $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver([
            realpath(__DIR__ . '/Resources/config/doctrine/mapping') => __NAMESPACE__ . '\Entity',
        ]));
    }
}
