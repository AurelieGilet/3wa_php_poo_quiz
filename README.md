# Dev Quiz

Projet réalisé pour la soutenance du titre "Développeur Web Fullstack" à la 3WAcademy

## Concept

Ce projet est un site qui propose des quiz sur certains langages de programmation afin de tester ses connaissances.

Chaque utilisateur doit créer un compte afin de pouvoir accéder à la liste des langages disponibles.

Après en avoir sélectionné un, il se verra proposer 10 questions, qui ont chacune entre 2 et 4 réponses possibles, mais une seule correct.

A l'issue de la parties, un tableau récapitulatif lui donnera ses résultats (le nombre de bonnes réponses et son score) et il aura la possibilité d'acceder à la liste de ses scores ou refaire une partie.

Dans son espace personnel, il pourra modifier ses informations (pseudo, email, mot de passe) ou supprimer son compte.

Il pourra également voir l'historique de ses scores pour chaque langage.

Du côté back office du site, l'administrateur aura accès à un tableau de commande qui permet de gérer les utilisateurs, les catégories de langages, les questions et les réponses des quiz.

## Techno

- PHP POO
- SQL
- HTML
- CSS (SASS)
- JavaScript (+ Ajax)
- Composer

Souhaitant développer un projet en pur PHP, il me semblait illogique de devoir installer **NPM** uniquement pour compiler le SCSS et le JS.

J'ai contourné ce problème en ayant recours à [**scssphp**](https://scssphp.github.io/scssphp/) pour compiler le scss et en créant un script Composer qui permette de build le css rapidement avec la commande 
```
composer build
```

Pour le JavaScript, j'ai utilisé le [Symfony Console Component](https://symfony.com/doc/current/components/console.html) pour créer une commande qui permette d'unifier et minimiser tous les script JS avec la commande 
```
bin/console build:js
```

## Installation du projet

Après avoir téléchargé le dossier, un simple **_composer install_** permettra d'installer les packages nécessaires (il y en a peu).

Concernant la base de données, il vous faudra un serveur local type Xampp, Wamp, Mamp.

Un fichier **dev_quiz.sql** est disponible sur le repository avec un jeu de données qui permet de faire fonctionner le site.
Il suffit de créer une base de donnée **dev_quiz** et d'y importer ce fichier.

Il vous suffira ensuite de changer les paramètres nécessaires éventuels dans le fichier app/database/DBConstants.php pour vous connecter à votre db locale, selon le serveur que vous utilisez (user et password).

Le dossier à servir dans Apache est le dossier parent "dev_quiz_app" et non le dossier public.
Une rewrite rule a été prévue dans le htaccess pour rediriger vers index.php situé dans le dossier public.

2 utilisateurs sont déjà enregistrés dans le jeu de données, que vous pouvez connecter pour accéder aux différentes parties du site:
- un administrateur : admin@mail.com / Password1!
- un utilisateur : user@mail.com / Password1!