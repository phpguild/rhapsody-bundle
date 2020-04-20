<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Provider;

use Symfony\Bundle\SecurityBundle\Security\FirewallMap;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class RouterProvider
 */
class RouterProvider
{
    /** @var Request $request */
    private $request;

    /** @var FirewallMap $firewallMap */
    private $firewallMap;

    /**
     * RouterProvider constructor.
     * @param RequestStack $requestStack
     * @param FirewallMap $firewallMap
     */
    public function __construct(RequestStack $requestStack, FirewallMap $firewallMap)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->firewallMap = $firewallMap;
    }

    /**
     * getRoute
     *
     * @param string $route
     * @return string
     * @throws ThemeProviderException
     */
    public function getRoute(string $route): string
    {
        $context = $this->firewallMap->getFirewallConfig($this->request);
        if (!$context) {
            throw new ThemeProviderException();
        }

        $contextName = $context->getName();

        return sprintf('%s_%s', $contextName, $route);
    }
}
