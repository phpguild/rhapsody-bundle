<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration;

/**
 * Interface ConfigurationInterface
 */
interface ConfigurationInterface
{
    /**
     * build
     *
     * @param string $context
     * @param array  $configurationData
     *
     * @return array
     */
    public function build(string $context, array $configurationData): array;

    /**
     * isBuild
     *
     * @return bool
     */
    public function isBuild(): bool;
}
