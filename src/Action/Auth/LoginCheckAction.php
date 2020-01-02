<?php

namespace PhpGuild\RhapsodyBundle\Action\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LoginCheckAction
 */
class LoginCheckAction extends AbstractController
{
    /**
     * __invoke
     *
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function __invoke(Request $request): Response
    {
        throw new \Exception();
    }
}
