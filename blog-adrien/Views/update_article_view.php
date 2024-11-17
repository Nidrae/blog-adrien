<!DOCTYPE html>
<link rel="stylesheet" href="Assets/css/update_article.css">

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'article</title>
</head>
<body>
    <h1>Modifier l'article</h1>
    
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="index.php?ctrl=article&action=saveArticle" method="POST" enctype="multipart/form-data">
        <!-- ID caché pour la mise à jour -->
        <input type="hidden" name="A_ID" value="<?= htmlspecialchars($article['A_ID'] ?? '') ?>">

        <label for="A_Titre">Titre :</label><br>
        <input type="text" id="A_Titre" name="A_Titre" maxlength="255" value="<?= htmlspecialchars($article['A_Titre'] ?? '') ?>" required><br><br>

        <label for="A_Image">Image principale :</label><br>
        <input type="file" id="A_Image" name="A_Image" accept="image/*"><br><br>

        <label for="A_Contenu">Contenu :</label><br>
        <textarea id="A_Contenu" name="A_Contenu" rows="5" required><?= htmlspecialchars($article['A_Contenu'] ?? '') ?></textarea><br><br>

        <label for="A_Pays">Pays des photos :</label><br>
        <input type="text" id="A_Pays" name="A_Pays" value="<?= htmlspecialchars($article['A_Pays'] ?? '') ?>" required><br><br>

        <label for="A_Images">Photos optionnelles :</label><br>
        <input type="file" id="A_Images" name="A_Images[]" accept="image/*" multiple><br><br>

        <button type="submit">Mettre à jour l'article</button>
    </form>
</body>
</html>
