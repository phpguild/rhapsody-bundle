<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use PhpGuild\ResourceBundle\Configuration\ConfigurationException;
use PhpGuild\ResourceBundle\Model\Resource\ResourceElementInterface;
use PhpGuild\RhapsodyBundle\Configuration\RhapsodyConfigurationManager;

/**
 * Class MenuBuilder
 */
class MenuBuilder
{
    /** @var FactoryInterface $factory */
    private $factory;

    /** @var RhapsodyConfigurationManager $configurationManager */
    private $configurationManager;

    /**
     * MenuBuilder constructor.
     *
     * @param FactoryInterface     $factory
     * @param RhapsodyConfigurationManager $configurationManager
     */
    public function __construct(
        FactoryInterface $factory,
        RhapsodyConfigurationManager $configurationManager
    ) {
        $this->factory = $factory;
        $this->configurationManager = $configurationManager;
    }

    /**
     * createSidebarMenu
     *
     * @return ItemInterface
     * @throws ConfigurationException
     */
    public function createSidebarMenu(): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('rhapsody.ui.dashboard', [
            'route' => 'admin_dashboard',
        ])->setExtra('icon', 'fas fa-th');

        /** @var ResourceElementInterface $resource */
        foreach ($this->configurationManager->getConfiguration()->getResources() as $resource) {
            $primaryRoute = $resource->getPrimaryRoute();
            if (!$primaryRoute) {
                continue;
            }

            $menuItem = $menu->addChild($resource->getLabel(), [
                'route' => $primaryRoute->getName(),
            ]);

            if ($resource->getIcon()) {
                $menuItem->setExtra('icon', $resource->getIcon());
            }
        }

        return $menu;
    }
}
