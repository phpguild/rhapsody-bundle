<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration;

use PhpGuild\RhapsodyBundle\Provider\ThemeProviderException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\SecurityBundle\Security\FirewallMap;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * Class ConfigurationHandler
 */
final class ConfigurationHandler
{
    /** @var Request $request */
    private $request;

    /** @var FirewallMap $firewallMap */
    private $firewallMap;

    /** @var CacheInterface $cache */
    private $cache;

    /** @var string $contextName */
    private $contextName;

    /** @var array $contextConfiguration */
    private $contextConfiguration;

    /** @var array $originalConfiguration */
    private $originalConfiguration;

    /** @var array $configurationCollection */
    private $configurationCollection = [];

    /**
     * ConfigurationHandler constructor.
     *
     * @param RequestStack          $requestStack
     * @param FirewallMap           $firewallMap
     * @param CacheInterface        $cache
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(
        RequestStack $requestStack,
        FirewallMap $firewallMap,
        CacheInterface $cache,
        ParameterBagInterface $parameterBag
    ) {
        $this->originalConfiguration = $parameterBag->get('rhapsody');
        $this->request = $requestStack->getCurrentRequest();
        $this->firewallMap = $firewallMap;
        $this->cache = $cache;
    }

    /**
     * addConfiguration
     *
     * @param ConfigurationInterface $configuration
     */
    public function addConfiguration(ConfigurationInterface $configuration): void
    {
        $this->configurationCollection[get_class($configuration)] = $configuration;
    }

    /**
     * build
     *
     * @throws InvalidArgumentException
     * @throws ThemeProviderException
     */
    public function build(): void
    {
        if (!$this->request) {
            return;
        }

        $context = $this->firewallMap->getFirewallConfig($this->request);
        if (!$context) {
            throw new ThemeProviderException('Firewall context is not configured', 1001);
        }

        $this->contextName = $context->getName();
        $this->contextConfiguration = $this->originalConfiguration['contexts'][$this->contextName] ?? null;

        if (!$this->contextConfiguration) {
            throw new ThemeProviderException('Context is not configured', 1001);
        }

        $cacheKey = sprintf('rhapsody.configuration.%s', $this->contextName);

        $this->contextConfiguration = $this->cache->get($cacheKey, function () {
            $this->contextConfiguration = $this->configurationCollection[ResourceConfiguration::class]->build(
                $this->contextConfiguration
            );

            $this->contextConfiguration = $this->configurationCollection[ResourceActionsConfiguration::class]->build(
                $this->contextConfiguration
            );

            /** @var ConfigurationInterface $configuration */
            foreach ($this->configurationCollection as $configuration) {
                if ($configuration->isBuild()) {
                    continue;
                }

                $this->contextConfiguration = $configuration->build($this->contextConfiguration);
            }

            return $this->contextConfiguration;
        });
    }

    /**
     * getCurrentContextName
     *
     * @return string
     */
    public function getCurrentContextName(): string
    {
        return $this->contextName;
    }

    /**
     * getCurrentContext
     *
     * @return array
     */
    public function getCurrentContext(): array
    {
        return $this->contextConfiguration;
    }
}
