<?php

namespace PhpGuild\RhapsodyBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use PhpGuild\RhapsodyBundle\Provider\RouterProvider;

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
     * @return ItemInterface
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
