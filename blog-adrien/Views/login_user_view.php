<!-- views/login_user_view.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error; ?></p>
    <?php endif; ?>
    
    <form action="index.php?ctrl=user&action=loginUser" method="post">
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required>
        
        <label for="mdp">Mot de passe :</label>
        <input type="password" name="mdp" id="mdp" required>
        
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
