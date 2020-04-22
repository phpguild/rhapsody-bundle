<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration\Transformer;

use Doctrine\Common\Inflector\Inflector;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\MappingException;
use PhpGuild\RhapsodyBundle\Configuration\Handler\ActionModelHandler;
use PhpGuild\RhapsodyBundle\Configuration\Model\Resource\ResourceCollection;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ResourceTransformer
 */
class ResourceTransformer
{
    /** @var ActionModelHandler $actionModelHandler */
    private $actionModelHandler;

    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /** @var SerializerInterface $serializer */
    private $serializer;

    /**
     * ResourceTransformer constructor.
     *
     * @param ActionModelHandler $actionModelHandler
     * @param EntityManagerInterface  $entityManager
     * @param SerializerInterface     $serializer
     */
    public function __construct(
        ActionModelHandler $actionModelHandler,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ) {
        $this->actionModelHandler = $actionModelHandler;
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    /**
     * transform
     *
     * @param string $context
     * @param array  $configuration
     *
     * @return ResourceCollection|Object
     * @throws MappingException
     */
    public function transform(
        string $context,
        array $configuration
    ): ResourceCollection {
        if (!\count($configuration['resources'])) {
            foreach ($this->entityManager->getMetadataFactory()->getAllMetadata() as $metadata) {
                if ($metadata->isMappedSuperclass) {
                    continue;
                }

                $configuration['resources'][$metadata->getName()] = null;
            }
        }

        $actionNames = $this->actionModelHandler->getActionNames();

        foreach ($configuration['resources'] as $resourceName => &$resourceConfiguration) {
            $resourceMetaData = $this->entityManager->getClassMetadata($resourceName);
            $resourceKey = $this->getResourceKey($resourceMetaData->getName());

            if (!$resourceConfiguration) {
                $resourceConfiguration['actions'] = array_combine($actionNames, array_map(static function () {
                    return [];
                }, $actionNames));
            }

            $resourceConfiguration['label'] = $resourceConfiguration['label'] ?? sprintf(
                '%s.%s.label',
                $context,
                $resourceKey
            );

            foreach ($resourceConfiguration['actions'] as $actionName => &$actionConfiguration) {
                $actionClassName = $this->actionModelHandler->get($actionName);

                if (!$actionClassName) {
                    //@Todo Add throw
                    unset($resourceConfiguration['actions'][$actionName]);
                    continue;
                }

                $defaultActionConfiguration = [
                    'route' => [
                        'name' => sprintf('%s_%s_%s', $context, $resourceKey, $actionName),
                        'path' => sprintf('%s%s', $resourceKey, ('list' !== $actionName ? '/' . $actionName : '')),
                    ],
                ];

                $actionConfiguration = array_merge($defaultActionConfiguration, $actionConfiguration);
                $actionConfiguration['name'] = $actionName;

                if (!isset($actionConfiguration['fields'])) {
                    $fields = $resourceMetaData->getFieldNames();

                    if ('form' === $actionName) {
                        $identifierIndex = array_search($resourceMetaData->getSingleIdentifierFieldName(), $fields, true);

                        if (false !== $identifierIndex) {
                            unset($fields[$identifierIndex]);
                        }
                    }

                    $actionConfiguration['fields'] = $fields;
                }

                foreach ($actionConfiguration['fields'] as $fieldIndex => $fieldConfiguration) {
                    if (!\is_array($fieldConfiguration)) {
                        $fieldConfiguration = [ 'name' => $fieldConfiguration ];
                    }

                    $fieldConfiguration['label'] = $fieldConfiguration['label'] ?? sprintf(
                        '%s.%s.%s.%s_label',
                        $context,
                        $resourceKey,
                        $this->getPropertyKey($fieldConfiguration['name']),
                        $actionName
                    );

                    foreach ($resourceMetaData->getFieldMapping($fieldConfiguration['name']) as $name => $value) {
                        if (isset($fieldConfiguration[$name])) {
                            continue;
                        }

                        $fieldConfiguration[$name] = $value;
                    }

                    $actionConfiguration['fields'][$fieldIndex] = $fieldConfiguration;
                }
            }

            unset($actionConfiguration);

            $resourceConfiguration['actions'] = array_values($resourceConfiguration['actions']);

//            if (!$resourceConfiguration->getPrimaryRoute()) {
//                $defaultAction = $resourceConfiguration->getDefaultAction();
//                if ($defaultAction) {
//                    $resourceConfiguration->setPrimaryRoute($defaultAction->getRoute());
//                }
//            }
        }

        unset($resourceConfiguration);

        dump($configuration);exit;

        $configuration['resources'] = array_values($configuration['resources']);

        return $this->serializer->deserialize(
            json_encode($configuration),
            ResourceCollection::class,
            'json'
        );
    }

    /**
     * getResourceKey
     *
     * @param string $resourceName
     *
     * @return string
     */
    private function getResourceKey(string $resourceName): string
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
    private function getPropertyKey(string $propertyName): string
    {
        return Inflector::tableize($propertyName);
    }
}
