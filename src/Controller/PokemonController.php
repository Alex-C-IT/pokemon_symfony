<?php

namespace App\Controller;

use App\Entity\Pokemon;
use App\Form\PokemonType;
use App\Repository\PokemonRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PokemonController extends AbstractController
{
    // PARTIE ADMINISTRATION

    #[Route('{_locale}/admin/pokemons', name: 'app_admin_pokemons_index', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    public function index(PokemonRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $pokemons = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/pokemon/index.html.twig', [
            'pokemons' => $pokemons,
        ]);
    }

    #[Route('{_locale}/admin/pokemons/new', name: 'app_admin_pokemons_new', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    public function new(Request $request, PokemonRepository $repository): Response
    {
        $pokemon = new Pokemon();
        $form = $this->createForm(PokemonType::class, $pokemon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pokemon = $form->getData();

            // Sauvgarde l'image et la miniImage dans le dossier public/images/pokemons et public/images/pokemons/miniatures
            $imageFile = $form->get('image')->getData();
            $miniImageFile = $form->get('miniImage')->getData();
            if ($imageFile && $miniImageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $originalMiniFilename = pathinfo($miniImageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // Format du nom de l'image : numero_nom.png (exemple : 0001_bulbizarre.png) - Supprime les espaces et les caractères spéciaux
                $newFilename = $pokemon->getNumero().'_'.preg_replace('/[^A-Za-z0-9\-]/', '', $pokemon->getNom()).'.'.$imageFile->guessExtension();
                // Format du nom de l'image miniature : numero_nom_mini.png (exemple : 0001_bulbizarre_mini.png) - Supprime les espaces et les caractères spéciaux
                $newMiniFilename = $pokemon->getNumero().'_'.preg_replace('/[^A-Za-z0-9\-]/', '', $pokemon->getNom()).'_mini.'.$miniImageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('images_pokemons_directory'),
                    $newFilename
                );
                $miniImageFile->move(
                    $this->getParameter('images_mini_pokemons_directory'),
                    $newMiniFilename
                );
                $pokemon->setImage($newFilename);
                $pokemon->setMiniImage($newMiniFilename);
            }

            $repository->add($pokemon);
            $this->addFlash('success', 'Le pokemon a bien été ajouté.');

            return $this->redirectToRoute('app_admin_pokemons_index');
        }

        return $this->render('admin/pokemon/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('{_locale}/admin/pokemons/{id}/edit', name: 'app_admin_pokemons_edit', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    public function edit(Request $request, PokemonRepository $repository): Response
    {
        $pokemon = $repository->find($request->get('id'));
        $form = $this->createForm(PokemonType::class, $pokemon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pokemon = $form->getData();
            // Supprime l'ancienne image et l'ancienne miniature
            $oldImage = $this->getParameter('images_pokemons_directory').'/'.$pokemon->getImage();
            $oldMiniImage = $this->getParameter('images_mini_pokemons_directory').'/'.$pokemon->getMiniImage();
            if (file_exists($oldImage) && file_exists($oldMiniImage)) {
                unlink($oldImage);
                unlink($oldMiniImage);
            }
            // Sauvgarde l'image et la miniImage dans le dossier public/images/pokemons et public/images/pokemons/miniatures
            $imageFile = $form->get('image')->getData();
            $miniImageFile = $form->get('miniImage')->getData();
            if ($imageFile && $miniImageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $originalMiniFilename = pathinfo($miniImageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // Format du nom de l'image : numero_nom.png (exemple : 0001_bulbizarre.png) - Supprime les espaces et les caractères spéciaux
                $newFilename = $pokemon->getNumero().'_'.preg_replace('/[^A-Za-z0-9\-]/', '', $pokemon->getNom()).'.'.$imageFile->guessExtension();
                // Format du nom de l'image miniature : numero_nom_mini.png (exemple : 0001_bulbizarre_mini.png) - Supprime les espaces et les caractères spéciaux
                $newMiniFilename = $pokemon->getNumero().'_'.preg_replace('/[^A-Za-z0-9\-]/', '', $pokemon->getNom()).'_mini.'.$miniImageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('images_pokemons_directory'),
                    $newFilename
                );
                $miniImageFile->move(
                    $this->getParameter('images_mini_pokemons_directory'),
                    $newMiniFilename
                );
                $pokemon->setImage($newFilename);
                $pokemon->setMiniImage($newMiniFilename);
            }

            $repository->update($pokemon);
            $this->addFlash('success', 'Le pokemon #'.$pokemon->getId().' a bien été modifié.');

            return $this->redirectToRoute('app_admin_pokemons_index');
        }

        return $this->render('admin/pokemon/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('{_locale}/admin/pokemons/{id}/delete', name: 'app_admin_pokemons_delete', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    public function delete(Request $request, PokemonRepository $repository): Response
    {
        $pokemon = $repository->find($request->get('id'));
        $oldNumero = $pokemon->getNumero();
        $oldNom = $pokemon->getNom();
        $oldImage = $this->getParameter('images_pokemons_directory').'/'.$pokemon->getImage();
        $oldMiniImage = $this->getParameter('images_mini_pokemons_directory').'/'.$pokemon->getMiniImage();
        if (file_exists($oldImage) && file_exists($oldMiniImage)) {
            unlink($oldImage);
            unlink($oldMiniImage);
        }
        $repository->remove($pokemon);
        $this->addFlash('success', 'Le pokemon #'.$oldNumero.' ('.$oldNom.') a bien été supprimé.');

        return $this->redirectToRoute('app_admin_pokemons_index');
    }

    // PARTIE PUBLIQUE

    #[Route('{_locale}/pokemons', name: 'app_home_pokemons_index', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    public function liste(PokemonRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $pokemons = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('public/pokemons/index.html.twig', [
            'pokemons' => $pokemons,
        ]);
    }
}
