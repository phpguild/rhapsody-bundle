<?php

namespace PhpGuild\RhapsodyBundle\Configuration\Normalizer;

use PhpGuild\RhapsodyBundle\Configuration\Model\Action\ActionInterface;
use PhpGuild\RhapsodyBundle\Configuration\Handler\ActionModelHandler;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class ActionDenormalizer
 */
class ActionDenormalizer implements ContextAwareDenormalizerInterface
{
    /** @var ObjectNormalizer $normalizer */
    private $normalizer;

    /** @var ActionModelHandler $actionModelHandler */
    private $actionModelHandler;

    /**
     * ActionDenormalizer constructor.
     *
     * @param ObjectNormalizer   $normalizer
     * @param ActionModelHandler $actionModelHandler
     */
    public function __construct(ObjectNormalizer $normalizer, ActionModelHandler $actionModelHandler)
    {
        $this->normalizer = $normalizer;
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
     * @return array|object
     * @throws ExceptionInterface
     * @throws DenormalizerException
     */
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $actionClassName = $this->actionModelHandler->get($data['name']);

        if (!$actionClassName) {
            throw new DenormalizerException();
        }

        $data = array_merge([
            'route' => [
                'name' => sprintf('%s_%s_%s', $context['contextName'], $context['resourceName'], $data['name']),
                'path' => sprintf('%s%s', $context['resourceName'], ('list' !== $data['name'] ? '/' . $data['name'] : '')),
            ],
        ], $data);

        if (!isset($data['fields'])) {
            $fields = $context['resourceMetadata']->getFieldNames();

            if ('form' === $data['name']) {
                $identifierIndex = array_search(
                    $context['resourceMetadata']->getSingleIdentifierFieldName(),
                    $fields,
                    true
                );

                if (false !== $identifierIndex) {
                    unset($fields[$identifierIndex]);
                }
            }

            $data['fields'] = $fields;
        }

        return $this->normalizer->denormalize($data, get_class($actionClassName), $format, array_merge($context, [
            'actionName' => $data['name'],
        ]));
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
        return $type === ActionInterface::class;
    }
}
