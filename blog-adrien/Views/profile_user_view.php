<!-- views/profile_user_view.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de l'utilisateur</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- En-tête -->
    <?php include('views/_partial/header.php'); ?>

    <div class="profile-container">
        <h2>Profil de l'utilisateur</h2>
        <p><strong>Nom:</strong> <?php echo $_SESSION['user']['nom']; ?></p>
        <p><strong>Prénom:</strong> <?php echo $_SESSION['user']['prenom']; ?></p>
        <p><strong>Email:</strong> <?php echo $_SESSION['user']['email']; ?></p>

        <!-- Bouton de déconnexion -->
        <a href="index.php?ctrl=user&action=logoutUser" class="btn-deconnexion">Déconnexion</a>
    </div>

    <style>
        .profile-container {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        .profile-container h2 {
            text-align: center;
        }

        .profile-container p {
            font-size: 18px;
        }

        .profile-container .btn-deconnexion {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }

        .profile-container .btn-deconnexion:hover {
            background-color: #0056b3;
        }
    </style>
</body>
</html>
