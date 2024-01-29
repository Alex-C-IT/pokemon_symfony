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
use App\Entity\TokenValidation;
use App\Enums\StatusEnum as Status;
use Symfony\Component\Security\Core\Security;
use App\Repository\{UserRepository, TokenValidationRepository};


class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'app_home_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        /*
        if ($request->isMethod('POST')) {
            $user = $userRepository->findOneBy([
                'email' => $request->request->get('_username')
            ]);
            if($user !== null && $user->getStatus() === Status::EN_ATTENTE_DE_VALIDATION) {
                $token = $tokenValidationRepository->findOneBy([
                    'userId' => $user->getId()
                ]);
                if($token !== null) {
                    $this->addFlash(
                        "warning", 
                        "Votre compte n'est pas encore activé. Veuillez valider votre compte avant le " . $token->dateAvantExpirationToken() . " (". $token->nombreDeJoursAvantExpirationToken() . " jours restants)."
                    );
                    return $this->redirectToRoute("app_home_login");
                }
            }
        }
        */
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

    #[Route('/validation/{token}', name: 'app_home_validation', methods: ['GET'])]
    public function validation(string $token, EntityManagerInterface $manager): Response
    {
        // Récupérer le token en base de données
        $tokenValidation = $manager->getRepository(TokenValidation::class)->findOneBy([
            'token' => $token
        ]);

        // Si le token n'existe pas, on affiche une erreur
        if($tokenValidation === null) {
            $this->addFlash(
                "danger", 
                "Le token n'existe pas."
            );
            return $this->redirectToRoute("app_home_login");
        }

        // Si le token est expiré, on affiche une erreur
        if($tokenValidation->getDateHeureExpiration() < new \DateTimeImmutable()) {
            $this->addFlash(
                "danger", 
                "Le token est expiré. Veuillez vous réinscrire."
            );
            return $this->redirectToRoute("app_home_login");
        }

        // Si le token est valide, on active le compte
        $user = $manager->getRepository(User::class)->find($tokenValidation->getUserId());
        $user->setStatus(Status::ACTIF);
        // Mise à jour en base de données
        $manager->persist($user);
        $manager->flush();

        // On supprime le token
        $manager->remove($tokenValidation);
        $manager->flush();

        // On affiche un message de succès
        $this->addFlash(
            "success", 
            "Votre compte a bien été activé. Vous pouvez vous connecter."
        );

        // On redirige vers la page de connexion
        return $this->redirectToRoute("app_home_login");
    }
}
