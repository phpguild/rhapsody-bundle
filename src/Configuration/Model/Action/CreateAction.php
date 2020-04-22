<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration\Model\Action;

/**
 * Class CreateAction
 */
class CreateAction extends FormAction
{
    /** @var string */
    public const ACTION_NAME = 'create';

    /** @var string $controller */
    protected $controller = \PhpGuild\RhapsodyBundle\Action\CreateAction::class;
}
