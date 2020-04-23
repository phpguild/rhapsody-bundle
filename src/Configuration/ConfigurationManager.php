<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration;

use PhpGuild\RhapsodyBundle\Configuration\Model\Resource\ResourceCollectionInterface;
use PhpGuild\RhapsodyBundle\Provider\ThemeProviderException;
use Symfony\Bundle\SecurityBundle\Security\FirewallMap;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class ConfigurationManager
 */
final class ConfigurationManager
{
    /** @var FirewallMap $firewallMap */
    private $firewallMap;

    /** @var Request $request */
    private $request;

    /** @var ConfigurationProcessor $configurationProcessor */
    private $configurationProcessor;

    /** @var ResourceCollectionInterface $configuration */
    private $configuration;

    /** @var string $context */
    private $context;

    /**
     * ConfigurationManager constructor.
     *
     * @param FirewallMap          $firewallMap
     * @param RequestStack         $requestStack
     * @param ConfigurationProcessor $configurationProcessor
     */
    public function __construct(
        FirewallMap $firewallMap,
        RequestStack $requestStack,
        ConfigurationProcessor $configurationProcessor
    ) {
        $this->firewallMap = $firewallMap;
        $this->request = $requestStack->getCurrentRequest();
        $this->configurationProcessor = $configurationProcessor;
    }

    /**
     * getContext
     *
     * @return string
     * @throws ThemeProviderException
     */
    public function getContext(): string
    {
        if (!$this->context) {
            $firewallConfig = $this->firewallMap->getFirewallConfig($this->request);

            if (!$firewallConfig) {
                throw new ThemeProviderException('Firewall context is not configured', 1001);
            }

            $this->context = $firewallConfig->getName();
        }

        return $this->context;
    }

    /**
     * getConfiguration
     *
     * @return ResourceCollectionInterface
     * @throws ThemeProviderException
     */
    public function getConfiguration(): ResourceCollectionInterface
    {
        if (!$this->configuration) {
            $this->configuration = $this->configurationProcessor->getContextConfiguration($this->getContext());

            if (!$this->configuration) {
                throw new ThemeProviderException('Context is not configured', 1001);
            }
        }

        return $this->configuration;
    }
}
