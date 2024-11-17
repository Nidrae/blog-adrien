<link rel="stylesheet" href="Assets/css/article.css">

<div class="article-container">
    <?php if (!empty($article)): ?>
        <h1><?= htmlspecialchars($article['A_Titre'] ?? 'Titre indisponible') ?></h1>
        
        <!-- Image principale -->
        <div class="main-image">
            <img src="Assets/images/<?= htmlspecialchars($article['A_Image'] ?? 'default.jpg') ?>" alt="<?= htmlspecialchars($article['A_Titre'] ?? 'Image indisponible') ?>" onclick="openLightbox(this.src)">
        </div>

        <!-- Contenu de l'article -->
        <p><?= nl2br(htmlspecialchars($article['A_Contenu'] ?? 'Contenu indisponible')) ?></p>
        
        <!-- Images supplémentaires en 3x3 -->
        <div class="additional-images">
            <?php for ($i = 2; $i <= 9; $i++): ?>
                <?php if (!empty($article['A_Image' . $i])): ?>
                    <div class="image">
                        <img src="Assets/images/<?= htmlspecialchars($article['A_Image' . $i]) ?>" alt="Image supplémentaire" onclick="openLightbox(this.src)">
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>

        <!-- Actions d'administration -->
        <?php if (isset($_SESSION['user']) && $_SESSION['user']['is_admin'] == '1'): ?>
            <div class="admin-actions">
                <a href="index.php?ctrl=article&action=updateArticle&id=<?= $article['A_ID'] ?>" class="btn btn-primary">Modifier l'article</a>
                <button class="btn btn-danger" onclick="confirmDeletion(<?= $article['A_ID'] ?>)">Supprimer l'article</button>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <p>Article introuvable ou non disponible.</p>
    <?php endif; ?>
</div>

<!-- Conteneur de lightbox -->
<div id="lightbox" class="lightbox" onclick="closeLightbox()">
    <span class="close">&times;</span>
    <img id="lightboxImage" class="lightbox-image" src="">
</div>

<script>
    function openLightbox(src) {
        document.getElementById('lightbox').style.display = 'flex';
        document.getElementById('lightboxImage').src = src;
    }

    function closeLightbox() {
        document.getElementById('lightbox').style.display = 'none';
    }

    function confirmDeletion(articleId) {
        if (confirm("Êtes-vous sûr de vouloir supprimer cet article ?")) {
            window.location.href = `index.php?ctrl=article&action=deleteArticle&id=${articleId}`;
        }
    }
</script>
