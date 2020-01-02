<?php

namespace PhpGuild\RhapsodyBundle\Provider;

use Symfony\Bundle\SecurityBundle\Security\FirewallMap;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class RouterProvider
 */
class RouterProvider
{
    /** @var string $contextName */
    private $contextName;

    /**
     * RouterProvider constructor.
     *
     * @param RequestStack $requestStack
     * @param FirewallMap $firewallMap
     * @throws RouterProviderException
     */
    public function __construct(RequestStack $requestStack, FirewallMap $firewallMap)
    {
        $context = $firewallMap->getFirewallConfig($requestStack->getCurrentRequest());
        if (!$context) {
            throw new RouterProviderException();
        }

        $this->contextName = $context->getName();
    }

    /**
     * getRoute
     *
     * @param string $route
     * @return string
     */
    public function getRoute(string $route): string
    {
        return sprintf('%s_%s', $this->contextName, $route);
    }
}
