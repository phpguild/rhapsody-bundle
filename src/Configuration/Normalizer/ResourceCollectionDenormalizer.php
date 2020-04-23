<?php

namespace PhpGuild\RhapsodyBundle\Configuration\Normalizer;

use Doctrine\ORM\EntityManagerInterface;
use PhpGuild\RhapsodyBundle\Configuration\Model\Resource\ResourceCollection;
use PhpGuild\RhapsodyBundle\Provider\ThemeProviderException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class ResourceCollectionDenormalizer
 */
class ResourceCollectionDenormalizer implements ContextAwareDenormalizerInterface
{
    /** @var ObjectNormalizer $normalizer */
    private $normalizer;

    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /**
     * ResourceCollectionNormalizer constructor.
     *
     * @param ObjectNormalizer       $normalizer
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        ObjectNormalizer $normalizer,
        EntityManagerInterface $entityManager
    ) {
        $this->normalizer = $normalizer;
        $this->entityManager = $entityManager;
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
     * @throws ThemeProviderException
     */
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        if (!isset($data['theme'])) {
            throw new ThemeProviderException(sprintf(
                '%s parameter is not configured',
                'rhapsody.contexts.' . $context['name'] . '.theme'
            ), 1002);
        }

        if (!\count($data['resources'])) {
            foreach ($this->entityManager->getMetadataFactory()->getAllMetadata() as $metadata) {
                if ($metadata->isMappedSuperclass) {
                    continue;
                }

                $data['resources'][$metadata->getName()] = null;
            }
        }

        foreach ($data['resources'] as $name => $resource) {
            $data['resources'][$name]['model'] = $name;
        }

        $data['resources'] = array_values($data['resources']);

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
        return $type === ResourceCollection::class;
    }
}
