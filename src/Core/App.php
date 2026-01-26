<?php

namespace App\Core;

final class App
{
    public static function run(): void
    {
        // La méthode HTTP (GET/POST/PUT/DELETE...) : utile pour savoir quelle action exécuter
        $httpMethod = $_SERVER['REQUEST_METHOD'];

        // Le chemin demandé par l'utilisateur, ex: /contact, /user/12 (sans les query params ?page=2)
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

        /**
         * Table de routes :
         * - Clé 1 : méthode HTTP
         * - Clé 2 : chemin
         * - Valeur : [Controller::class, 'method']
         */
        $routes = [
            'GET' => [
                '/' => [\App\Controller\HomeController::class, 'index'],
                '/contact' => [\App\Controller\ContactController::class, 'index'],

                '/user' => [\App\Controller\UserController::class, 'index'],
                '/user/{id}' => [\App\Controller\UserController::class, 'show'],
                '/user/new' => [\App\Controller\UserController::class, 'new'],
                '/user/{id}/edit' => [\App\Controller\UserController::class, 'edit'],

                '/login' => [\App\Controller\AuthController::class, 'login'],
                '/register' => [\App\Controller\AuthController::class, 'register'],
                '/logout' => [\App\Controller\AuthController::class, 'logout'],
            ],
            'POST' => [
                '/contact' => [\App\Controller\ContactController::class, 'submit'],

                '/login' => [\App\Controller\AuthController::class, 'login'],
                '/register' => [\App\Controller\AuthController::class, 'register'],
            ]
        ];

        // 1) Route exacte : ex /contact
        if (isset($routes[$httpMethod][$path])) {
            [$controllerClass, $action] = $routes[$httpMethod][$path];
            (new $controllerClass())->$action();
            return;
        }

        // 2) Routes dynamiques : ex /user/{id} qui doit matcher /user/12
        foreach ($routes[$httpMethod] ?? [] as $route => $target) {
            // Transforme une route du type /user/{id} en regex /user/([^/]+)
            $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            // Si l’URL correspond
            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches); // retire l'URL complète

                [$controllerClass, $action] = $target;

                // Passe les paramètres au controller en appellant l'action
                (new $controllerClass())->$action(...$matches);
                return;
            }
        }

        // Si aucune route ne correspond => 404
        http_response_code(404);
        echo "404 - Page introuvable";
    }
}

/**
 * ----------------------------------------------------------
 * 1) C’est quoi la classe App ?
 * ----------------------------------------------------------
 * La classe App, c’est comme le "cerveau" de ton application.
 *
 * Quand quelqu’un ouvre ton site (ex: http://localhost:8000/contact),
 * PHP doit savoir :
 *   - quelle page l’utilisateur veut voir
 *   - quel code il faut exécuter
 *   - quoi afficher ensuite
 *
 * Donc App sert à faire "le chef d'orchestre" :
 * elle reçoit la demande de l'utilisateur et elle décide quoi faire.
 *
 * Exemple simple :
 * - L’utilisateur va sur /contact
 * - App comprend que /contact correspond à ContactController
 * - App appelle le controller ainsi que la méthode associée (ContactController->index())
 * - Le controller affiche une vue (la page contact)
 *
 *
 * ----------------------------------------------------------
 * 2) Qu’est-ce que App fait exactement ?
 * ----------------------------------------------------------
 * À chaque requête (chaque fois qu’on ouvre une URL), App fait ces étapes :
 *
 * Étape 1 : elle regarde la méthode HTTP
 * Exemple :
 *   - GET  -> quand on visite une page (afficher)
 *   - POST -> quand on envoie un formulaire (traiter)
 *
 * Étape 2 : elle regarde le chemin dans l’URL
 * Exemple :
 *   - /            => accueil
 *   - /contact     => page contact
 *   - /user/12     => profil utilisateur 12
 *
 * Étape 3 : elle cherche la route correspondante
 * Exemple :
 *   '/contact' => ContactController@index
 *
 * Étape 4 : elle appelle le bon contrôleur + la bonne méthode
 * Exemple :
 *   (new ContactController())->index();
 *
 * Étape 5 : si aucune route ne correspond => elle affiche 404
 *
 *
 * ----------------------------------------------------------
 * 3) C’est quoi une route ? (super important)
 * ----------------------------------------------------------
 * Une route, c’est une règle un chemin à prendre qui dit :
 *
 *    "Si l’utilisateur va sur cette URL, alors on exécute ce code"
 *
 * Exemple :
 *    /contact  => ContactController@index
 *
 * Donc ton tableau $routes sert de "plan" pour ton site.
 * C’est comme un GPS :
 *   - l’URL = destination
 *   - le contrôleur = chemin à prendre
 *
 *
 * ----------------------------------------------------------
 * 4) Routes fixes vs routes dynamiques (avec {id})
 * ----------------------------------------------------------
 *
 * Route fixe :
 *   /contact
 *   -> toujours pareil
 *
 * Route dynamique :
 *   /user/{id}
 *   -> {id} change en fonction de l’utilisateur
 *
 * Exemple :
 *   /user/10  -> id = 10
 *   /user/77  -> id = 77
 *
 * Dans ton code, App transforme :
 *   /user/{id}
 * en une expression régulière qui peut reconnaître :
 *   /user/10
 *   /user/77
 *
 * Et ensuite, App envoie automatiquement l’id dans ton controller :
 *   UserController->show("10")
 *
 *
 * ----------------------------------------------------------
 * 5) Résumé ultra simple
 * ----------------------------------------------------------
 * La classe App sert à :
 *
 * - récupérer l’URL demandée par l’utilisateur
 * - trouver quel contrôleur appeler
 * - exécuter l’action correspondante
 * - afficher une erreur si la page n’existe pas
 *
 */
