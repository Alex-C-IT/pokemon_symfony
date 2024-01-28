<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\{PokemonRepository, TypeRepository, AttaqueRepository};
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\{Pokemon, Type, Generation};
use App\Form\PokemonType;


class PokemonController extends AbstractController
{
    #[Route('/admin/pokemons', name: 'app_admin_pokemons_index')]
    public function index(PokemonRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $pokemons = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/pokemon/index.html.twig', [
            'pokemons' => $pokemons
        ]);
    }

    #[Route('/admin/pokemons/new', name: 'app_admin_pokemons_new')]
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
            if($imageFile && $miniImageFile) {
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
            'form' => $form->createView()
        ]);
    }
}
