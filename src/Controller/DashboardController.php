<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\{IsGranted};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('{_locale}/admin/', name: 'app_admin_index', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        return $this->render('admin/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
