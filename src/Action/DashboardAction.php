<?php

namespace PhpGuild\RhapsodyBundle\Action;

use PhpGuild\RhapsodyBundle\Provider\ThemeProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DashboardAction
 */
class DashboardAction extends AbstractController
{
    /** @var ThemeProvider $themeProvider */
    private $themeProvider;

    /**
     * DashboardAction constructor.
     *
     * @param ThemeProvider $themeProvider
     */
    public function __construct(ThemeProvider $themeProvider)
    {
        $this->themeProvider = $themeProvider;
    }

    /**
     * __invoke
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        return $this->render($this->themeProvider->getView('dashboard.html.twig'));
    }
}
