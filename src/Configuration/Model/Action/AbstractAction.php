<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration\Model\Action;

use PhpGuild\RhapsodyBundle\Configuration\Model\Field\FieldInterface;
use PhpGuild\RhapsodyBundle\Configuration\Model\Field\RouteInterface;
use PhpGuild\RhapsodyBundle\Configuration\Model\Field\Route;

/**
 * Class Action
 */
abstract class AbstractAction implements ActionInterface
{
    /** @var Route|null $route */
    protected $route;

    /** @var bool $default */
    protected $default = false;

    /** @var FieldInterface[] $fields */
    protected $fields = [];

    /** @var string|null $controller */
    protected $controller;

    /**
     * getRoute
     *
     * @return RouteInterface|null
     */
    public function getRoute(): ?RouteInterface
    {
        return $this->route;
    }

    /**
     * setRoute
     *
     * @param RouteInterface|null $route
     *
     * @return ActionInterface
     */
    public function setRoute(?RouteInterface $route): ActionInterface
    {
        $this->route = $route;

        return $this;
    }

    /**
     * isDefault
     *
     * @return bool
     */
    public function isDefault(): bool
    {
        return $this->default;
    }

    /**
     * setDefault
     *
     * @param bool $default
     *
     * @return ActionInterface|self
     */
    public function setDefault(bool $default): ActionInterface
    {
        $this->default = $default;

        return $this;
    }

    /**
     * getFields
     *
     * @return FieldInterface[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * setFields
     *
     * @param array $fields
     *
     * @return ActionInterface|self
     */
    public function setFields(array $fields): ActionInterface
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * getController
     *
     * @return string|null
     */
    public function getController(): ?string
    {
        return $this->controller;
    }

    /**
     * setController
     *
     * @param string|null $controller
     *
     * @return ActionInterface|self
     */
    public function setController(?string $controller): ActionInterface
    {
        $this->controller = $controller;

        return $this;
    }
}
