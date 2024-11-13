<?php
// models/user_model.php

require_once("models/bdd.php");
class UserModel {
    private $bdd;

    public function __construct() {
        $this->bdd = new Bdd();
    }

    public function createUser($nom, $prenom, $email, $mdp) {
        // Validation des données
        if (empty($nom) || empty($prenom) || empty($email) || empty($mdp)) {
            return 'Tous les champs doivent être remplis';
        }
        if (strlen($nom) > 60 || strlen($prenom) > 60 || strlen($email) > 60) {
            return 'Le nom, prénom et email ne peuvent pas dépasser 60 caractères';
        }
        if (strlen($mdp) < 8 || strlen($mdp) > 22 || !preg_match('/[A-Z]/', $mdp) || !preg_match('/[0-9]/', $mdp)) {
            return 'Le mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre, et ne pas dépasser 22 caractères';
        }

        // Hashage du mot de passe
        $hashedPassword = password_hash($mdp, PASSWORD_BCRYPT);

        // Préparation de la requête d'insertion
        $query = "INSERT INTO T_User (U_Nom, U_Prenom, U_Email, U_Password) VALUES (?, ?, ?, ?)";
        $stmt = $this->bdd->getConnexion()->prepare($query);
        $stmt->execute([$nom, $prenom, $email, $hashedPassword]);

        return true;
    }
}
?>
