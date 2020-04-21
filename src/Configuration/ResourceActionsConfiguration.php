<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\MappingException;

/**
 * Class ResourceActionsConfiguration
 */
class ResourceActionsConfiguration extends AbstractConfiguration
{
    /** @var array $mapping */
    private static $mapping = [
        'action' => [
            'routeName' => null,
            'routePath' => null,
            'fields' => [],
            'default' => false,
        ],
        'list' => [
            'label' => null,
            'icon' => null,
            'property' => null,
            'type' => null,
        ],
        'form' => [
            'label' => null,
            'property' => null,
            'type' => null,
            'length' => null,
            'nullable' => null,
        ],
    ];

    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /**
     * ResourceActionsConfiguration constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * build
     *
     * @param string $context
     * @param array  $configurationData
     *
     * @return array
     * @throws MappingException
     */
    public function build(string $context, array $configurationData): array
    {
        $this->build = true;

        foreach ($configurationData['resources'] as $resourceName => &$resourceConfiguration) {
            $classMetaData = $this->entityManager->getClassMetadata($resourceName);

            $this->normalizeAction($context, 'list', $classMetaData, $resourceConfiguration);
            $this->normalizeAction($context, 'form', $classMetaData, $resourceConfiguration);

            $this->setDefaultAction($resourceConfiguration);
        }

        unset($resourceConfiguration);

        return $configurationData;
    }

    /**
     * normalizeAction
     *
     * @param string        $context
     * @param string        $action
     * @param ClassMetadata $classMetaData
     * @param array         $resourceConfiguration
     *
     * @throws MappingException
     */
    private function normalizeAction(
        string $context,
        string $action,
        ClassMetadata $classMetaData,
        array &$resourceConfiguration
    ): void {
        $actionConfiguration = $resourceConfiguration['actions'][$action];
        $actionConfiguration = array_merge(static::$mapping['action'], $actionConfiguration);

        $resourceKey = $this->getResourceKey($classMetaData->getName());

        $this->setDefaultValues($actionConfiguration, [ 'routeName', 'routePath' ], [
            'routeName' => sprintf('%s_%s_%s', $context, $resourceKey, $action),
            'routePath' => sprintf('%s%s', $resourceKey, ('list' !== $action ? '/' . $action : '')),
        ]);

        $mapping = self::$mapping[$action] ?? [];

        if (!\count($actionConfiguration['fields'])) {
            $actionConfiguration['fields'] = $classMetaData->getFieldNames();

            if ('form' === $action) {
                $identifierIndex = array_search(
                    $classMetaData->getSingleIdentifierFieldName(),
                    $actionConfiguration['fields'],
                    true
                );

                if (false !== $identifierIndex) {
                    unset($actionConfiguration['fields'][$identifierIndex]);
                }
            }
        }

        foreach ($actionConfiguration['fields'] as $fieldIndex => $fieldConfiguration) {
            if (!\is_array($fieldConfiguration)) {
                $fieldConfiguration = [ 'property' => $fieldConfiguration ];
            }

            $fieldConfiguration = array_merge($mapping, $fieldConfiguration);

            $propertyKey = $this->getPropertyKey($fieldConfiguration['property']);

            $defaultValues = $classMetaData->getFieldMapping($fieldConfiguration['property']);
            $defaultValues['label'] = sprintf('%s.%s.%s.%s_label', $context, $resourceKey, $propertyKey, $action);

            $this->setDefaultValues(
                $fieldConfiguration,
                [ 'label', 'type' , 'length', 'nullable' ],
                $defaultValues
            );

            $actionConfiguration['fields'][$fieldIndex] = $fieldConfiguration;
        }

        $resourceConfiguration['actions'][$action] = $actionConfiguration;
    }

    /**
     * setDefaultAction
     *
     * @param array $resourceConfiguration
     */
    private function setDefaultAction(array &$resourceConfiguration): void
    {
        if ($resourceConfiguration['primaryRouteName']) {
            return;
        }

        foreach ($resourceConfiguration['actions'] as $action => $actionConfiguration) {
            if (true !== $actionConfiguration['default']) {
                continue;
            }

            $resourceConfiguration['routeName'] = $actionConfiguration['routeName'];
        }

        if (!$resourceConfiguration['primaryRouteName']) {
            $resourceConfiguration['primaryRouteName'] = $resourceConfiguration['actions']['list']['routeName'] ?? null;
        }
    }
}
