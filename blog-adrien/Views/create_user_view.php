<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création d'un utilisateur</title>
    <link rel="stylesheet" href="Assets/css/create_user.css">
</head>
<body>
    <main id="create-user-page">
        <h2>Créer un compte</h2>

        <!-- Affichage des messages d'erreur ou de succès -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="error"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
        <?php endif; ?>

        <!-- Formulaire d'inscription -->
        <form action="index.php?ctrl=user&action=createUser" method="POST">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required><br>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required><br>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required><br>

            <label for="mdp">Mot de passe :</label>
            <input type="password" id="mdp" name="mdp" required>
            <!-- Règles du mot de passe affichées lorsque l'utilisateur clique sur le champ -->
            <div class="password-rules">
                Le mot de passe doit contenir :
                <ul>
                    <li>Au moins 8 caractères</li>
                    <li>Au moins une majuscule</li>
                    <li>Au moins un chiffre</li>
                    <li>Maximum 22 caractères</li>
                </ul>
            </div><br>

            <button type="submit">Créer mon compte</button>
        </form>
    </main>
</body>
</html>
