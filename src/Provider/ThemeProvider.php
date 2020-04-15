<?php

namespace PhpGuild\RhapsodyBundle\Provider;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Bundle\SecurityBundle\Security\FirewallMap;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

/**
 * Class ThemeProvider
 */
class ThemeProvider
{
    /** @var Request $request */
    private $request;

    /** @var Environment $twig */
    private $twig;

    /** @var FirewallMap $firewallMap */
    private $firewallMap;

    /** @var ParameterBagInterface $parameterBag */
    private $parameterBag;

    /**
     * ThemeProvider constructor.
     * @param RequestStack $requestStack
     * @param Environment $twig
     * @param FirewallMap $firewallMap
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(
        RequestStack $requestStack,
        Environment $twig,
        FirewallMap $firewallMap,
        ParameterBagInterface $parameterBag
    ) {
        $this->request = $requestStack->getCurrentRequest();
        $this->twig = $twig;
        $this->firewallMap = $firewallMap;
        $this->parameterBag = $parameterBag;
    }

    /**
     * getView
     *
     * @param string $view
     * @return string
     * @throws ThemeProviderException
     */
    public function getView(string $view): string
    {
        $context = $this->firewallMap->getFirewallConfig($this->request);
        if (!$context) {
            throw new ThemeProviderException();
        }

        $contextName = $context->getName();
        $configuration = $this->parameterBag->get('rhapsody');
        $theme = $configuration['contexts'][$contextName]['theme'] ?? null;
        if (!$theme) {
            throw new ThemeProviderException();
        }

        $view = sprintf('%s/%s', $contextName, $view);
        if (!$this->twig->exists($view)) {
            $view = sprintf('@%s/%s', $theme, $view);
        }

        return $view;
    }
}
