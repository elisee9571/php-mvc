<?php

namespace App\Core;

abstract class Controller
{
    /**
     * @info Affiche une vue (un fichier dans templates/)
     *
     * @param string $view Nom de la vue (ex: "contact" => templates/contact.php)
     * @param array $params Données envoyées à la vue (ex: ["title" => "Contact"])
     */
    protected function render(string $view, array $params = []): void
    {
        // Transforme le tableau $params en variables utilisables dans la vue
        // Exemple : ["title" => "Contact"] devient une variable $title
        extract($params);

        // Charge le fichier de vue (template) correspondant
//        require dirname(__DIR__) . "/../templates/$view.php";

//        Partie : 2
        $contentFile = dirname(__DIR__) . "/../templates/$view.php";
        $layoutFile = dirname(__DIR__) . "/../templates/layout.php";
        require $layoutFile;

        /**
         * En PHP, include et require servent tous les deux à charger un fichier PHP dans un autre fichier (templates, config, fonctions, etc.).
         * La grande différence, c’est ce qu’il se passe si le fichier n’existe pas ou est introuvable.
         * */
    }

    // Partie : 3
    protected function redirect(string $url): void
    {
        header("Location: $url");
        die();
    }
}

/**
 *
 * ----------------------------------------------------------
 * 1) C’est quoi un Controller en MVC ?
 * ----------------------------------------------------------
 * Dans le pattern MVC :
 *
 * - Model      => gère les données (BDD, logique métier, etc.)
 * - View       => affiche du HTML (ce que l'utilisateur voit)
 * - Controller => fait le lien entre Model et View
 *
 * Le Controller est donc "le chef" d’une page :
 *   - il reçoit une demande (URL)
 *   - il prépare les données
 *   - il affiche une vue
 *
 * Exemple :
 *  - l'utilisateur va sur /contact
 *  - ContactController->index() est appelé
 *  - ce controller affiche la page en injectant les variables qui sont utilisées par la page (templates/contact.php)
 *
 *
 * ----------------------------------------------------------
 * 2) Pourquoi une classe Controller "abstraite" ?
 * ----------------------------------------------------------
 * Ici, on crée une classe Controller qui servira de base (parent)
 * pour tous nos controllers.
 *
 * Exemple :
 *   - HomeController extends Controller
 *   - ContactController extends Controller
 *   - UserController extends Controller
 *
 * L'idée est simple :
 * - Si tous les controllers ont besoin d'une méthode render(),
 * alors on écrit render() UNE seule fois ici,
 * et tous les controllers peuvent l'utiliser.
 *
 * Ça évite de recopier la même méthode partout.
 *
 *
 * ----------------------------------------------------------
 * 3) Pourquoi "abstract class" ?
 * ----------------------------------------------------------
 * "abstract" signifie :
 *   - on n'a pas le droit de faire : new Controller()
 *   - c’est une classe qui sert uniquement de base pour les enfants
 *
 * Elle sert donc à partager du code commun.
 *
 *
 * ----------------------------------------------------------
 * 4) À quoi sert la méthode render() ?
 * ----------------------------------------------------------
 * La méthode render() sert à afficher une vue (un fichier HTML/PHP)
 * tout en envoyant des données dedans.
 *
 * Exemple :
 *   $this->render("contact", ["title" => "Contact"]);
 *
 * Cela va :
 *   - ouvrir templates/contact.php
 *   - et donner accès à une variable $title dans cette vue
 *
 *
 * ----------------------------------------------------------
 * 5) À quoi sert extract($params) ?
 * ----------------------------------------------------------
 * extract() permet de transformer un tableau associatif en variables.
 *
 * Exemple :
 *   $params = ["title" => "Contact", "message" => "Salut"];
 *
 * Après extract($params), tu peux utiliser :
 *   $title   => "Contact"
 *   $message => "Salut"
 *
 * Dans une vue tu peux donc faire :
 *   <h1><?= $title ?></h1>
 *
 * Ça rend les vues plus simples à écrire.
 *
 *
 * ----------------------------------------------------------
 * 6) Pourquoi "protected" ?
 * ----------------------------------------------------------
 * protected signifie :
 * - accessible depuis les controllers enfants
 * - pas accessible depuis l’extérieur
 *
 * Donc dans ContactController tu peux faire :
 *   $this->render(...)
 *
 *
 * ----------------------------------------------------------
 * 7) dirname(__DIR__) c’est quoi ?
 * ----------------------------------------------------------
 * __DIR__ représente le dossier actuel de ce fichier.
 *
 * Ici le fichier est dans :
 *   src/Core/Controller.php
 *
 * dirname(__DIR__) remonte d’un dossier :
 *   src/
 *
 * Ensuite on remonte encore avec /../ pour aller à la racine du projet
 * puis on vise :
 *   templates/$view.php
 *
 * Donc si tu fais :
 *   $this->render("contact");
 *
 * PHP va charger :
 *   templates/contact.php
 *
 *
 * ----------------------------------------------------------
 * 8) Résumé ultra simple
 * ----------------------------------------------------------
 * Cette classe Controller sert à :
 *
 * - avoir un render() commun
 * - éviter de répéter le code dans chaque controller
 * - afficher une vue facilement en envoyant des données
 */
