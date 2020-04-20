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
     * @param array $configurationData
     *
     * @return array
     */
    public function build(array $configurationData): array;

    /**
     * isBuild
     *
     * @return bool
     */
    public function isBuild(): bool;
}
