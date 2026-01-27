<?php

// Charge l'autoloader Composer (obligatoire pour charger les classes automatiquement)
require dirname(__DIR__) . '/vendor/autoload.php';

use App\Core\App;

// Lance ton application (routing + controllers + affichage)
App::run();

/**
 *
 * index.php est le POINT D’ENTRÉE de ton application
 * ----------------------------------------------------------
 * Quand un utilisateur visite ton site, par exemple :
 *
 *   http://localhost:8000/
 *   http://localhost:8000/contact
 *   http://localhost:8000/user/12
 *
 * Peu importe l’URL, c’est toujours ce fichier user.php
 * qui est exécuté en premier.
 *
 * - On appelle ça un "Front Controller"
 * (un contrôleur principal qui reçoit toutes les requêtes)
 *
 *
 * ----------------------------------------------------------
 * 1) Pourquoi user.php doit rester petit ?
 * ----------------------------------------------------------
 * Parce que son rôle est simple :
 *
 * - charger Composer (autoloader)
 * - démarrer l'application (App::run())
 *
 * On évite de mettre toute la logique ici,
 * sinon le fichier devient énorme et difficile à gérer.
 *
 * Donc user.php reste un fichier "propre" et court.
 *
 *
 * ----------------------------------------------------------
 * 2) C’est quoi l’AUTOLOADER (Composer) ?
 * ----------------------------------------------------------
 * Dans un projet PHP avec plusieurs fichiers, tu vas créer plein de classes :
 *   - App\Core\App
 *   - App\Core\Controller
 *   - App\Controller\HomeController
 *   - App\Controller\ContactController
 *   - etc...
 *
 * Sans autoloader, tu serais obligé de faire plein de require :
 *
 *   require "src/Core/App.php";
 *   require "src/Core/Controller.php";
 *   require "src/Controller/HomeController.php";
 *   ...
 *
 * ❌ Et ça devient vite impossible à gérer !
 *
 * L'autoloader règle ce problème :
 * Grâce à Composer, tes classes sont chargées automatiquement.
 *
 * Exemple :
 *   new \App\Controller\HomeController();
 *
 * Composer va automatiquement chercher le fichier de la classe
 * au bon endroit, sans que tu aies besoin de faire un require à la main.
 *
 *
 * ----------------------------------------------------------
 * 3) Comment Composer sait où sont tes classes ? (PSR-4)
 * ----------------------------------------------------------
 * Dans ton fichier composer.json, tu as une règle appelée PSR-4 :
 *
 *   "autoload": {
 *     "psr-4": {
 *       "App\\": "src/"
 *     }
 *   }
 *
 * Ça veut dire :
 * - Toutes les classes qui commencent par "App\"
 * se trouvent dans le dossier "src/"
 *
 * Exemple :
 *   App\Controller\HomeController
 * sera automatiquement chargé depuis :
 *   src/Controller/HomeController.php
 *
 *
 * ----------------------------------------------------------
 * 4) C’est quoi un namespace en PHP ?
 * ----------------------------------------------------------
 * Un namespace sert à ORGANISER tes classes et éviter les conflits.
 *
 * Imagine que tu crées une classe qui s'appelle "User".
 * Tu peux très vite avoir :
 *   - une classe User dans les Models (données)
 *   - une classe User dans les Controllers (pages)
 *
 * Exemple :
 *   class User {}  (dans src/Model/User.php)
 *   class User {}  (dans src/Controller/User.php)
 *
 * ❌ Problème : PHP ne peut pas avoir deux classes avec le même nom.
 *
 * ✅ Solution : les namespaces !
 *
 *
 * ----------------------------------------------------------
 * 5) Namespace = "adresse complète" d'une classe
 * ----------------------------------------------------------
 * Un namespace est comme une adresse ou un nom de famille.
 *
 * Exemple :
 *   namespace App\Core;
 *   class App {}
 *
 * Le vrai nom complet de la classe devient :
 *   \App\Core\App
 *
 * Donc même si une autre classe s'appelle App ailleurs,
 * elle aura une adresse différente.
 *
 *
 * ----------------------------------------------------------
 * 6) À quoi sert "use" ?
 * ----------------------------------------------------------
 * use sert juste à écrire plus court.
 *
 * Exemple :
 *   use App\Core\App;
 *
 * Grâce à ça tu peux écrire :
 *   App::run();
 *
 * Au lieu d’écrire :
 *   \App\Core\App::run();
 *
 * C’est juste un raccourci pour éviter de répéter le namespace.
 *
 *
 * ----------------------------------------------------------
 * 7) Conclusion (résumé très simple)
 * ----------------------------------------------------------
 * user.php sert à :
 *   - charger l’autoloader
 *   - lancer l’application
 *
 * l’autoloader permet :
 *   - de ne plus faire de require partout
 *   - d’utiliser tes classes automatiquement
 *
 * les namespaces permettent :
 *   - d’organiser ton code (Core, Controller, Model...)
 *   - d’éviter les conflits de noms entre classes
 *
 * App::run() :
 *   - récupère l’URL
 *   - trouve la bonne route
 *   - appelle le bon controller
 *   - affiche la bonne page
 */
