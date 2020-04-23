<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Provider;

use PhpGuild\ResourceBundle\Configuration\ConfigurationException;
use PhpGuild\RhapsodyBundle\Configuration\RhapsodyConfigurationManager;
use Twig\Environment;

/**
 * Class ThemeProvider
 */
class ThemeProvider
{
    /** @var Environment $twig */
    private $twig;

    /** @var RhapsodyConfigurationManager $configurationManager */
    private $configurationManager;

    /**
     * ThemeProvider constructor.
     *
     * @param Environment          $twig
     * @param RhapsodyConfigurationManager $configurationManager
     */
    public function __construct(
        Environment $twig,
        RhapsodyConfigurationManager $configurationManager
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
     * @throws ConfigurationException
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
