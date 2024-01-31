<?php

namespace App\Controller;

use App\Entity\Attaque;
use App\Form\AttaqueType;
use App\Repository\AttaqueRepository;
use App\Repository\PokemonRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\{IsGranted};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AttaqueController extends AbstractController
{
    // PARTIE ADMINISTRATION

    #[Route('{_locale}/admin/attaques', name: 'app_admin_attaques_index', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(AttaqueRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $attaques = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/attaque/index.html.twig', [
            'attaques' => $attaques,
        ]);
    }

    #[Route('{_locale}/admin/attaques/new', name: 'app_admin_attaques_new', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, AttaqueRepository $repository): Response
    {
        $attaque = new Attaque();
        $form = $this->createForm(AttaqueType::class, $attaque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attaque = $form->getData();

            $repository->add($attaque);

            $this->addFlash('success', 'L\'attaque a bien été ajoutée.');

            return $this->redirectToRoute('app_admin_attaques_index');
        }

        return $this->render('admin/attaque/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('{_locale}/admin/attaques/{id}/edit', name: 'app_admin_attaques_edit', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, AttaqueRepository $repository): Response
    {
        $attaque = $repository->find($request->get('id'));
        $form = $this->createForm(AttaqueType::class, $attaque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attaque = $form->getData();

            $repository->update($attaque);

            $this->addFlash('success', 'L\'attaque #'.$attaque->getId().' a bien été modifiée.');

            return $this->redirectToRoute('app_admin_attaques_index');
        }

        return $this->render('admin/attaque/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('{_locale}/admin/attaques/{id}/delete', name: 'app_admin_attaques_delete', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, AttaqueRepository $attaqueRepository, PokemonRepository $pokemonRepository): Response
    {
        $attaque = $attaqueRepository->find($request->get('id'));

        // On supprime l'attaque de tous les pokémons qui la possèdent
        foreach ($attaque->getPokemons() as $pokemon) {
            $pokemon->removeAttaque($attaque);
            $pokemonRepository->update($pokemon);
        }
        $oldId = $attaque->getId();
        $attaqueRepository->remove($attaque);

        $this->addFlash('success', 'L\'attaque #'.$oldId.' a bien été supprimée.');

        return $this->redirectToRoute('app_admin_attaques_index');
    }

    // PARTIE PUBLIQUE

    #[Route('{_locale}/attaques', name: 'app_home_attaques_index', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    public function liste(AttaqueRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $attaques = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('public/attaques/index.html.twig', [
            'attaques' => $attaques,
        ]);
    }
}
