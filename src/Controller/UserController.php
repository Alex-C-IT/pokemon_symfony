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
use App\Enums\StatusEnum as Status;

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
            // Vérifie si le nom d'utilisateur n'est pas déjà utilisé
            if ($repository->findOneBy(['nomUtilisateur' => $user->getNomUtilisateur()])) {
                $this->addFlash('error', 'Le nom d\'utilisateur est déjà utilisé.');
                return $this->redirectToRoute('app_admin_utilisateurs_new');
            }
            $repository->add($user);

            $this->addFlash('success', 'L\'utilisateur a bien été ajouté.');

            return $this->redirectToRoute('app_admin_utilisateurs_index');
        }

        return $this->render('admin/user/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/utilisateurs/{id}/edit', name: 'app_admin_utilisateurs_edit')]
    public function edit(Request $request, UserRepository $repository): Response
    {
        $user = $repository->find($request->get('id'));
        $oldnomUtilisateur = $user->getNomUtilisateur();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            // Vérifie si le nom d'utilisateur a été modifié et si oui, vérifie si le nouveau nom d'utilisateur n'est pas déjà utilisé
            if ($oldnomUtilisateur != $user->getNomUtilisateur()) {
                $user->setNomUtilisateur($oldnomUtilisateur);
                $this->addFlash('error', 'Le nom d\'utilisateur est déjà utilisé.');
                return $this->redirectToRoute('app_admin_utilisateurs_edit', ['id' => $user->getId()]);
            }
            $repository->update($user);

            $this->addFlash('success', 'L\'utilisateur a bien été modifié.');

            return $this->redirectToRoute('app_admin_utilisateurs_index');
        }

        return $this->render('admin/user/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/utilisateurs/{id}/delete', name: 'app_admin_utilisateurs_delete')]
    public function delete(Request $request, UserRepository $repository): Response
    {
        $user = $repository->find($request->get('id'));
        $repository->remove($user);

        $this->addFlash('success', 'L\'utilisateur a bien été supprimé.');

        return $this->redirectToRoute('app_admin_utilisateurs_index');
    }

    #[Route('/admin/utilisateurs/{id}/ban', name: 'app_admin_utilisateurs_ban')]
    public function ban(Request $request, UserRepository $repository): Response
    {
        $user = $repository->find($request->get('id'));
        $user->setStatus(Status::BANNI);
        $repository->update($user);

        $this->addFlash('success', 'L\'utilisateur a bien été banni.');

        return $this->redirectToRoute('app_admin_utilisateurs_index');
    }

    #[Route('/admin/utilisateurs/{id}/deban', name: 'app_admin_utilisateurs_unban')]
    public function unban(Request $request, UserRepository $repository): Response
    {
        $user = $repository->find($request->get('id'));
        $user->setStatus(Status::ACTIF);
        $repository->update($user);

        $this->addFlash('success', 'L\'utilisateur a bien été débanni.');

        return $this->redirectToRoute('app_admin_utilisateurs_index');
    }
}
