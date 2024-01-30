<?php

namespace App\EntityListener;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\TokenValidation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Enums\StatusEnum as Status;
use App\Repository\TokenValidationRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Utils\TextUtils;
use App\Service\MailService;


class UserListener
{
    private UserPasswordHasherInterface $hasher;
    private TokenValidationRepository $repositoryTokenValidation;
    private UrlGeneratorInterface $urlGenerator;
    private MailService $mailService;

    public function __construct(UserPasswordHasherInterface $hasher, TokenValidationRepository $repositoryTokenValidation, UrlGeneratorInterface $urlGenerator, MailService $mailService)
    {
        $this->hasher = $hasher;
        $this->repositoryTokenValidation = $repositoryTokenValidation;
        $this->urlGenerator = $urlGenerator;
        $this->mailService = $mailService;
    }

    public function prePersist(User $user): void
    {
        $this->hashPassword($user);
    }

    public function postPersist(User $user): void
    {
        // Vérifie si l'utilisateur est en attente de validation
        if($user->getStatus() == Status::EN_ATTENTE_DE_VALIDATION) {
            // Créer un token de validation de compte
            $tokenValidation = new TokenValidation();
            $tokenValidation->setUserId($user->getId());
            // Générer un token
            $tokenValidation->setToken(bin2hex(random_bytes(32)));
            // Enregistrer le token en base de données
            $this->repositoryTokenValidation->add($tokenValidation);
            //Envoyer un email de confirmation d'inscription avec le token
            $this->sendMail($user, $tokenValidation);
        }
    }

    public function preUpdate(User $user): void
    {
        $this->hashPassword($user);
    }

    /**
     * Hash le mot de passe basé sur plainPassword avant l'insertion en base de données
     *
     * @param User $user
     * @return void
     */
    public function hashPassword(User $user): void
    {
        if($user->getPlainPassword() === null) {
            return;
        }
        $user->setPassword(
            $this->hasher->hashPassword(
                $user, 
                $user->getPlainPassword()
            )
        );
        $user->setPlainPassword(null);
    }

    private function sendMail(
        User $user, 
        TokenValidation $tokenValidation
        ): void 
    {
        // Créer le lien pour valider le compte 
        $url = $this->urlGenerator->generate(
            'app_home_validation', 
            ['token' => $tokenValidation->getToken()], 
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        // Envoyer un email de confirmation d'inscription avec le token
        $this->mailService->sendEmail(
            $user->getEmail(),
            'verification@pokemonsymfony.fr',
            'Confirmation d\'inscription sur Pokémons Symfony',
            'public/emails/verification.html.twig',
            [
                'bonjourOuBonsoir' => TextUtils::bonjourOuBonsoir(),
                'nomUtilisateur' => $user->getNomUtilisateur(),
                'url' => $url
            ],
        );
    }
}
