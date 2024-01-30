<?php

namespace App\Controller;

use App\Entity\Dresseur;
use App\Form\DresseurType;
use App\Form\MesDresseursType;
use App\Repository\{DresseurRepository};
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\{IsGranted};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DresseurController extends AbstractController
{
    #[Route('{_locale}/admin/dresseurs', name: 'app_admin_dresseurs_index', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(DresseurRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $dresseurs = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/dresseur/index.html.twig', [
            'dresseurs' => $dresseurs,
        ]);
    }

    #[Route('{_locale}/admin/dresseurs/new', name: 'app_admin_dresseurs_new', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, DresseurRepository $repository): Response
    {
        $dresseur = new Dresseur();
        $form = $this->createForm(DresseurType::class, $dresseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dresseur = $form->getData();

            // Contrôle si le dresseur n'a pas plus de 6 pokémons
            if (count($dresseur->getPokemons()) > 6) {
                $this->addFlash('error', 'Un dresseur ne peut pas avoir plus de 6 pokémons !');

                return $this->redirectToRoute('app_admin_dresseurs_new');
            }

            $repository->add($dresseur);

            $this->addFlash('success', 'Le dresseur a bien été ajouté !');

            return $this->redirectToRoute('app_admin_dresseurs_index');
        }

        return $this->render('admin/dresseur/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('{_locale}/admin/dresseurs/{id}/edit', name: 'app_admin_dresseurs_edit', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, DresseurRepository $repository): Response
    {
        $dresseur = $repository->find($request->get('id'));
        $form = $this->createForm(DresseurType::class, $dresseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dresseur = $form->getData();

            if (count($dresseur->getPokemons()) > 6) {
                $this->addFlash('error', 'Un dresseur ne peut pas avoir plus de 6 pokémons !');

                return $this->redirectToRoute('app_admin_dresseurs_edit', ['id' => $dresseur->getId()]);
            }

            $repository->update($dresseur);

            $this->addFlash('success', 'Le dresseur a bien été modifié !');

            return $this->redirectToRoute('app_admin_dresseurs_index', ['id' => $dresseur->getId()]);
        }

        return $this->render('admin/dresseur/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('{_locale}/admin/dresseurs/{id}/delete', name: 'app_admin_dresseurs_delete', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, DresseurRepository $repository): Response
    {
        $dresseur = $repository->find($request->get('id'));
        $oldId = $dresseur->getId();
        $repository->remove($dresseur);

        $this->addFlash('success', 'Le dresseur #'.$oldId.' ('.$dresseur->getNom().') a bien été supprimé !');

        return $this->redirectToRoute('app_admin_dresseurs_index');
    }

    // PARTIE PUBLIQUE

    // Affiche les dresseurs de l'utilisateur connecté
    #[Route('{_locale}/mesdresseurs', name: 'app_user_mesdresseurs_index', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_USER')]
    public function mesdresseurs(DresseurRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $dresseurs = $paginator->paginate(
            $repository->findBy(['user' => $this->getUser()]),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('public/mesdresseurs/index.html.twig', [
            'dresseurs' => $dresseurs,
        ]);
    }

    #[Route('{_locale}/mesdresseurs/new', name: 'app_user_mesdresseurs_new', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_USER')]
    public function mesdresseursNew(Request $request, DresseurRepository $repository): Response
    {
        $dresseur = new Dresseur();
        $form = $this->createForm(MesDresseursType::class, $dresseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dresseur = $form->getData();

            if (count($dresseur->getPokemons()) > 6) {
                $this->addFlash('error', 'Un dresseur ne peut pas avoir plus de 6 pokémons !');

                return $this->redirectToRoute('app_user_mesdresseurs_new');
            }

            $dresseur->setUser($this->getUser());
            $repository->add($dresseur);

            $this->addFlash('success', 'Votre dresseur #'.$dresseur->getNom().' a bien été ajouté !');

            return $this->redirectToRoute('app_user_mesdresseurs_index');
        }

        return $this->render('public/mesdresseurs/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('{_locale}/mesdresseurs/{id}/edit', name: 'app_user_mesdresseurs_edit', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_USER')]
    public function mesdresseursEdit(Request $request, DresseurRepository $repository): Response
    {
        $dresseur = $repository->find($request->get('id'));

        // Controle si le dresseur existe
        if (!$dresseur) {
            $this->addFlash('error', 'Ce dresseur n\'existe pas !');

            return $this->redirectToRoute('app_user_mesdresseurs_index');
        }

        // Controle si le dresseur appartient bien à l'utilisateur connecté
        if ($this->getUser() != $dresseur->getUser()) {
            $this->addFlash('error', 'Vous ne pouvez pas modifier ce dresseur !');

            return $this->redirectToRoute('app_user_mesdresseurs_index');
        }

        $form = $this->createForm(MesDresseursType::class, $dresseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dresseur = $form->getData();

            if (count($dresseur->getPokemons()) > 6) {
                $this->addFlash('error', 'Un dresseur ne peut pas avoir plus de 6 pokémons !');

                return $this->redirectToRoute('app_user_mesdresseurs_edit', ['id' => $dresseur->getId()]);
            }

            $repository->update($dresseur);

            $this->addFlash('success', 'Votre dresseur #'.$dresseur->getNom().' a bien été modifié !');

            return $this->redirectToRoute('app_user_mesdresseurs_index');
        }

        return $this->render('public/mesdresseurs/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('{_locale}/mesdresseurs/{id}/delete', name: 'app_user_mesdresseurs_delete', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_USER')]
    public function mesdresseursDelete(Request $request, DresseurRepository $repository): Response
    {
        $dresseur = $repository->find($request->get('id'));

        // Controle si le dresseur existe
        if (!$dresseur) {
            $this->addFlash('error', 'Ce dresseur n\'existe pas !');

            return $this->redirectToRoute('app_user_mesdresseurs_index');
        }

        // Controle si le dresseur appartient bien à l'utilisateur connecté
        if ($this->getUser() != $dresseur->getUser()) {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer ce dresseur !');

            return $this->redirectToRoute('app_user_mesdresseurs_index');
        }

        $oldId = $dresseur->getId();
        $repository->remove($dresseur);

        $this->addFlash('success', 'Votre dresseur #'.$dresseur->getNom().' a bien pris sa retraite !');

        return $this->redirectToRoute('app_user_mesdresseurs_index');
    }
}
