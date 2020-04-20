<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration;

/**
 * Class ResourceConfiguration
 */
class ResourceConfiguration implements ConfigurationInterface
{
    /** @var bool $build */
    private $build = false;

    /** @var array $default */
    private $default = [
        'list' => [
            'fields' => [],
        ],
        'form' => [
            'fields' => [],
        ],
    ];

    /**
     * build
     *
     * @param array $configurationData
     *
     * @return array
     */
    public function build(array $configurationData): array
    {
        $this->build = true;

        foreach ($configurationData['resources'] as $resourceName => &$resourceConfiguration) {
            $resourceConfiguration = array_merge_recursive($this->default, $resourceConfiguration);
        }

        return $configurationData;
    }

    /**
     * isBuild
     *
     * @return bool
     */
    public function isBuild():bool
    {
        return $this->build;
    }
}
