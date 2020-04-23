<?php

namespace PhpGuild\RhapsodyBundle\Configuration\Normalizer;

use Doctrine\Common\Inflector\Inflector;
use PhpGuild\RhapsodyBundle\Configuration\Model\Field\FieldInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class FieldDenormalizer
 */
class FieldDenormalizer implements ContextAwareDenormalizerInterface
{
    /** @var ObjectNormalizer $normalizer */
    private $normalizer;

    /**
     * FieldNormalizer constructor.
     *
     * @param ObjectNormalizer $normalizer
     */
    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
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
     */
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        if (!\is_array($data)) {
            $data = [ 'name' => $data ];
        }

        $data['label'] = $data['label'] ?? sprintf(
                '%s.%s.%s.%s_label',
                $context['contextName'],
                $context['resourceName'],
                Inflector::tableize($data['name']),
                $context['actionName']
            );

        foreach ($context['resourceMetadata']->getFieldMapping($data['name']) as $name => $value) {
            if (isset($data[$name])) {
                continue;
            }

            $data[$name] = $value;
        }

        return $this->normalizer->denormalize($data, $type, $format, $context);
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
        return is_a($type, FieldInterface::class, true);
    }
}
