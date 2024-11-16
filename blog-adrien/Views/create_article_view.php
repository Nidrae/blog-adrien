<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Article</title>
</head>
<body>
    <h1>Créer un nouvel article</h1>
    
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="index.php?ctrl=article&action=createArticle" method="POST" enctype="multipart/form-data">
        <label for="titre">Titre :</label><br>
        <input type="text" id="titre" name="titre" maxlength="255" required><br><br>

        <label for="image">Image principale :</label><br>
        <input type="file" id="image" name="image" accept="image/*" required><br><br>

        <label for="contenu">Contenu :</label><br>
        <textarea id="contenu" name="contenu" rows="5" required></textarea><br><br>

        <label for="pays">Pays des photos :</label><br>
        <input type="text" id="pays" name="pays" required><br><br>

        <label for="images_optionnelles">Photos optionnelles :</label><br>
        <input type="file" id="images_optionnelles" name="images_optionnelles[]" accept="image/*" multiple><br><br>

        <button type="submit">Créer l'article</button>
    </form>
</body>
</html>
