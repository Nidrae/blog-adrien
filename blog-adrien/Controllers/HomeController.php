<?php
// controllers/HomeController.php

require_once 'models/bdd.php';

class HomeController {

    // Affichage de la page d'accueil
    public function index() {
        // Créer une instance de Bdd pour accéder à la base de données
        $db = new Bdd();
        $connexion = $db->getConnexion();

        // On peut tester ici une simple récupération de données depuis la base (par exemple les articles)
        $stmt = $connexion->query('SELECT * FROM T_Articles LIMIT 5');
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Charger la vue avec les articles récupérés
        require 'views/home.php';
    }
}
?>
