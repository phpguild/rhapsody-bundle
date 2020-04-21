<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ResourceConfiguration
 */
class ResourceConfiguration extends AbstractConfiguration
{
    /** @var array $mapping */
    private static $mapping = [
        'primaryRouteName' => null,
        'label' => null,
        'icon' => null,
        'actions' => [
            'list' => [],
            'form' => [],
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
     */
    public function build(string $context, array $configurationData): array
    {
        $this->build = true;

        if (!\count($configurationData['resources'])) {
            foreach ($this->entityManager->getMetadataFactory()->getAllMetadata() as $metadata) {
                if ($metadata->isMappedSuperclass) {
                    continue;
                }

                $configurationData['resources'][$metadata->getName()] = null;
            }
        }

        foreach ($configurationData['resources'] as $resourceName => $resourceConfiguration) {
            $resourceConfiguration = array_merge_recursive(self::$mapping, $resourceConfiguration ?: []);

            $resourceKey = $this->getResourceKey($resourceName);

            $this->setDefaultValues($resourceConfiguration, [ 'label' ], [
                'label' => sprintf('%s.%s.label', $context, $resourceKey),
            ]);

            $configurationData['resources'][$resourceName] = $resourceConfiguration;
        }

        return $configurationData;
    }
}
