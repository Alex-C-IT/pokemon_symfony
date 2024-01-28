<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\{DresseurRepository};
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

    #[Route('/admin/dresseurs/new', name: 'app_admin_dresseurs_new')]
    public function new(Request $request, DresseurRepository $repository): Response
    {
        $dresseur = new Dresseur();
        $form = $this->createForm(DresseurType::class, $dresseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dresseur = $form->getData();
            //dd($dresseur);
            $repository->add($dresseur);

            $this->addFlash('success', 'Le dresseur a bien été ajouté !');

            return $this->redirectToRoute('app_admin_dresseurs_index');
        }

        return $this->render('admin/dresseur/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
