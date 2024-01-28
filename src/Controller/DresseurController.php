<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\{DresseurRepository, PokemonRepository};
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\{Dresseur, Pokemon};
use App\Form\DresseurType;

class DresseurController extends AbstractController
{
    #[Route('/admin/dresseurs', name:'app_admin_dresseurs_index')]
    public function index(DresseurRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $dresseurs = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/dresseur/index.html.twig', [
            'dresseurs' => $dresseurs
        ]);
    }
}
