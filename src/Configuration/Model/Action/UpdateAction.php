<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration\Model\Action;

/**
 * Class UpdateAction
 */
class UpdateAction extends FormAction
{
    /** @var string */
    public const ACTION_NAME = 'update';

    /** @var string $controller */
    protected $controller = \PhpGuild\RhapsodyBundle\Action\UpdateAction::class;
}
