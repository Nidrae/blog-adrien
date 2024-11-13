<?php
// controllers/user_controller.php

require_once('models/user_model.php');

class User_Ctrl extends Ctrl {

    // Afficher le formulaire de création d'utilisateur
    public function createUser() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = trim($_POST['nom']);
            $prenom = trim($_POST['prenom']);
            $email = trim($_POST['email']);
            $mdp = $_POST['mdp'];

            $userModel = new UserModel();
            $result = $userModel->createUser($nom, $prenom, $email, $mdp);

            if ($result === true) {
                // Redirection ou message de succès
                $_SESSION['success_message'] = "Utilisateur créé avec succès !";
                header("Location: index.php?ctrl=user&action=createUser");
                exit();
            } else {
                // Affichage du message d'erreur
                $_SESSION['error_message'] = $result;
            }
        }

        // Affichage de la vue
        include('views/create_user_view.php');
    }
}
?>
