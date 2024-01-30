<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\{GenerationRepository, PokemonRepository};
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Generation;
use App\Form\GenerationType;

class GenerationController extends AbstractController
{
    #[Route('{_locale}/admin/generations', name: 'app_admin_generations_index', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    public function index(GenerationRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $generations = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('admin/generation/index.html.twig', [
            'generations' => $generations
        ]);
    }

    #[Route('{_locale}/admin/generations/new', name: 'app_admin_generations_new', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    public function new(Request $request, GenerationRepository $repository): Response
    {
        $generation = new Generation();
        $form = $this->createForm(GenerationType::class, $generation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $generation = $form->getData();

            $repository->add($generation);

            $this->addFlash('success', 'La génération a bien été ajoutée.', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr']);

            return $this->redirectToRoute('app_admin_generations_index');
        }

        return $this->render('admin/generation/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('{_locale}/admin/generations/{id}/edit', name: 'app_admin_generations_edit', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    public function edit(Request $request, GenerationRepository $repository): Response
    {
        $generation = $repository->find($request->get('id'));
        $form = $this->createForm(GenerationType::class, $generation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $generation = $form->getData();

            $repository->update($generation);

            $this->addFlash('success', 'La génération a bien été modifiée.', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr']);

            return $this->redirectToRoute('app_admin_generations_index');
        }

        return $this->render('admin/generation/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('{_locale}/admin/generations/{id}/delete', name: 'app_admin_generations_delete', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    public function delete(Request $request, GenerationRepository $repository, PokemonRepository $pokemonRepository): Response
    {
        $generation = $repository->find($request->get('id'));

        // On met la génération à null pour tous les pokémons de la génération à supprimer
        foreach ($generation->getPokemons() as $pokemon) {
            $pokemon->setGeneration(null);
            $pokemonRepository->update($pokemon);
        }

        $repository->remove($generation);

        $this->addFlash('success', 'La génération a bien été supprimée.', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr']);
        return $this->redirectToRoute('app_admin_generations_index');
    }
}
