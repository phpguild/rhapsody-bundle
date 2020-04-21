<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration;

use Doctrine\Common\Inflector\Inflector;

/**
 * Class AbstractConfiguration
 */
abstract class AbstractConfiguration implements ConfigurationInterface
{
    /** @var bool $build */
    protected $build = false;

    /**
     * isBuild
     *
     * @return bool
     */
    public function isBuild():bool
    {
        return $this->build;
    }

    /**
     * setDefaultValue
     *
     * @param array  $configuration
     * @param string $name
     * @param array  $defaultValues
     */
    protected function setDefaultValue(array &$configuration, string $name, array $defaultValues): void
    {
        if (array_key_exists($name, $configuration) && null === $configuration[$name]) {
            $configuration[$name] = $defaultValues[$name] ?? null;
        }
    }

    /**
     * setDefaultValues
     *
     * @param array $configuration
     * @param array $fields
     * @param array $defaultValues
     */
    protected function setDefaultValues(array &$configuration, array $fields, array $defaultValues): void
    {
        foreach ($fields as $name) {
            $this->setDefaultValue($configuration, $name, $defaultValues);
        }
    }

    /**
     * getResourceKey
     *
     * @param string $resourceName
     *
     * @return string
     */
    protected function getResourceKey(string $resourceName): string
    {
        return Inflector::tableize(substr($resourceName, strrpos($resourceName, '\\') + 1));
    }

    /**
     * getPropertyKey
     *
     * @param string $propertyName
     *
     * @return string
     */
    protected function getPropertyKey(string $propertyName): string
    {
        return Inflector::tableize($propertyName);
    }
}
