<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\{AttaqueRepository, PokemonRepository};
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\{Attaque, Pokemon};
use App\Form\AttaqueType;

class AttaqueController extends AbstractController
{
    #[Route('/admin/attaques', name: 'app_admin_attaques_index')]
    public function index(AttaqueRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $attaques = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/attaque/index.html.twig', [
            'attaques' => $attaques
        ]);
    }

    #[Route('/admin/attaques/new', name: 'app_admin_attaques_new')]
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
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/attaques/{id}/edit', name: 'app_admin_attaques_edit')]
    public function edit(Request $request, AttaqueRepository $repository): Response
    {
        $attaque = $repository->find($request->get('id'));
        $form = $this->createForm(AttaqueType::class, $attaque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attaque = $form->getData();

            $repository->update($attaque);

            $this->addFlash('success', 'L\'attaque #' . $attaque->getId() . ' a bien été modifiée.');

            return $this->redirectToRoute('app_admin_attaques_index');
        }

        return $this->render('admin/attaque/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/attaques/{id}/delete', name: 'app_admin_attaques_delete')]
    public function delete(Request $request, AttaqueRepository $attaqueRepository, PokemonRepository $pokemonRepository): Response
    {
        $attaque = $attaqueRepository->find($request->get('id'));

        // On supprime l'attaque de tous les pokémons qui la possèdent
        foreach ($attaque->getPokemons() as $pokemon) {
            $pokemon->removeAttaque($attaque);
            $pokemonRepository->update($pokemon);
        }

        $attaqueRepository->remove($attaque);

        $this->addFlash('success', 'L\'attaque #' . $attaque->getId() . ' a bien été supprimée.');

        return $this->redirectToRoute('app_admin_attaques_index');
    }
}
