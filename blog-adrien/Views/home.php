<!-- views/home.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <div class="container">
        <h1 class="mt-5">Bienvenue sur le Blog</h1>
        
        <h2 class="mt-3">Articles récents :</h2>
        
        <?php if (count($articles) > 0): ?>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Titre</th>
                        <th>Contenu</th>
                        <th>Date de création</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $article): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($article['A_ID']); ?></td>
                            <td><?php echo htmlspecialchars($article['A_Titre']); ?></td>
                            <td><?php echo htmlspecialchars(substr($article['A_Contenu'], 0, 100)) . '...'; ?></td>
                            <td><?php echo htmlspecialchars($article['A_DateCreation']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun article disponible pour le moment.</p>
        <?php endif; ?>
    </div>

</body>
</html>
