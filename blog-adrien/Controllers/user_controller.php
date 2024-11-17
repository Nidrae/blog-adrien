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
        $this->render("create_user_view");
    }

    // Authentifier l'utilisateur
    public function loginUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $mdp = $_POST['mdp'];
    
            $user = $this->userModel->authenticateUser($email, $mdp);
    
            if ($user === 'banned') {
                // Message pour les comptes bannis
                $error = "Votre compte a été banni. Contactez un administrateur pour plus d'informations.";
                $this->render("login_user_view");
            } elseif ($user) {
                // Stocker les informations de l'utilisateur dans $_SESSION
                $_SESSION['user'] = [
                    'id' => $user['U_ID'],
                    'nom' => $user['U_Nom'],
                    'prenom' => $user['U_Prenom'],
                    'email' => $user['U_Mail'],
                    'is_admin' => $user['U_IsAdmin']
                ];
                header("Location: index.php?ctrl=accueil&action=index");
                exit();
            } else {
                // Message pour un échec d'authentification
                $error = "Email ou mot de passe incorrect";
                $this->render("login_user_view");
            }
        } else {
            $this->render("login_user_view");
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
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?ctrl=user&action=loginUser");
            exit();
        }
    
        // Vérifier si l'utilisateur est admin
        $isAdmin = $this->userModel->isAdmin($_SESSION['user']['email']); // Nouvelle méthode dans le modèle
    
        if ($isAdmin) {
            // Récupérer tous les utilisateurs pour la liste déroulante
            $allUsers = $this->userModel->getAllUsers();
            $this->dataArray['users'] = $allUsers;
        }
    
        $this->dataArray['is_admin'] = $isAdmin;
        $this->render("profile_user_view");
    }


    public function banUser() {
        // Vérifier si l'utilisateur est administrateur
        if (empty($_SESSION['user']) || $_SESSION['user']['is_admin'] != '1') {
            header("Location: index.php?ctrl=accueil&action=index");
            exit();
        }
    
        // Récupérer l'email de l'utilisateur à bannir
        $userEmail = $_POST['user_email'] ?? '';
    
        if ($userEmail) {
            // Rechercher l'utilisateur par email et mettre à jour le statut de bannissement
            $banned = $this->userModel->banUserByEmail($userEmail);
            if ($banned) {
                $_SESSION['success_message'] = "L'utilisateur a été banni avec succès.";
            } else {
                $_SESSION['error_message'] = "Erreur lors du bannissement de l'utilisateur.";
            }
        } else {
            $_SESSION['error_message'] = "Veuillez sélectionner un utilisateur valide.";
        }
    
        // Rediriger vers la page de profil
        header("Location: index.php?ctrl=user&action=profileUser");
    }
    
    
    

    
    
}
?>
