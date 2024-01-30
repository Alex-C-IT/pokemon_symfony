<?php

namespace App\Controller;

use App\Entity\Dresseur;
use App\Form\DresseurType;
use App\Repository\{DresseurRepository};
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DresseurController extends AbstractController
{
    #[Route('{_locale}/admin/dresseurs', name: 'app_admin_dresseurs_index', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
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
    public function new(Request $request, DresseurRepository $repository): Response
    {
        $dresseur = new Dresseur();
        $form = $this->createForm(DresseurType::class, $dresseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dresseur = $form->getData();
            // dd($dresseur);
            $repository->add($dresseur);

            $this->addFlash('success', 'Le dresseur a bien été ajouté !');

            return $this->redirectToRoute('app_admin_dresseurs_index');
        }

        return $this->render('admin/dresseur/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('{_locale}/admin/dresseurs/{id}/edit', name: 'app_admin_dresseurs_edit', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    public function edit(Request $request, DresseurRepository $repository): Response
    {
        $dresseur = $repository->find($request->get('id'));
        $form = $this->createForm(DresseurType::class, $dresseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dresseur = $form->getData();
            $repository->update($dresseur);

            $this->addFlash('success', 'Le dresseur #'.$dresseur->getId().' ('.$dresseur->getNom().') a bien été modifié !');

            return $this->redirectToRoute('app_admin_dresseurs_index');
        }

        return $this->render('admin/dresseur/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('{_locale}/admin/dresseurs/{id}/delete', name: 'app_admin_dresseurs_delete', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    public function delete(Request $request, DresseurRepository $repository): Response
    {
        $dresseur = $repository->find($request->get('id'));
        $oldId = $dresseur->getId();
        $repository->remove($dresseur);

        $this->addFlash('success', 'Le dresseur #'.$oldId.' ('.$dresseur->getNom().') a bien été supprimé !');

        return $this->redirectToRoute('app_admin_dresseurs_index');
    }
}
