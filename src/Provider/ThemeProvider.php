<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Provider;

use PhpGuild\RhapsodyBundle\Configuration\ConfigurationManager;
use Twig\Environment;

/**
 * Class ThemeProvider
 */
class ThemeProvider
{
    /** @var Environment $twig */
    private $twig;

    /** @var ConfigurationManager $configurationManager */
    private $configurationManager;

    /**
     * ThemeProvider constructor.
     *
     * @param Environment          $twig
     * @param ConfigurationManager $configurationManager
     */
    public function __construct(
        Environment $twig,
        ConfigurationManager $configurationManager
    ) {
        $this->twig = $twig;
        $this->configurationManager = $configurationManager;
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
        $context = $this->configurationManager->getContext();
        $theme = $this->configurationManager->getConfiguration()->getTheme();

        $view = sprintf('%s/%s', $context, $originalView);
        if (!$this->twig->getLoader()->exists($view)) {
            $view = sprintf('@%s/%s', ltrim($theme, '@'), $originalView);
        }

        return $view;
    }
}
