<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration;

use PhpGuild\RhapsodyBundle\Configuration\Model\Resource\ResourceCollection;
use PhpGuild\RhapsodyBundle\Provider\ThemeProviderException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * Class ConfigurationProcessor
 */
final class ConfigurationProcessor
{
    /** @var SerializerInterface $serializer */
    private $serializer;

    /** @var CacheInterface $cache */
    private $cache;

    /** @var array $configuration */
    private $configuration = [];

    /** @var array $originalConfiguration */
    private $originalConfiguration;

    /**
     * ConfigurationProcessor constructor.
     *
     * @param SerializerInterface    $serializer
     * @param CacheInterface         $cache
     * @param ParameterBagInterface  $parameterBag
     */
    public function __construct(
        SerializerInterface $serializer,
        CacheInterface $cache,
        ParameterBagInterface $parameterBag
    ) {
        $this->serializer = $serializer;
        $this->cache = $cache;
        $this->originalConfiguration = $parameterBag->get('rhapsody');
    }

    /**
     * build
     *
     * @throws InvalidArgumentException
     * @throws ThemeProviderException
     */
    public function build(): void
    {
        $contexts = $this->originalConfiguration['contexts'];
        if (!\is_array($contexts) || !\count($contexts)) {
            throw new ThemeProviderException('Context is not configured', 1001);
        }

        foreach ($contexts as $context => $configuration) {
            $cacheKey = sprintf('rhapsody.configuration.%s', $context);

            $this->configuration[$context] = $this->cache->get($cacheKey, function () use ($context, $configuration) {
                $data = $this->serializer->deserialize(
                    json_encode($configuration),
                    ResourceCollection::class,
                    'json',
                    [ 'contextName' => $context ]
                );
                return $data;
//                dump($data);exit;
            });
        }
    }

    /**
     * getConfiguration
     *
     * @return array
     */
    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    /**
     * getContextConfiguration
     *
     * @param string $context
     *
     * @return ResourceCollection|null
     */
    public function getContextConfiguration(string $context): ?ResourceCollection
    {
        return $this->configuration[$context] ?? null;
    }
}
