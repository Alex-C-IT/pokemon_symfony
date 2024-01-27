<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\{PokemonRepository};
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\{Pokemon};
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
}
