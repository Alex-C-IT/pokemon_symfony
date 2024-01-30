<?php

namespace App\Controller;

use App\Entity\Consommable;
use App\Form\ConsommableType;
use App\Repository\ConsommableRepository;
use App\Repository\PokemonRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsommableController extends AbstractController
{
    #[Route('{_locale}/admin/consommables', name: 'app_admin_consommables_index', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    public function index(ConsommableRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $consommables = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('admin/consommable/index.html.twig', [
            'consommables' => $consommables,
        ]);
    }

    #[Route('{_locale}/admin/consommables/new', name: 'app_admin_consommables_new', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    public function new(Request $request, ConsommableRepository $repository): Response
    {
        $consommable = new Consommable();
        $form = $this->createForm(ConsommableType::class, $consommable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $consommable = $form->getData();

            $repository->add($consommable);

            $this->addFlash('success', 'Le consommable a bien été ajoutée.');

            return $this->redirectToRoute('app_admin_consommables_index');
        }

        return $this->render('admin/consommable/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('{_locale}/admin/consommables/{id}/edit', name: 'app_admin_consommables_edit', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    public function edit(Request $request, ConsommableRepository $repository): Response
    {
        $consommable = $repository->find($request->get('id'));
        $form = $this->createForm(ConsommableType::class, $consommable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $consommable = $form->getData();

            $repository->update($consommable);

            $this->addFlash('success', 'Le consommable a bien été modifiée.');

            return $this->redirectToRoute('app_admin_consommables_index');
        }

        return $this->render('admin/consommable/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('{_locale}/admin/consommables/{id}/delete', name: 'app_admin_consommables_delete', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    public function delete(Request $request, ConsommableRepository $repository, PokemonRepository $pokemonRepository): Response
    {
        $consommable = $repository->find($request->get('id'));

        // On met le consommable à null pour tous les pokémons de la génération à supprimer
        foreach ($consommable->getPokemons() as $pokemon) {
            $pokemon->setConsommable(null);
            $pokemonRepository->update($pokemon);
        }

        $repository->remove($consommable);

        $this->addFlash('success', 'La génération a bien été supprimée.');

        return $this->redirectToRoute('app_admin_consommables_index');
    }

    // PARTIE PUBLIQUE

    #[Route('{_locale}/objets', name: 'app_home_consommables_index', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    public function liste(ConsommableRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $consommables = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('public/consommables/index.html.twig', [
            'consommables' => $consommables,
        ]);
    }
}
