<!-- test_view.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Backend</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5"><?php echo $message; ?></h1>

        <h3>Liste des articles</h3>
        <?php if (!empty($articles)): ?>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Contenu</th>
                        <th>Date de création</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $article): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($article['A_Titre']); ?></td>
                            <td><?php echo htmlspecialchars($article['A_Contenu']); ?></td>
                            <td><?php echo $article['A_DateCreation']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun article trouvé.</p>
        <?php endif; ?>
    </div>
</body>
</html>
