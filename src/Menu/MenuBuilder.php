<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use PhpGuild\RhapsodyBundle\Provider\RouterProvider;
use PhpGuild\RhapsodyBundle\Provider\ThemeProviderException;

/**
 * Class MenuBuilder
 */
class MenuBuilder
{
    /** @var RouterProvider $routerProvider */
    private $routerProvider;

    /** @var FactoryInterface $factory */
    private $factory;

    /**
     * MenuBuilder constructor.
     *
     * @param RouterProvider $routerProvider
     * @param FactoryInterface $factory
     */
    public function __construct(RouterProvider $routerProvider, FactoryInterface $factory)
    {
        $this->routerProvider = $routerProvider;
        $this->factory = $factory;
    }

    /**
     * createSidebarMenu
     *
     * @return ItemInterface
     * @throws ThemeProviderException
     */
    public function createSidebarMenu(): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('rhapsody.ui.dashboard', [
            'route' => $this->routerProvider->getRoute('dashboard'),
        ])->setExtra('icon', 'fas fa-th');

        return $menu;
    }
}
