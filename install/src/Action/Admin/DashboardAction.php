<?php

declare(strict_types=1);

namespace App\Action\Admin;

use PhpGuild\RhapsodyBundle\Provider\ThemeProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/", name="admin_dashboard")
     * @param Request $request
     * @return Response
     * @throws \PhpGuild\RhapsodyBundle\Provider\ThemeProviderException
     */
    public function __invoke(Request $request): Response
    {
        return $this->render($this->themeProvider->getView('dashboard.html.twig'));
    }
}
