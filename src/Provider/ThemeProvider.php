<?php

namespace PhpGuild\RhapsodyBundle\Provider;

use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Bundle\SecurityBundle\Security\FirewallMap;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class ThemeProvider
 */
class ThemeProvider
{
    /** @var EngineInterface $twig */
    private $twig;

    /** @var string $contextName */
    private $contextName;

    /** @var string $theme */
    private $theme;

    /**
     * ThemeProvider constructor.
     *
     * @param RequestStack $requestStack
     * @param EngineInterface $twig
     * @param FirewallMap $firewallMap
     * @param ParameterBagInterface $parameterBag
     * @throws ThemeProviderException
     */
    public function __construct(
        RequestStack $requestStack,
        EngineInterface $twig,
        FirewallMap $firewallMap,
        ParameterBagInterface $parameterBag
    ) {
        $this->twig = $twig;
        $context = $firewallMap->getFirewallConfig($requestStack->getCurrentRequest());
        if (!$context) {
            throw new ThemeProviderException();
        }

        $this->contextName = $context->getName();
        $this->theme = $parameterBag->get('rhapsody')[$this->contextName]['theme'];
    }

    /**
     * getView
     *
     * @param string $view
     * @return string
     */
    public function getView(string $view): string
    {
        $view = sprintf('%s/%s', $this->contextName, $view);
        if (!$this->twig->exists($view)) {
            $view = sprintf('@%s/%s', $this->theme, $view);
        }

        return $view;
    }
}
