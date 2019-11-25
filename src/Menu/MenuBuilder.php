<?php

namespace PhpGuild\RhapsodyBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class MenuBuilder
 */
class MenuBuilder
{
    private $factory;

    /**
     * MenuBuilder constructor.
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param RequestStack $requestStack
     * @return ItemInterface
     */
    public function createSidebarMenu(RequestStack $requestStack): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('ui.dashboard', [
            'route' => 'frontend_dashboard',
        ])->setExtra('icon', 'fas fa-th');

        return $menu;
    }
}
