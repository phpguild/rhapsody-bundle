<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use PhpGuild\RhapsodyBundle\Configuration\ConfigurationManager;
use PhpGuild\RhapsodyBundle\Provider\ThemeProviderException;

/**
 * Class MenuBuilder
 */
class MenuBuilder
{
    /** @var FactoryInterface $factory */
    private $factory;

    /** @var ConfigurationManager $configurationManager */
    private $configurationManager;

    /**
     * MenuBuilder constructor.
     *
     * @param FactoryInterface     $factory
     * @param ConfigurationManager $configurationManager
     */
    public function __construct(
        FactoryInterface $factory,
        ConfigurationManager $configurationManager
    ) {
        $this->factory = $factory;
        $this->configurationManager = $configurationManager;
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
            'route' => 'admin_dashboard',
        ])->setExtra('icon', 'fas fa-th');

        foreach ($this->configurationManager->getResources() as $resource) {
            $menuItem = $menu->addChild($resource['label'], [
                'route' => $resource['primaryRouteName'],
            ]);

            if ($resource['icon']) {
                $menuItem->setExtra('icon', $resource['icon']);
            }
        }

        return $menu;
    }
}
