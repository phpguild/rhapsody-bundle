<?php

namespace PhpGuild\RhapsodyBundle\Configuration\Normalizer;

use PhpGuild\RhapsodyBundle\Configuration\Model\Action\ActionInterface;
use PhpGuild\RhapsodyBundle\Configuration\Handler\ActionModelHandler;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class ActionNormalizer
 */
class ActionNormalizer implements ContextAwareDenormalizerInterface
{
    /** @var ObjectNormalizer $normalizer */
    private $normalizer;

    /** @var ActionModelHandler $actionModelHandler */
    private $actionModelHandler;

    /**
     * ActionNormalizer constructor.
     *
     * @param ObjectNormalizer        $normalizer
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
     * @return array|\ArrayObject|bool|float|int|mixed|object|string|null
     * @throws ExceptionInterface
     */
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $actionNormalizer = $this->actionModelHandler->get($data['name']);

        if (!$actionNormalizer) {
            return null;
        }

        return $this->normalizer->denormalize(
            $data,
            get_class($actionNormalizer),
            $format,
            $context
        );
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
