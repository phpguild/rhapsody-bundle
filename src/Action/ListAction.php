<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Action;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class ListAction
 */
class ListAction extends AbstractController
{
    /**
     * __invoke
     */
    public function __invoke()
    {
        dump('ok');exit;
    }
}
