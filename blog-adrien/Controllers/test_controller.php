<?php
// test_controller.php

class Test_Ctrl extends Ctrl {
    public function index() {
        // Exemple de données à passer à la vue
        $this->dataArray['message'] = "Bienvenue sur le blog!";
        
        // Récupérer les articles depuis la base de données
        require_once('models/bdd.php');
        $db = new Bdd();
        $connexion = $db->getConnexion();
        
        // Requête pour récupérer les articles
        $stmt = $connexion->query('SELECT * FROM T_Articles');
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Passer les articles à la vue
        $this->dataArray['articles'] = $articles;
        
        // Afficher la vue
        $this->render('test_view');

    }
}
