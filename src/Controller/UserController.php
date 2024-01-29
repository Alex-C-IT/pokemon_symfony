<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    #[Route('/admin/utilisateurs', name: 'app_admin_utilisateurs_index')]
    public function index(UserRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $users = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/user/index.html.twig', [
            'users' => $users
        ]);
    }
}
