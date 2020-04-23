<?php

namespace PhpGuild\RhapsodyBundle\Router;

use PhpGuild\ResourceBundle\Configuration\ConfigurationException;
use PhpGuild\ResourceBundle\Model\Action\ActionInterface;
use PhpGuild\ResourceBundle\Model\Resource\ResourceCollectionInterface;
use PhpGuild\ResourceBundle\Model\Resource\ResourceElementInterface;
use PhpGuild\RhapsodyBundle\Configuration\RhapsodyConfigurationProcessor;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RhapsodyLoader
 */
class RhapsodyLoader implements LoaderInterface
{
    /** @var RhapsodyConfigurationProcessor $configurationProcessor */
    private $configurationProcessor;

    /** @var bool $loaded */
    private $loaded = false;

    /**
     * RhapsodyLoader constructor.
     *
     * @param RhapsodyConfigurationProcessor $configurationProcessor
     */
    public function __construct(RhapsodyConfigurationProcessor $configurationProcessor)
    {
        $this->configurationProcessor = $configurationProcessor;
    }

    /**
     * load
     *
     * @param mixed       $resource
     * @param string|null $type
     *
     * @return RouteCollection
     *
     * @throws ConfigurationException
     * @throws InvalidArgumentException
     */
    public function load($resource, string $type = null): RouteCollection
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add this loader twice');
        }

        $routes = new RouteCollection();

        /** @var ResourceCollectionInterface $resourceCollection */
        foreach ($this->configurationProcessor->getConfiguration() as $resourceCollection) {
            /** @var ResourceElementInterface $resourceElement */
            foreach ($resourceCollection->getResources() as $resourceElement) {
                /** @var ActionInterface $action */
                foreach ($resourceElement->getActions() as $action) {
                    $actionRoute = $action->getRoute();
                    if (!$actionRoute) {
                        continue;
                    }
                    $routes->add($actionRoute->getName(), new Route($actionRoute->getPath(), [
                        '_controller' => $action->getController(),
                    ]));
                }
            }
        }

        return $routes;
    }

    /**
     * supports
     *
     * @param mixed       $resource
     * @param string|null $type
     *
     * @return bool
     */
    public function supports($resource, string $type = null): bool
    {
        return 'rhapsody' === $type;
    }

    /**
     * getResolver
     *
     * @return LoaderResolverInterface|void
     */
    public function getResolver()
    {
    }

    /**
     * setResolver
     *
     * @param LoaderResolverInterface $resolver
     */
    public function setResolver(LoaderResolverInterface $resolver): void
    {
    }
}
