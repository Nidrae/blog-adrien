<?php
// index.php

// Inclusion du contrôleur
require_once 'controllers/HomeController.php';

// Créer une instance du contrôleur
$homeController = new HomeController();

// Appeler la méthode 'index' pour afficher la page d'accueil
$homeController->index();
?>
