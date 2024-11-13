<!-- views/accueil_view.php -->
<div class="container main-content home-page">
<link rel="stylesheet" href="/blog/blog-adrien/Blog-adrien/Assets/css/style.css">
    <h2>Bienvenue sur le blog d'Adrien !</h2>
    <div class="article-grid">
        <?php foreach ($articles as $article): ?>
            <div class="article-block">
                <img src="assets/images/<?php echo htmlspecialchars($article['A_Image']); ?>" alt="Image de l'article">
                <h3><?php echo htmlspecialchars($article['A_Titre']); ?></h3>
                <p><?php echo htmlspecialchars(substr($article['A_Contenu'], 0, 30)) . '...'; ?></p>
           <button>Lire l'article</button>
</div>
        <?php endforeach; ?>
    </div>
</div>
