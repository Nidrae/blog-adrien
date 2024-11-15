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

        // Vérification de l'existence de l'email en base
        $queryCheck = "SELECT COUNT(*) FROM T_User WHERE U_Mail = ?";
        $stmtCheck = $this->bdd->getConnexion()->prepare($queryCheck);
        $stmtCheck->execute([$email]);
        $emailExists = $stmtCheck->fetchColumn();

        if ($emailExists > 0) {
            return "Cet email est déjà utilisé.";
        }

        // Hashage du mot de passe
        $hashedPassword = password_hash($mdp, PASSWORD_BCRYPT);

        // Préparation de la requête d'insertion
        $queryInsert = "INSERT INTO T_User (U_Nom, U_Prenom, U_Mail, U_Mdp) VALUES (?, ?, ?, ?)";
        $stmtInsert = $this->bdd->getConnexion()->prepare($queryInsert);
        $stmtInsert->execute([$nom, $prenom, $email, $hashedPassword]);

        return true;
    }

    public function authenticateUser($email, $mdp) {
        // Récupération des informations utilisateur
        $query = "SELECT U_Nom, U_Prenom, U_Mail, U_Mdp, U_IsAdmin FROM T_User WHERE U_Mail = ?";
        $stmt = $this->bdd->getConnexion()->prepare($query);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification du mot de passe
        if ($user && password_verify($mdp, $user['U_Mdp'])) {
            return $user;
        } else {
            return false;
        }
    }
}
?>
