<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\AttaqueRepository;
use App\Repository\PokemonRepository;
use App\Repository\TypeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\{IsGranted};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeController extends AbstractController
{
    /**
     * @Route("/types", name="app_types_index")
     * Retourne la liste des types dans le template types/index.html.twig
     */
    #[Route('{_locale}/admin/types', name: 'app_admin_types_index', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(TypeRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $types = $paginator->paginate(
            $repository->findAll(), // Requête contenant les données à paginer
            $request->query->getInt('page', 1), // Numéro de la page en cours, 1 par défaut
            5 // Limite par page
        );

        // Charge la liste des types et les affiche dans le template
        return $this->render('admin/type/index.html.twig', [
            'types' => $types,
        ]);
    }

    /**
     * Cette méthode permet d'ajouter un nouveau type et de l'enregistrer en base de données.
     * Elle retourne également le formulaire de création d'un type dans le template types/new.html.twig.
     */
    #[Route('{_locale}/admin/types/new', name: 'app_admin_types_new', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_ADMIN')]
    public function nouveau(Request $request, TypeRepository $repository): Response
    {
        $type = new Type();
        $form = $this->createForm(TypeType::class, $type);
        $form = $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et si les données sont valides
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère le libellé transmis dans le formulaire
            $libelle = $form->get('libelle')->getData();

            // Vérifie si le libellé ne dépasse pas 25 caractères.
            if (strlen($libelle) > 25) {
                $this->addFlash('error', 'Le libellé ne doit pas dépasser 25 caractères.');

                return $this->redirectToRoute('app_admin_types_new');
            }
            $type->setLibelle($libelle);

            // Récupère l'image transmise dans le formulaire
            $imageFile = $form->get('image')->getData();

            // Vérifie si le nom de l'image n'existe pas dans public/images/types
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

                // Vérifie si le nom de l'image + l'extension (.png) ne dépasse pas 50 caractères.
                if (strlen($originalFilename) > 45) {
                    $this->addFlash('error', 'Le nom de l\'image ne doit pas dépasser 45 caractères.');

                    return $this->redirectToRoute('app_admin_types_new');
                }

                // vérifie si le nom de l'image existe déjà
                if (in_array($originalFilename, $this->recupereNomsImagesTypes())) {
                    $this->addFlash('error', 'Ce nom d\'image existe déjà. Veuillez en choisir un autre.');

                    return $this->redirectToRoute('app_admin_types_new');
                }

                // Vérifie si l'image est bien au format .png.
                if ('png' != $imageFile->guessExtension()) {
                    $this->addFlash('error', 'Le format de l\'image doit être .png.');

                    return $this->redirectToRoute('app_admin_types_new');
                }

                // Vérifie si l'image ne dépasse pas 50Ko.
                if ($imageFile->getSize() > 50000) {
                    $this->addFlash('error', 'L\'image ne doit pas dépasser 50Ko.');

                    return $this->redirectToRoute('app_admin_types_new');
                }
                // Nécessaire pour éviter les problèmes d'encodage
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', strtolower($type->getLibelle()));
                $newFilename = $safeFilename.'.'.$imageFile->guessExtension();
                // Déplace l'image dans le répertoire public/images/types
                $imageFile->move(
                    $this->getParameter('types_images_directory'),
                    $newFilename
                );
                // Met à jour la propriété image avec le nom de l'image
                $type->setImage($newFilename);
            }

            // Sauvegarde le type en base de données et redirige vers la liste des types
            $repository->add($type);
            $this->addFlash('success', 'Le type a été ajouté.');

            return $this->redirectToRoute('app_admin_types_index');
        } else {
            return $this->render(
                'admin/type/new.html.twig',
                [
                    'form' => $form->createView(),
                ]
            );
        }
    }

    private function recupereNomsImagesTypes()
    {
        // Récupère le nom des images dans le répertoire public/images/types
        $images = scandir($this->getParameter('types_images_directory'));
        // Supprime les 2 premiers éléments du tableau (. et ..)
        unset($images[0], $images[1]);

        return $images;
    }

    /**
     * Cette méthode permet de modifier un type et de l'enregistrer en base de données.
     * Elle retourne également le formulaire de modification d'un type dans le template types/edit.html.twig.
     */
    #[Route('{_locale}/admin/types/{id}/edit', name: 'app_admin_types_edit', methods: ['GET', 'POST'], requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, TypeRepository $repository): Response
    {
        $type = $repository->findOneBy(['id' => $request->get('id')]);
        // Si c'est le type "Incconu" alors on ne peut pas le modifier
        if ('Inconnu' == $type->getLibelle()) {
            $this->addFlash('error', 'Le type "Inconnu" ne peut pas être modifié.');

            return $this->redirectToRoute('app_admin_types_index');
        }
        $form = $this->createForm(TypeType::class, $type);
        $form = $form->handleRequest($request);
        $oldImage = $type->getImage();

        // Vérifie si le formulaire a été soumis et si les données sont valides
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère le libellé transmis dans le formulaire
            $libelle = $form->get('libelle')->getData();

            // Vérifie si le libellé ne dépasse pas 25 caractères.
            if (strlen($libelle) > 25) {
                $this->addFlash('error', 'Le libellé ne doit pas dépasser 25 caractères.');

                return $this->redirectToRoute('app_admin_types_edit', ['id' => $type->getId()]);
            }
            $type->setLibelle($libelle);

            // Récupère l'image transmise dans le formulaire
            $imageFile = $form->get('image')->getData();
            // Vérifie si le nom de l'image n'existe pas dans public/images/types
            if ($oldImage != $imageFile->getClientOriginalName()) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

                // Vérifie si le nom de l'image + l'extension (.png) ne dépasse pas 50 caractères.
                if (strlen($originalFilename) > 45) {
                    $this->addFlash('error', 'Le nom de l\'image ne doit pas dépasser 45 caractères.');

                    return $this->redirectToRoute('app_admin_types_edit', ['id' => $type->getId()]);
                }

                // vérifie si le nom de l'image existe déjà
                if (in_array($originalFilename, $this->recupereNomsImagesTypes())) {
                    $this->addFlash('error', 'Ce nom d\'image existe déjà. Veuillez en choisir un autre.');

                    return $this->redirectToRoute('app_admin_types_edit', ['id' => $type->getId()]);
                }

                // Vérifie si l'image est bien au format .png.
                if ('png' != $imageFile->guessExtension()) {
                    $this->addFlash('error', 'Le format de l\'image doit être .png.');

                    return $this->redirectToRoute('app_admin_types_edit', ['id' => $type->getId()]);
                }

                // Vérifie si l'image ne dépasse pas 50Ko.
                if ($imageFile->getSize() > 50000) {
                    $this->addFlash('error', 'L\'image ne doit pas dépasser 50Ko.');

                    return $this->redirectToRoute('app_admin_types_edit', ['id' => $type->getId()]);
                }
                // Supprime l'ancienne image
                unlink($this->getParameter('types_images_directory').'/'.$oldImage);
                // Nécessaire pour éviter les problèmes d'encodage
                // Le nom de l'image est le libellé du type en minuscule
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $type->getLibelle());
                $newFilename = $safeFilename.'.'.$imageFile->guessExtension();
                // Déplace l'image dans le répertoire public/images/types
                $imageFile->move(
                    $this->getParameter('types_images_directory'),
                    $newFilename
                );
                // Met à jour la propriété image avec le nom de l'image
                $type->setImage($newFilename);
            }

            // Sauvegarde le type en base de données et redirige vers la liste des types
            $repository->update($type);
            $this->addFlash('success', 'Le type #'.$type->getId().' a été modifié avec succès !');

            return $this->redirectToRoute('app_admin_types_index');
        } else {
            return $this->render('admin/type/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }

    /**
     * Cette méthode permet de supprimer un type.
     */
    #[Route('{_locale}/admin/types/{id}/delete', name: 'app_admin_types_delete', methods: ['GET', 'POST'], requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, TypeRepository $typeRepository, PokemonRepository $pokemonRepository, AttaqueRepository $attaqueRepository): Response
    {
        $type = $typeRepository->findOneBy(['id' => $request->get('id')]);
        if (!$type) {
            $this->addFlash('error', 'Le type n\'existe pas.');

            return $this->redirectToRoute('app_admin_types_index');
        }
        // Si c'est le type "Incconu" alors on ne peut pas le supprimer
        if ('Inconnu' == $type->getLibelle()) {
            $this->addFlash('error', 'Le type "Inconnu" ne peut pas être supprimé.');

            return $this->redirectToRoute('app_admin_types_index');
        }

        // Récupère tous les pokémons associés au type et les insère dans types
        foreach ($type->getPokemons() as $pokemon) {
            // Si le pokémon possède un type secondaire alors on le supprime sinon on met à 'TYPE0'
            if ($pokemon->getTypes()->count() > 1) {
                $pokemon->removeType($type);
            } else {
                $pokemon->addType($typeRepository->findOneBy(['libelle' => 'Inconnu']));
                // Mettre à jour le type du pokémon dans la table pokemon
                $pokemonRepository->update($pokemon);
            }
        }

        // Change le type des attaques liése au type par 'Inconnu'
        $inconnu = $typeRepository->findOneBy(['libelle' => 'Inconnu']);
        foreach ($type->getAttaques() as $attaque) {
            $attaque->setType($inconnu);
            // Mettre à jour le type de l'attaque dans la table attaque
            $attaqueRepository->update($attaque);
        }

        // Supprime l'image du type
        unlink($this->getParameter('types_images_directory').'/'.$type->getImage());

        // Supprime le type en base de données et redirige vers la liste des types
        $oldId = $type->getId();
        $typeRepository->remove($type);
        $this->addFlash('success', 'Le type #'.$oldId.' a été supprimé avec succès !');

        return $this->redirectToRoute('app_admin_types_index');
    }

    // PARTIE PUBIQUE

    #[Route('{_locale}/types', name: 'app_home_types_index', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'fr'])]
    public function liste(TypeRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $types = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('public/types/index.html.twig', [
            'types' => $types,
        ]);
    }
}
