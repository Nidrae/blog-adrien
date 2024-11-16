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
        $this->display("create_user_view");
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
                $this->display("login_user_view");
            } elseif ($user) {
                // Stocker les informations de l'utilisateur dans $_SESSION
                $_SESSION['user'] = [
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
                $this->display("login_user_view");
            }
        } else {
            $this->display("login_user_view");
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
            $this->_arrData['users'] = $allUsers;
        }
    
        $this->_arrData['is_admin'] = $isAdmin;
        $this->display("profile_user_view");
    }


    public function banUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
            $adminEmail = $_SESSION['user']['email'];
            $userId = $_POST['user_id'];
    
            // Vérifier si l'utilisateur connecté est toujours administrateur
            $isAdmin = $this->userModel->isAdmin($adminEmail);
    
            if ($isAdmin) {
                $this->userModel->banUser($userId);
                header("Location: index.php?ctrl=user&action=profileUser");
                exit();
            } else {
                // Rediriger vers une vue d'erreur 405
                $this->display("error_405");
                exit();
            }
        } else {
            // Rediriger vers la vue d'erreur si la méthode est incorrecte
            $this->display("error_405");
            exit();
        }
    }
    
    

    
    
}
?>
