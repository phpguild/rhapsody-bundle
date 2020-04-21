<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Provider;

use PhpGuild\RhapsodyBundle\Configuration\ConfigurationManager;

/**
 * Class RouterProvider
 */
class RouterProvider
{
    /** @var ConfigurationManager $configurationManager */
    private $configurationManager;

    /**
     * RouterProvider constructor.
     *
     * @param ConfigurationManager $configurationManager
     */
    public function __construct(ConfigurationManager $configurationManager)
    {
        $this->configurationManager = $configurationManager;
    }

    /**
     * getRoute
     *
     * @param string $route
     *
     * @return string
     * @throws ThemeProviderException
     */
    public function getRoute(string $route): string
    {
        return sprintf('%s_%s', $this->configurationManager->getContext(), $route);
    }
}
