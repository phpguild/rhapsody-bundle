<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration;

/**
 * Class ResourceActionsConfiguration
 */
class ResourceActionsConfiguration implements ConfigurationInterface
{
    /** @var bool $build */
    private $build = false;

    /** @var array $default */
    private $default = [
        'list' => [
            'property' => null,
            'format' => null,
        ],
        'form' => [
            'property' => null,
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
            $this->normalizeAction('list', $resourceConfiguration);
            $this->normalizeAction('form', $resourceConfiguration);
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

    /**
     * normalizeAction
     *
     * @param string $action
     * @param array  $resourceConfiguration
     */
    private function normalizeAction(string $action, array &$resourceConfiguration): void
    {
        foreach ($resourceConfiguration[$action]['fields'] as &$fieldConfiguration) {
            if (!\is_array($fieldConfiguration)) {
                $fieldConfiguration = [ 'property' => $fieldConfiguration ];
            }

            $fieldConfiguration = array_merge($this->default[$action], $fieldConfiguration);
        }
    }
}
