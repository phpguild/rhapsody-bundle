<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Provider;

use PhpGuild\RhapsodyBundle\Configuration\ConfigurationHandler;
use Twig\Environment;

/**
 * Class ThemeProvider
 */
class ThemeProvider
{
    /** @var Environment $twig */
    private $twig;

    /** @var ConfigurationHandler $configurationHandler */
    private $configurationHandler;

    /**
     * ThemeProvider constructor.
     *
     * @param Environment          $twig
     * @param ConfigurationHandler $configurationHandler
     */
    public function __construct(
        Environment $twig,
        ConfigurationHandler $configurationHandler
    ) {
        $this->twig = $twig;
        $this->configurationHandler = $configurationHandler;
    }

    /**
     * getView
     *
     * @param string $originalView
     *
     * @return string
     * @throws ThemeProviderException
     */
    public function getView(string $originalView): string
    {
        $contextName = $this->configurationHandler->getCurrentContextName();
        $theme = $this->configurationHandler->getCurrentContext()['theme'];
        if (!$theme) {
            throw new ThemeProviderException(sprintf(
                '%s parameter is not configured',
                'rhapsody.contexts.' . $contextName . '.theme'
            ), 1002);
        }

        $view = sprintf('%s/%s', $contextName, $originalView);
        if (!$this->twig->getLoader()->exists($view)) {
            $view = sprintf('@%s/%s', ltrim($theme, '@'), $originalView);
        }

        return $view;
    }
}
