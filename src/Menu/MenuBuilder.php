<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use PhpGuild\RhapsodyBundle\Configuration\ConfigurationManager;
use PhpGuild\RhapsodyBundle\Configuration\Model\Resource\ResourceElementInterface;
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
