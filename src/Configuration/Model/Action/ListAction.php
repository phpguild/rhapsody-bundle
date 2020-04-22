<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration\Model\Action;

use PhpGuild\RhapsodyBundle\Configuration\Model\Field\ListField;

/**
 * Class ListAction
 */
class ListAction extends AbstractAction
{
    /** @var string */
    public const ACTION_NAME = 'list';

    /** @var string $controller */
    protected $controller = \PhpGuild\RhapsodyBundle\Action\ListAction::class;

    /** @var ListField[] $fields */
    protected $fields = [];
}
