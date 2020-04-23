<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Provider;

use PhpGuild\ResourceBundle\Configuration\ConfigurationException;
use PhpGuild\RhapsodyBundle\Configuration\RhapsodyConfigurationManager;

/**
 * Class RouterProvider
 */
class RouterProvider
{
    /** @var RhapsodyConfigurationManager $configurationManager */
    private $configurationManager;

    /**
     * RouterProvider constructor.
     *
     * @param RhapsodyConfigurationManager $configurationManager
     */
    public function __construct(RhapsodyConfigurationManager $configurationManager)
    {
        $this->configurationManager = $configurationManager;
    }

    /**
     * getRoute
     *
     * @param string $route
     *
     * @return string
     * @throws ConfigurationException
     */
    public function getRoute(string $route): string
    {
        return sprintf('%s_%s', $this->configurationManager->getContext(), $route);
    }
}
