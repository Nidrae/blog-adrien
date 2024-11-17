<div class="container main-content home-page">
<link rel="stylesheet" href="Assets/css/accueil.css">
    <div class="article-grid">
        <?php foreach ($articles as $article): ?>
            <div class="article-block">
                <img src="assets/images/<?php echo htmlspecialchars($article['A_Image']); ?>" alt="Image de l'article">
                <h3><?php echo htmlspecialchars($article['A_Titre']); ?></h3>
                <p><?php echo htmlspecialchars(substr($article['A_Contenu'], 0, 30)) . '...'; ?></p>
                
                <!-- Lien vers l'article -->
                <a href="index.php?ctrl=article&action=viewArticle&id=<?php echo $article['A_ID']; ?>" class="btn">Lire l'article</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
