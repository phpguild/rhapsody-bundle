<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Action;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateAction
 */
class UpdateAction extends AbstractController
{
    /**
     * __invoke
     *
     * @return Response
     */
    public function __invoke(): Response
    {
        return new Response('UpdateAction');
    }
}
