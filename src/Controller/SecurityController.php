<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Form\InscriptionType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'app_home_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('public/security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    #[Route('/deconnexion', name: 'app_home_logout', methods: ['GET'])]
    public function logout(): Response
    {
        return $this->render('public/security/login.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    #[Route('/inscription', name: 'app_home_register', methods: ['GET', 'POST'])]
    public function register(Request $request, EntityManagerInterface $manager): Response
    {
        $user = new User();
        $form = $this->createForm(InscriptionType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            //dd($user);
            $user->addRole("ROLE_USER");
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                "success", 
                "Votre compte a bien été créé. Veuillez valider votre compte via le mail que vous avez reçu."
            );

            return $this->redirectToRoute("app_home_login");
        }


        return $this->render('public/security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
