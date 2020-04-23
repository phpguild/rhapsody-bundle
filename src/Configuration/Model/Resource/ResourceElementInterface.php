<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration\Model\Resource;

use PhpGuild\RhapsodyBundle\Configuration\Model\Action\ActionInterface;
use PhpGuild\RhapsodyBundle\Configuration\Model\Field\RouteInterface;

/**
 * Interface ResourceElementInterface
 */
interface ResourceElementInterface
{
    /**
     * getPrimaryRoute
     *
     * @return RouteInterface|null
     */
    public function getPrimaryRoute(): ?RouteInterface;

    /**
     * setPrimaryRoute
     *
     * @param RouteInterface|null $primaryRoute
     *
     * @return ResourceElementInterface|self
     */
    public function setPrimaryRoute(?RouteInterface $primaryRoute): ResourceElementInterface;

    /**
     * getLabel
     *
     * @return string|null
     */
    public function getLabel(): ?string;

    /**
     * setLabel
     *
     * @param string|null $label
     *
     * @return ResourceElementInterface|self
     */
    public function setLabel(?string $label): ResourceElementInterface;

    /**
     * getIcon
     *
     * @return string|null
     */
    public function getIcon(): ?string;

    /**
     * setIcon
     *
     * @param string|null $icon
     *
     * @return ResourceElementInterface|self
     */
    public function setIcon(?string $icon): ResourceElementInterface;

    /**
     * getActions
     *
     * @return ActionInterface[]
     */
    public function getActions(): array;

    /**
     * getDefaultAction
     *
     * @return ActionInterface|null
     */
    public function getDefaultAction(): ?ActionInterface;

    /**
     * setActions
     *
     * @param ActionInterface[] $actions
     *
     * @return ResourceElementInterface|self
     */
    public function setActions(array $actions): ResourceElementInterface;
}
