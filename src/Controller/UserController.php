<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\UserType;

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

    #[Route('/admin/utilisateurs/new', name: 'app_admin_utilisateurs_new')]
    public function new(Request $request, UserRepository $repository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            $repository->add($user);

            $this->addFlash('success', 'L\'utilisateur a bien été ajouté.');

            return $this->redirectToRoute('app_admin_utilisateurs_index');
        }

        return $this->render('admin/user/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
