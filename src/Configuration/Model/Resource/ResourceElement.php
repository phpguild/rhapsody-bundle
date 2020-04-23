<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration\Model\Resource;

use PhpGuild\RhapsodyBundle\Configuration\Model\Action\ActionInterface;
use PhpGuild\RhapsodyBundle\Configuration\Model\Field\RouteInterface;

/**
 * Class ResourceElement
 */
class ResourceElement implements ResourceElementInterface
{
    /** @var RouteInterface|null $primaryRoute */
    protected $primaryRoute;

    /** @var string|null $label */
    protected $label;

    /** @var string|null $icon */
    protected $icon;

    /** @var ActionInterface[] $actions */
    protected $actions = [];

    /**
     * getPrimaryRoute
     *
     * @return RouteInterface|null
     */
    public function getPrimaryRoute(): ?RouteInterface
    {
        return $this->primaryRoute;
    }

    /**
     * setPrimaryRoute
     *
     * @param RouteInterface|null $primaryRoute
     *
     * @return ResourceElementInterface|self
     */
    public function setPrimaryRoute(?RouteInterface $primaryRoute): ResourceElementInterface
    {
        $this->primaryRoute = $primaryRoute;

        return $this;
    }

    /**
     * getLabel
     *
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * setLabel
     *
     * @param string|null $label
     *
     * @return ResourceElementInterface|self
     */
    public function setLabel(?string $label): ResourceElementInterface
    {
        $this->label = $label;

        return $this;
    }

    /**
     * getIcon
     *
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * setIcon
     *
     * @param string|null $icon
     *
     * @return ResourceElementInterface|self
     */
    public function setIcon(?string $icon): ResourceElementInterface
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * getActions
     *
     * @return ActionInterface[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * getDefaultAction
     *
     * @return ActionInterface|null
     */
    public function getDefaultAction(): ?ActionInterface
    {
        if (!\count($this->actions)) {
            return null;
        }

        /** @var ActionInterface $configuration */
        foreach ($this->actions as $configuration) {
            if (!$configuration->isDefault()) {
                continue;
            }

            return $configuration;
        }

        return $this->actions[array_key_first($this->actions)];
    }

    /**
     * setActions
     *
     * @param ActionInterface[] $actions
     *
     * @return ResourceElementInterface|self
     */
    public function setActions(array $actions): ResourceElementInterface
    {
        $this->actions = $actions;

        return $this;
    }
}
