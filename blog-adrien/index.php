<?php
session_start();

$strCtrl = $_GET['ctrl'] ?? "article";
$strAction = $_GET['action'] ?? "index";

require("controllers/mother_controller.php");

$controllerFile = "controllers/".$strCtrl."_controller.php";
if (file_exists($controllerFile)) {
    require($controllerFile);
    $strClassName = ucfirst($strCtrl) . "_Ctrl";
    $objCtrl = new $strClassName;
    $objCtrl->$strAction();
} else {
    echo "Le fichier du contrôleur n'existe pas : " . $controllerFile . "<br>";
    header("Location:index.php?ctrl=error&action=error_404");
}
