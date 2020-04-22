<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Action;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CreateAction
 */
class CreateAction extends AbstractController
{
    /**
     * __invoke
     *
     * @return Response
     */
    public function __invoke(): Response
    {
        return new Response('CreateAction');
    }
}
