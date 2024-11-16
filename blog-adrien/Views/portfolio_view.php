<div class="portfolio-container">
    <h1>Portfolio</h1>
    <form method="POST" action="">
        <label for="country-filter">Filtrer par pays :</label>
        <select name="country" id="country-filter">
            <option value="">Tous les pays</option>
            <?php foreach ($countries as $country): ?>
                <option value="<?= htmlspecialchars($country['A_Pays']) ?>" <?= $selectedCountry === $country['A_Pays'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($country['A_Pays']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtrer</button>
    </form>

    <div class="articles">
        <?php if (empty($articles)): ?>
            <p>Aucun article trouvé pour ce pays.</p>
        <?php else: ?>
            <?php foreach ($articles as $article): ?>
                <div class="article">
                    <img src="assets/images/<?= htmlspecialchars($article['A_Image'] ?? 'default.jpg') ?>" alt="<?= htmlspecialchars($article['A_Titre'] ?? 'Image indisponible') ?>">
                    <h2><?= htmlspecialchars($article['A_Titre'] ?? 'Titre indisponible') ?></h2>
                    <p><?= htmlspecialchars(substr($article['A_Contenu'] ?? '', 0, 30)) ?>...</p>
                    <a href="index.php?ctrl=article&action=view&id=<?= $article['A_ID'] ?>">Lire l'article</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
