<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration\Handler;

use PhpGuild\RhapsodyBundle\Configuration\Model\Action\ActionInterface;

/**
 * Class ActionModelHandler
 */
final class ActionModelHandler
{
    /** @var ActionInterface[] $collection */
    private $collection = [];

    /**
     * addModel
     *
     * @param ActionInterface $action
     */
    public function addModel(ActionInterface $action): void
    {
        $this->collection[$action::ACTION_NAME] = $action;
    }

    /**
     * get
     *
     * @param string $name
     *
     * @return ActionInterface|null
     */
    public function get(string $name): ?ActionInterface
    {
        return $this->collection[$name] ?? null;
    }

    /**
     * getActionNames
     *
     * @return array
     */
    public function getActionNames(): array
    {
        return array_keys($this->collection);
    }
}
