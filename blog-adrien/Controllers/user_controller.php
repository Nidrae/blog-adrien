<?php
// controllers/user_controller.php

require_once('models/user_model.php');

class User_Ctrl extends Ctrl {
    private $userModel;

    public function __construct() {
        // Initialisation du modèle UserModel
        $this->userModel = new UserModel();
    }

    // Afficher le formulaire de création d'utilisateur
    public function createUser() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = trim($_POST['nom']);
            $prenom = trim($_POST['prenom']);
            $email = trim($_POST['email']);
            $mdp = $_POST['mdp'];

            $result = $this->userModel->createUser($nom, $prenom, $email, $mdp);

            if ($result === true) {
                $_SESSION['success_message'] = "Utilisateur créé avec succès !";
                header("Location: index.php?ctrl=user&action=createUser");
                exit();
            } else {
                $_SESSION['error_message'] = $result;
            }
        }
        include('views/create_user_view.php');
    }

    // Authentifier l'utilisateur
    public function loginUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $mdp = $_POST['mdp'];

            $user = $this->userModel->authenticateUser($email, $mdp);

            if ($user) {
                $_SESSION['user'] = [
                    'nom' => $user['U_Nom'],
                    'prenom' => $user['U_Prenom'],
                    'email' => $user['U_Mail'],
                    'is_admin' => $user['U_IsAdmin']
                ];
                header("Location: index.php?ctrl=accueil&action=index");
                exit();
            } else {
                $error = "Email ou mot de passe incorrect";
                include("views/login_user_view.php");
            }
        } else {
            include("views/login_user_view.php");
        }

      
    }

    public function logoutUser() {
        // Nettoyer la session
        session_unset();
        session_destroy();
    
        // Rediriger vers la page d'accueil
        header("Location: index.php?ctrl=accueil&action=index");
        exit();
    }

    public function profileUser() {
        // Vérifier si l'utilisateur est connecté
        if (isset($_SESSION['user'])) {
            // Affichage de la vue du profil
            include("views/profile_user_view.php");
        } else {
            // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
            header("Location: index.php?ctrl=user&action=loginUser");
            exit();
        }
    }
    
}
?>
