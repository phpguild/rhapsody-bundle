<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration\Model\Action;

use PhpGuild\RhapsodyBundle\Configuration\Model\Field\FormField;

/**
 * Class FormAction
 */
class FormAction extends AbstractAction
{
    /** @var string */
    public const ACTION_NAME = 'form';

    /** @var FormField[] $fields */
    protected $fields = [];
}
