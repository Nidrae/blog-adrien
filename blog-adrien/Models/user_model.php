<?php
// models/user_model.php

require_once("models/bdd.php");

class UserModel {
    private $pdo;

    public function __construct() {
        $bdd = new Bdd();
        $this->pdo = $bdd->getConnexion();
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
        $stmtCheck = $this->pdo->prepare($queryCheck);
        $stmtCheck->execute([$email]);
        $emailExists = $stmtCheck->fetchColumn();

        if ($emailExists > 0) {
            return "Cet email est déjà utilisé.";
        }

        // Hashage du mot de passe
        $hashedPassword = password_hash($mdp, PASSWORD_BCRYPT);

        // Préparation de la requête d'insertion
        $queryInsert = "INSERT INTO T_User (U_Nom, U_Prenom, U_Mail, U_Mdp) VALUES (?, ?, ?, ?)";
        $stmtInsert = $this->pdo->prepare($queryInsert);
        $stmtInsert->execute([$nom, $prenom, $email, $hashedPassword]);

        return true;
    }

    public function authenticateUser($email, $mdp) {
        // Récupération des informations utilisateur
        $query = "SELECT U_ID, U_Nom, U_Prenom, U_Mail, U_Mdp, U_IsAdmin, U_IsBan FROM T_User WHERE U_Mail = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user) {
            if ($user['U_IsBan']) {
                return 'banned'; // Indicateur pour un compte banni
            }
            // Vérification du mot de passe
            if (password_verify($mdp, $user['U_Mdp'])) {
                return $user;
            }
        }
        return false;
    }

    public function getAllUsers() {
        $query = "SELECT U_ID, U_Nom, U_Prenom, U_Mail FROM T_User WHERE U_IsAdmin = 0 AND U_IsBan = 0";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function banUserByEmail($email) {
        $query = "UPDATE T_User SET U_IsBan = 1 WHERE U_Mail = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function isAdmin($email) {
        $query = "SELECT U_IsAdmin FROM T_User WHERE U_Mail = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result && $result['U_IsAdmin'] == 1;
    }
}
