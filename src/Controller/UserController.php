<?php

namespace App\Controller;

use App\Entity\User;
use App\Enums\StatusEnum as Status;
use App\Form\ProfilType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\{IsGranted};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('{_locale}/admin/utilisateurs', name: 'app_admin_utilisateurs_index', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(UserRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $users = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('{_locale}/admin/utilisateurs/new', name: 'app_admin_utilisateurs_new', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_ADMIN')]
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
            'form' => $form->createView(),
        ]);
    }

    #[Route('{_locale}/admin/utilisateurs/{id}/edit', name: 'app_admin_utilisateurs_edit', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, UserRepository $repository): Response
    {
        $user = $repository->find($request->get('id'));
        $oldUsername = $user->getNomUtilisateur();
        $oldEmail = $user->getEmail();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            // Vérifie si le nom d'utilisateur a été modifié et si oui, vérifie si le nouveau nom d'utilisateur n'est pas déjà utilisé par un autre utilisateur
            if ($repository->findOneBy(['nomUtilisateur' => $user->getNomUtilisateur()]) && $user->getNomUtilisateur() !== $oldUsername) {
                $this->addFlash('error', 'Le nom d\'utilisateur est déjà utilisé.');

                return $this->redirectToRoute('app_admin_utilisateurs_edit', ['id' => $user->getId()]);
            }
            // Vérifie si le email a été modifié et si oui, vérifie si le nouveau email n'est pas déjà utilisé par un autre utilisateur
            if ($repository->findOneBy(['email' => $user->getEmail()]) && $user->getEmail() !== $oldEmail) {
                $this->addFlash('error', 'L\'email est déjà utilisé.');

                return $this->redirectToRoute('app_admin_utilisateurs_edit', ['id' => $user->getId()]);
            }
            $repository->update($user);

            $this->addFlash('success', 'L\'utilisateur a bien été modifié.');

            return $this->redirectToRoute('app_admin_utilisateurs_index');
        }

        return $this->render('admin/user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('{_locale}/admin/utilisateurs/{id}/delete', name: 'app_admin_utilisateurs_delete', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, UserRepository $repository): Response
    {
        $user = $repository->find($request->get('id'));
        $repository->remove($user);

        $this->addFlash('success', 'L\'utilisateur a bien été supprimé.');

        return $this->redirectToRoute('app_admin_utilisateurs_index');
    }

    #[Route('{_locale}/admin/utilisateurs/{id}/ban', name: 'app_admin_utilisateurs_ban', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_ADMIN')]
    public function ban(Request $request, UserRepository $repository): Response
    {
        $user = $repository->find($request->get('id'));
        $user->setStatus(Status::BANNI);
        $repository->update($user);

        $this->addFlash('success', 'L\'utilisateur a bien été banni.');

        return $this->redirectToRoute('app_admin_utilisateurs_index');
    }

    #[Route('{_locale}/admin/utilisateurs/{id}/deban', name: 'app_admin_utilisateurs_unban', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_ADMIN')]
    public function unban(Request $request, UserRepository $repository): Response
    {
        $user = $repository->find($request->get('id'));
        $user->setStatus(Status::ACTIF);
        $repository->update($user);

        $this->addFlash('success', 'L\'utilisateur a bien été débanni.');

        return $this->redirectToRoute('app_admin_utilisateurs_index');
    }

    #[Route('{_locale}/monprofil', name: 'app_user_params_index', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_USER')]
    public function params(Request $request, UserRepository $repository): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfilType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repository->update($user);

            $this->addFlash(
                'success',
                'Votre compte a bien été modifié.'
            );

            return $this->redirectToRoute('app_user_params_index');
        }

        return $this->render('public/profil/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
