<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration\Model\Resource;

use PhpGuild\RhapsodyBundle\Configuration\Model\Action\ActionInterface;
use PhpGuild\RhapsodyBundle\Configuration\Model\Field\RouteInterface;

/**
 * Interface ResourceNormalizerInterface
 */
interface ResourceNormalizerInterface
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
     * @return ResourceNormalizerInterface|self
     */
    public function setPrimaryRoute(?RouteInterface $primaryRoute): ResourceNormalizerInterface;

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
     * @return ResourceNormalizerInterface|self
     */
    public function setLabel(?string $label): ResourceNormalizerInterface;

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
     * @return ResourceNormalizerInterface|self
     */
    public function setIcon(?string $icon): ResourceNormalizerInterface;

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
     * @return ResourceNormalizerInterface|self
     */
    public function setActions(array $actions): ResourceNormalizerInterface;
}
