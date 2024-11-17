<header id="site-header">
    <!-- Bannière -->
    <div class="banner">
        <h1>Blog d'Adrien</h1>
    </div>

    <!-- Navigation -->
    <nav>
        <ul>
        <link rel="stylesheet" href="Assets/css/header.css">
            <li><a href="index.php?ctrl=accueil&action=index">Accueil</a></li>
            <li><a href="index.php?ctrl=accueil&action=about">À propos</a></li>
            <li><a href="index.php?ctrl=article&action=portfolio">Portfolio</a></li>
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['is_admin'] == '1'): ?>
                <li><a href="index.php?ctrl=article&action=createArticle">Créer un article</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION['user'])): ?>
                <li><a href="index.php?ctrl=user&action=profileUser">Profil</a></li>
                <li><a href="index.php?ctrl=user&action=logoutUser">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="index.php?ctrl=user&action=createUser">Créer un compte</a></li>
                <li><a href="index.php?ctrl=user&action=loginUser">Connexion</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
