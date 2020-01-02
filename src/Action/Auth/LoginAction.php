<?php

namespace PhpGuild\RhapsodyBundle\Action\Auth;

use PhpGuild\RhapsodyBundle\Provider\RouterProvider;
use PhpGuild\RhapsodyBundle\Provider\ThemeProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class LoginAction
 */
class LoginAction extends AbstractController
{
    /** @var RouterProvider $routerProvider */
    private $routerProvider;

    /** @var ThemeProvider $themeProvider */
    private $themeProvider;

    /**
     * LoginAction constructor.
     *
     * @param RouterProvider $routerProvider
     * @param ThemeProvider $themeProvider
     */
    public function __construct(RouterProvider $routerProvider, ThemeProvider $themeProvider)
    {
        $this->routerProvider = $routerProvider;
        $this->themeProvider = $themeProvider;
    }

    /**
     * __invoke
     *
     * @param AuthenticationUtils $authenticationUtils
     * @param Request $request
     * @return Response
     */
    public function __invoke(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        if ($this->getUser()) {
            return  $this->redirect($this->generateUrl($this->routerProvider->getRoute('dashboard')));
        }

        return $this->render($this->themeProvider->getView('auth/login.html.twig'), [
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'last_username' => $authenticationUtils->getLastUsername(),
            'csrf_token' => false,
        ]);
    }
}
