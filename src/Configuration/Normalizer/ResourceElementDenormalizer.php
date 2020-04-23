<?php

namespace PhpGuild\RhapsodyBundle\Configuration\Normalizer;

use Doctrine\Common\Inflector\Inflector;
use Doctrine\ORM\EntityManagerInterface;
use PhpGuild\RhapsodyBundle\Configuration\Handler\ActionModelHandler;
use PhpGuild\RhapsodyBundle\Configuration\Model\Action\ActionInterface;
use PhpGuild\RhapsodyBundle\Configuration\Model\Resource\ResourceElement;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class ResourceElementDenormalizer
 */
class ResourceElementDenormalizer implements ContextAwareDenormalizerInterface
{
    /** @var ObjectNormalizer $normalizer */
    private $normalizer;

    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /** @var ActionModelHandler $actionModelHandler */
    private $actionModelHandler;

    /**
     * ResourceElementNormalizer constructor.
     *
     * @param ObjectNormalizer       $normalizer
     * @param EntityManagerInterface $entityManager
     * @param ActionModelHandler     $actionModelHandler
     */
    public function __construct(
        ObjectNormalizer $normalizer,
        EntityManagerInterface $entityManager,
        ActionModelHandler $actionModelHandler
    ) {
        $this->normalizer = $normalizer;
        $this->entityManager = $entityManager;
        $this->actionModelHandler = $actionModelHandler;
    }

    /**
     * denormalize
     *
     * @param mixed       $data
     * @param string      $type
     * @param string|null $format
     * @param array       $context
     *
     * @return array|\ArrayObject|bool|float|int|mixed|object|string|null
     * @throws ExceptionInterface
     */
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $resourceMetaData = $this->entityManager->getClassMetadata($data['model']);

        $data['name'] = Inflector::tableize(substr(
            $resourceMetaData->getName(),
            strrpos($resourceMetaData->getName(), '\\') + 1
        ));

        $data['label'] = $data['label'] ?? sprintf('%s.%s.label', $context['contextName'], $data['name']);

        if (!isset($data['actions'])) {
            $actionNames = $this->actionModelHandler->getActionNames();
            $data['actions'] = array_combine($actionNames, array_map(static function () {
                return [];
            }, $actionNames));
        }

        foreach ($data['actions'] as $name => $action) {
            $data['actions'][$name]['name'] = $name;
        }

        $data['actions'] = array_values($data['actions']);

        /** @var ResourceElement $resourceElement */
        $resourceElement = $this->normalizer->denormalize($data, $type, $format, array_merge($context, [
            'resourceName' => $data['name'],
            'resourceClass' => $data['model'],
            'resourceMetadata' => $resourceMetaData,
        ]));

        /** @var ActionInterface $defaultAction */
        $defaultAction = $resourceElement->getDefaultAction();
        $resourceElement->setPrimaryRoute($defaultAction ? $defaultAction->getRoute() : null);

        return $resourceElement;
    }

    /**
     * supportsDenormalization
     *
     * @param mixed       $data
     * @param string      $type
     * @param string|null $format
     * @param array       $context
     *
     * @return bool
     */
    public function supportsDenormalization($data, string $type, string $format = null, array $context = []): bool
    {
        return $type === ResourceElement::class;
    }
}
