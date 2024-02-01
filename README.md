# Pokémon Symfony <img src="https://i.goopics.net/l625ud.png" alt="Pikachu" style="height: 65px;" />

> [!NOTE]
> Ce projet a été réalisé dans le cadre du cours de "Programmation avancé" au sein de la filière informatique de l'IUT de Metz - Université de Lorraine.

## Pré-requis

Pour faire fonctionner ce projet, il est nécessaire d'avoir :
- **IDE** : Visual Studio Code [Télécharger](https://code.visualstudio.com/download) ou JetBrains PhpStorm [Télécharger](https://www.jetbrains.com/fr-fr/phpstorm/download/#section=windows)
- **PHP** : Version 8+ - [Télécharger](https://www.php.net/downloads.phpvisual )
- **SGBD** : MySQL 8.0 - [Télécharger](https://dev.mysql.com/downloads/mysql/)
- **Gestionnaire de dépendances** : Composer - [Télécharger](https://getcomposer.org/download/)

Dans le répertoire de votre version de PHP, ouvrez le fichier `php.ini` et activez les extensions suivantes : 
- `extension=fileinfo`; `extension=curl`; `extension=intl`; `extension=mbstring`; `extension=mysqli`; `extension=pdo_mysql`; `extension=openssl`

Récupérer le projet via cette commande :<br> 
```git clone https://github.com/Alex-C-IT/pokemon_symfony.git```

## Initialisation du projet 
### Installation des dépendances
Ouvrez le projet avec l'éditeur de votre choix et à partir du terminal, faites :<br>
`composer install`

### Configuration du service de test d'email.
> [!IMPORTANT]
> Le site utilise un service de mail pour envoyer un lien de vérification de compte avec token lors de l'inscription d'un nouvel utilisateur. Il est donc fortement recommandé de suivre cette partie.

Suivez simplement ces étapes pour que tout se passe bien :

1. Rendez-vous sur [Mailtrap](https://mailtrap.io/) et créez vous un compte.
2. Connectez-vous.
3. Accèdez à votre boite mail de test "My inbox" (`Email Testing > Inboxes > My Inbox`).
4. Allez dans l'onglet `SMPT Settings`.
5. Séléctionnez dans `Integrations` : `Symfony 5+`
6. Copiez le texte qui vous est founi (`MAILER_DSN=smtp://**********:************@sandbox.smtp.mailtrap.io:2525`).
7. Créez le fichier `.env.local` à la racine du projet.
8. Collez la variable d'environnement dans le fichier. Sauvegardez.
9. **C'est fini !**
   
> [!NOTE]
> Vous recevrez dans votre "My Inbox" tous les emails envoyés par le site.<br>
> **Si vous souhaitez utiliser votre propre serveur SMTP, alors changer la variable d'environnement en fonction de votre configuration**.

### Préparation de la base de données

Ajoutez dans le fichier `.env.local` (créé dans la partie précédente) cette variable d'environnement : <br>
`DATABASE_URL=mysql://[USER]:[PASSWORD]@127.0.0.1:[PORT]/pokemon_symfony_db` <br>
Sauvegardez.
> [!NOTE]
> Adaptez `[USER]`, `[PASSWORD]`, `[PORT]` en fonction de votre configuration. Enlevez bien sur les crochets.

Via le terminal de votre IDE, faites :

- `php bin/console doctrine:database:create` (Création de la base de données)
- `php bin/console doctrine:migrations:diff` (Préparation du script SQL par Symfony)
- `php bin/console doctrine:migrations:migrate` (Création des tables)
- `php bin/console doctrine:fixtures:load` (Chargement des données via les fixtures du projet)

<br>

**La base de données est maintenant opérationnelle**

### Lancement du serveur

Ouvrez un nouveau terminal dans votre IDE.
Dans celui-ci faites : <br>
`symfony server:start`
> [!TIP]
>  Symfony utilise par défaut le port `8000`. Une fois le serveur lancé, vous pourrez accéder au site via cette URL : [http://127.0.0.1:8000](http://127.0.0.1:8000)

Si tout s'est bien passé, vous devriez accéder à cette page : 

[![Image](https://i.goopics.net/lg14v1.png)](https://goopics.net/i/lg14v1)

Si c'est le cas, **l'initialisation du projet est terminée !**

## Accès aux différents comptes 
1. `admin@pokemonsymfony.fr` & MDP `admin` (Status : `ACTIF`)
2. `user@pokemonsymfony.fr` & MDP `user` (Status : `EN_ATTENTE_DE_VERIFICATION`<br>
    Voir boite Mailtrap pour confirmer le compte (ou dans l'espace admin - utilisateur : bannir puis débannir)
4. `user@pokemonsymfony.fr` & MDP `user2` (Status : `BANNI`)

## Accessibilité aux pages du site

### Utilisateur annonyme
Un utilisateur annonyme, un visiteur, a accès aux pages suivantes : 
- Page d'accueil;
- Page de connexion;
- Page d'inscription;
- Page listant les pokémons;
- Page listant les types de pokémons;
- Page listant les attaques existantes;
- Page listant les objets existants.
  
### Utilisateur inscrit et connecté
Un utilisateur inscrit et connecté avec un **rôle utilisateur** a accès aux pages suivantes : 
- Toutes les pages visitables par un utilisateur annonyme sauf les pages de connexion et d'inscription.
- Page "Mes dresseurs";
- Page "Mon profil";
- Déconnextion.

Un utilisateur inscrit et connecté avec un **rôle administrateur** a accès aux pages suivantes : 
- Toutes les pages visitables par un utilisateur inscrit et connecté avec un rôle utilisateur;
- Page "Tableau de bord";
- Pages de gestion des pokémons : liste des pokémons, ajout/modification/suppression d'un pokémon;
- Pages de gestion des attaques : liste des attaques, ajout/modification/suppression d'une attaque;
- Pages de gestion des objets : liste des objets, ajout/modification/suppression d'un objets;
- Pages de gestion des générations : liste des générations, ajout/modification/suppression d'une générations;
- Pages de gestion des dresseurs : liste des dresseurs, ajout/modification/suppression d'un dresseurs;
- Pages de gestion des utilisateurs : liste des utilisateurs, ajout/modification/suppression d'un utilisateurs.

## Barème de notation

[![Image](https://i.goopics.net/y9s1n6.png)](https://goopics.net/i/y9s1n6)

### Les entités

Le projet implémente **9 entités** : 
- 1 entité principale : `POKEMON`
- 7 entités enfants : `USER`,`DRESSEURS`, `TYPE`, `ATTAQUE`, `CONSOMMABLE`, `GENERATION`, `STATS`
- 1 entités isolée : `TOKENVALIDATION`

**Relations entre les entités :**
- `USER` a une relation *OneToMany* avec `DRESSEUR`
- `DRESSEUR` a une relation *ManyToOne* avec `USER`
- `DRESSEUR` a une relation *ManyToMany* avec `POKEMON`
- `POKEMON` a une relation *ManyToMany* avec `DRESSEUR`
- `POKEMON` a une relation *ManyToOne* avec `GENERATION`
- `POKEMON` a une relation *ManyToMany* avec `TYPE`
- `POKEMON` a une relation *OneToOne* avec `STATS`
- `POKEMON` a une relation *ManyToOne* avec `CONSOMMABLE`
- `POKEMON` a une relation *ManyToMany* avec `ATTAQUE`
- `TYPE` a une relation *ManyToMany* avec `POKEMON`
- `TYPE` a une relation *OneToMany* avec `ATTAQUE`
- `ATTAQUE` a une relation *ManyToOne* avec `TYPE`
- `ATTAQUE` a une relation *ManyToMany* avec `POKEMON`
- `CONSOMMABLE` a une relation *OneToMany* avec `POKEMON`
- `GENERATION` a une relation *OneToMany* avec `POKEMON`
- `TYPE` a une relation *ManyToMany* avec `POKEMON`
- `TYPE` a une relation *OneToMany* avec `ATTAQUE`

### Les fixtures

Les différentes fixtures ont été implémentées pour toutes les entités ayant des relations entre elles.<br>
Seule l'entité isolée `TOKENVALIDATION`, n'a pas de fixtures. Elle a cependant un enregistrement en base de données au moment du chargement des fixtures par l'intermédiaire du système lorsque celui-ci ajoute un nouvel `USER` ayant un "status" non modifié.

### Système de traduction 

Un système de traduction a été implémenté pour les langues suivante : `FR` et `EN`.<br><br>
[![Image](https://i.goopics.net/jusfiu.png)](https://goopics.net/i/jusfiu)
[![Image](https://i.goopics.net/c7hd7a.png)](https://goopics.net/i/c7hd7a)

### Les formulaires et CRUD

Le projet implémente les différents formulaires et CRUD (Creare, Read, Update, delete) suivants : <br>
- Formulaire de connexion `PUBLIC`
- Formulaire d'inscription `PUBLIC`
- Lister les pokémons `PUBLIC`
- Lister les attaques `PUBLIC`
- Lister les objets `PUBLIC`
- Lister les types `PUBLIC`
- Lister la liste de ses dresseurs `UTILISATEUR`
- Ajout/modification/suppression d'un dresseur `UTILISATEUR`
- Modification des informations de l'utilisateur `UTILISATEUR`
- Lister la liste de tous les pokémons `ADMIN`
- Ajout/modification/suppression d'un pokémon `ADMIN`
- Lister la liste de toutes les attaques `ADMIN`
- Ajout/modification/suppression d'une attaque `ADMIN`
- Lister la liste de tous les types `ADMIN`
- Ajout/modification/suppression d'un type `ADMIN`
- Lister la liste de tous les consommables `ADMIN`
- Ajout/modification/suppression d'un consommable `ADMIN`
- Lister la liste de tous les dresseurs `ADMIN`
- Ajout/modification/suppression d'un dresseur `ADMIN`
- Lister la liste de tous les utilisateurs `ADMIN`
- Ajout/modification/suppression d'un utilisateur `ADMIN`

### Système de connexion

Un système de connexion a été implémenté.

### Système d'inscription

Un système d'inscription a été implémenté.
> [!NOTE]
> J'ai implémenté moi-même un système de token pour vérifier les comptes qui sont créés. Lorsqu'un utlisateur s'inscrit, un token est généré et stocké en base de données avec une date limite (+30 jours). Le lien de vérification est envoyé par mail avec le token. L'utilisateur ne pourra pas se connecter tant qu'il n'aura pas cliqué sur le lien et vérifié son compte.
> - Tentative de connexion<br>
> [![Image](https://i.goopics.net/ncuefw.png)](https://goopics.net/i/ncuefw)
> - Email<br>
> [![Image](https://i.goopics.net/3lqjgf.png)](https://goopics.net/i/3lqjgf)
> - Token<br>
> [![Image](https://i.goopics.net/boo5l8.png)](https://goopics.net/i/boo5l8)

### Tableau de bord

La page du tableau de bord est implémentée.

### Création d'un EventCustom

Le projet implémente un EventCustom nommé `UserListener`. Vous le retrouver dans `src/EntityListener/`.<br><br>
L'objectif de cet `UserListener` est d'écouter l'entité `USER`. <br><br>
Lorsque d'un persist sur l'entité `ÙSER`, les méthodes `prePersist()` et `postPersist()` vont s'exécuter.
- Le rôle de `prePersist()` est de crypter le mot de passe de l'utilisateur si nécessaire avant que l'utilisateur soit ajouté en base de données.
- Le rôle de `postPersist()` est d'envoyé un mail si le status de l'utilisateur est `EN_ATTENTE_DE_VALIDATION`.

### Convention de code 

Le projet respecte normalement la convention de Symfony. <br>
Un contrôle a également été effectué grâce à la dépendance nommée `php-cs-fixer`.

>[!TIP]
> Si vous souhaitez faire un contrôle de votre code avec cet outil et lui permettre de mettre en forme ce dernier en fonction des standards Symfony, vous pouvez à l'aide du terminal écrire la commande suivante :<br>
> `vendor/bin/php-cs-fixer fix src`

### Le status (Enum) 

Un enum `Status` a été implémenté dans ce projet. Celui-ci est lié à l'utilisateur. <br>
3 valurs possibles sont implémentées et utilisées :
- `EN_ATTENTE_DE_VALIDATION`, `ACTIF` et `BANNI`<br><br>

Le status de l'utilisateur est principalement utilisé : 
- Dans la partie "Utilisateurs" de l'administration. Celui-ci est affiché.
- Dans cette même partie, pour bannir ou débannir l'utilisateur.
- Lors de la connexion. L'utilisateur pourra se connecter que s'il a le status `ACTIF`. Un refus et un message différent est notifié à l'utilisateur en fonction des autres status.
- Lors de la vérification de compte. Après avoir cliqué sur le lien, le status passera de `EN_ATTENTE_DE_VALIDATION` à `ACTIF`.
- Pour contrôler l'envoi d'un mail avec le token de vérification lors de la création d'un compte.

## BILAN

C'était un projet fort sympathique à réaliser ! :)







