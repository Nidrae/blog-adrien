<?php
session_start();

// Redirection vers l'accueil si aucun contrôleur n'est spécifié
if (!isset($_GET['ctrl'])) {
    header("Location: http://localhost:8888/blog/blog-adrien/Blog-adrien/index.php?ctrl=accueil&action=index");
    exit();
}

$strCtrl = $_GET['ctrl'] ?? "article";
$strAction = $_GET['action'] ?? "index";

require("controllers/mother_controller.php");

$controllerFile = "controllers/" . $strCtrl . "_controller.php";
if (file_exists($controllerFile)) {
    require($controllerFile);
    $strClassName = ucfirst($strCtrl) . "_Ctrl";
    
    // Vérifie si la classe existe pour éviter des erreurs
    if (class_exists($strClassName)) {
        $objCtrl = new $strClassName;

        // Vérifie si la méthode demandée existe dans le contrôleur
        if (method_exists($objCtrl, $strAction)) {
            $objCtrl->$strAction();
        } else {
            // Méthode non trouvée, redirection vers la page d'erreur 404
            $objCtrl->render("error_404_view");
        }
    } else {
        // Classe du contrôleur non trouvée, redirection vers la page d'erreur 404
        (new Ctrl)->render("error_404_view");
    }
} else {
    // Fichier du contrôleur non trouvé, redirection vers la page d'erreur 404
    (new Ctrl)->render("error_404_view");
}
