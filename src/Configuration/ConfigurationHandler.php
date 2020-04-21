<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration;

use PhpGuild\RhapsodyBundle\Provider\ThemeProviderException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * Class ConfigurationHandler
 */
final class ConfigurationHandler
{
    /** @var CacheInterface $cache */
    private $cache;

    /** @var array $configuration */
    private $configuration = [];

    /** @var array $originalConfiguration */
    private $originalConfiguration;

    /** @var array $collection */
    private $collection = [];

    /**
     * ConfigurationHandler constructor.
     *
     * @param CacheInterface        $cache
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(
        CacheInterface $cache,
        ParameterBagInterface $parameterBag
    ) {
        $this->originalConfiguration = $parameterBag->get('rhapsody');
        $this->cache = $cache;
    }

    /**
     * addConfiguration
     *
     * @param ConfigurationInterface $configuration
     */
    public function addConfiguration(ConfigurationInterface $configuration): void
    {
        $this->collection[get_class($configuration)] = $configuration;
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
                $configuration = $this->collection[ResourceConfiguration::class]->build($context, $configuration);
                $configuration = $this->collection[ResourceActionsConfiguration::class]->build($context, $configuration);

                /** @var ConfigurationInterface $configurator */
                foreach ($this->collection as $configurator) {
                    if ($configurator->isBuild()) {
                        continue;
                    }

                    $configuration = $configurator->build($context, $configuration);
                }

                if (empty($configuration['theme'])) {
                    throw new ThemeProviderException(sprintf(
                        '%s parameter is not configured',
                        'rhapsody.contexts.' . $context . '.theme'
                    ), 1002);
                }

                return $configuration;
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
     * @return array|null
     */
    public function getContextConfiguration(string $context): ?array
    {
        return $this->configuration[$context] ?? null;
    }
}
