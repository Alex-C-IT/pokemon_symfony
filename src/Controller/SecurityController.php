<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use App\Entity\TokenValidation;
use App\Enums\StatusEnum as Status;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\{UserRepository, TokenValidationRepository};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
// Importe Security de SecurityBundle
use Symfony\Bundle\SecurityBundle\Security; 
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;


class SecurityController extends AbstractController implements UserCheckerInterface
{
    private TokenValidationRepository $tokenValidationRepository;

    public function __construct(TokenValidationRepository $tokenValidationRepository)
    {
        $this->tokenValidationRepository = $tokenValidationRepository;
    }

    #[Route('/connexion', name: 'app_home_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        return $this->render('public/security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    public function checkPreAuth(UserInterface $user): void
    {
        // Contrôle si l'utilisateur est bien une instance de User
        if (!$user instanceof User) {
            $this->addFlash(
                "danger", 
                "Une erreur interne est survenue. Veuillez vous reconnecter."
            );
            throw new \Exception("Une erreur interne est survenue. Veuillez vous reconnecter.");
        }
        // Contrôle si le compte est activé
        if($user !== null && $user->getStatus() === Status::BANNI) {
            throw new CustomUserMessageAccountStatusException('Votre compte a été banni. Veuillez contacter l\'administrateur.');
        }

        // Contrôle si le compte est activé
        if($user !== null && $user->getStatus() === Status::EN_ATTENTE_DE_VALIDATION) {
            $token = $this->tokenValidationRepository->findOneBy([
                'userId' => $user->getId()
            ]);
            if($token !== null) {
                throw new CustomUserMessageAccountStatusException('Votre compte n\'est pas encore activé. Veuillez valider votre compte avant le ' . $token->dateAvantExpirationToken() . ' ('. $token->nombreDeJoursAvantExpirationToken() . ' jours restants). Consultez vos mails.');
            }
            throw new CustomUserMessageAccountStatusException('Votre compte n\'est pas encore activé. Veuillez valider votre compte. Consultez vos mails.');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {

    }

    #[Route('/connexion/check', name: 'app_home_login_check', methods: ['GET', 'POST'])]
    public function loginCheckVerification(Request $request, UserRepository $userRepository, TokenValidationRepository $tokenValidationRepository): Response
    {   
        // Si le compte est activé, on redirige vers la page d'accueil
        return $this->redirectToRoute("app_home_index");
    }
    
    #[Route('/deconnexion', name: 'app_home_logout', methods: ['GET'])]
    public function logout(Request $request): Response
    {
        return $this->render('public/security/login.html.twig');
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
