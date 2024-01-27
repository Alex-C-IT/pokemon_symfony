<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TypeRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Type;
use App\Form\TypeType;

class TypeController extends AbstractController
{
    /**
     * @Route("/types", name="app_types_index")
     * Retourne la liste des types dans le template types/index.html.twig
     * @param TypeRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/types', name: 'app_admin_types_index')]
    public function index(TypeRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $types = $paginator->paginate(
            $repository->findAll(), // Requête contenant les données à paginer
            $request->query->getInt('page', 1), // Numéro de la page en cours, 1 par défaut
            5 // Limite par page
        );

        // Charge la liste des types et les affiche dans le template
        return $this->render('admin/type/index.html.twig', [
            'types' => $types
        ]);
    }

    #[Route('/admin/types/new', name: 'app_admin_types_new')]
    public function nouveau(Request $request, TypeRepository $repository): Response
    {
        $type = new Type();
        $form = $this->createForm(TypeType::class, $type);
        $form = $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et si les données sont valides
        if($form->isSubmitted() && $form->isValid()) {
            // Récupère l'id transmis dans le formulaire
            $id = $form->get('id')->getData();

            // Vérifie si l'id ne dépasse pas 10 caractères.
            if(strlen($id) > 10){
                $this->addFlash('error', 'L\'id ne doit pas dépasser 10 caractères.');
                return $this->redirectToRoute('app_admin_types_new');
            }

            // Vérifie si l'id existe déjà
            if($repository->find($id)){
                $this->addFlash('error', 'Cet id existe déjà. Veuillez en choisir un autre.');
                return $this->redirectToRoute('app_admin_types_new');
            }

            // Met à jour la propriété id avec l'id
            $type->setId($id);

            // Récupère le libellé transmis dans le formulaire
            $libelle = $form->get('libelle')->getData();
            
            // Vérifie si le libellé ne dépasse pas 25 caractères.
            if(strlen($libelle) > 25){
                $this->addFlash('error', 'Le libellé ne doit pas dépasser 25 caractères.');
                return $this->redirectToRoute('app_admin_types_new');
            }
            $type->setLibelle($libelle);            
            
            // Récupère l'image transmise dans le formulaire
            $imageFile = $form->get('image')->getData();
            
            // Vérifie si le nom de l'image n'existe pas dans public/images/types
            if($imageFile) {
                
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                
                // Vérifie si le nom de l'image + l'extension (.png) ne dépasse pas 50 caractères.
                if(strlen($originalFilename) > 45){
                    $this->addFlash('error', 'Le nom de l\'image ne doit pas dépasser 45 caractères.');
                    return $this->redirectToRoute('app_admin_types_new');
                }

                // vérifie si le nom de l'image existe déjà
                if(in_array($originalFilename, $this->recupereNomsImagesTypes())){
                    $this->addFlash('error', 'Ce nom d\'image existe déjà. Veuillez en choisir un autre.');
                    return $this->redirectToRoute('app_admin_types_new');
                }

                // Vérifie si l'image est bien au format .png.
                if($imageFile->guessExtension() != 'png'){
                    $this->addFlash('error', 'Le format de l\'image doit être .png.');
                    return $this->redirectToRoute('app_admin_types_new');
                }

                // Vérifie si l'image ne dépasse pas 50Ko.
                if($imageFile->getSize() > 50000){
                    $this->addFlash('error', 'L\'image ne doit pas dépasser 50Ko.');
                    return $this->redirectToRoute('app_admin_types_new');
                }
                // Nécessaire pour éviter les problèmes d'encodage
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
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
        }
        else
        {
            return $this->render('admin/type/new.html.twig', [
                    'form' => $form->createView()
                ]
            );
        }
    }

    private function recupereNomsImagesTypes() {
        // Récupère le nom des images dans le répertoire public/images/types
        $images = scandir($this->getParameter('types_images_directory'));
        // Supprime les 2 premiers éléments du tableau (. et ..)
        unset($images[0], $images[1]);
        return $images;
    }


}