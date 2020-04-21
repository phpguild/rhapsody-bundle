<?php

namespace PhpGuild\RhapsodyBundle\Router;

use PhpGuild\RhapsodyBundle\Configuration\ConfigurationHandler;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RhapsodyLoader
 */
class RhapsodyLoader implements LoaderInterface
{
    /** @var ConfigurationHandler $configurationHandler */
    private $configurationHandler;

    /** @var bool $loaded */
    private $loaded = false;

    /**
     * RhapsodyLoader constructor.
     *
     * @param ConfigurationHandler $configurationHandler
     */
    public function __construct(ConfigurationHandler $configurationHandler)
    {
        $this->configurationHandler = $configurationHandler;
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

        foreach ($this->configurationHandler->getConfiguration() as $context => $contextConfiguration) {
            foreach ($contextConfiguration['resources'] as $resourceConfiguration) {
                foreach ($resourceConfiguration['actions'] as $action => $actionConfiguration) {
                    $routes->add($actionConfiguration['routeName'], new Route($actionConfiguration['routePath'], [
                        '_controller' => 'PhpGuild\RhapsodyBundle\Action\ListAction::__invoke',
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
