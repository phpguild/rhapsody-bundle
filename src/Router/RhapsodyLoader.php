<?php

namespace PhpGuild\RhapsodyBundle\Router;

use PhpGuild\RhapsodyBundle\Configuration\ConfigurationProcessor;
use PhpGuild\RhapsodyBundle\Configuration\Model\Action\ActionInterface;
use PhpGuild\RhapsodyBundle\Configuration\Model\Resource\ResourceCollectionInterface;
use PhpGuild\RhapsodyBundle\Configuration\Model\Resource\ResourceElementInterface;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RhapsodyLoader
 */
class RhapsodyLoader implements LoaderInterface
{
    /** @var ConfigurationProcessor $configurationProcessor */
    private $configurationProcessor;

    /** @var bool $loaded */
    private $loaded = false;

    /**
     * RhapsodyLoader constructor.
     *
     * @param ConfigurationProcessor $configurationProcessor
     */
    public function __construct(ConfigurationProcessor $configurationProcessor)
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
