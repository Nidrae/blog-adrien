<!-- Views/_partial/header.php -->
<header>
    <?php
    // Affichage de $_SESSION pour le débogage (à retirer en production)
    echo "<pre>";
    var_dump($_SESSION);
    echo "</pre>";
    ?>

    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="index.php?ctrl=accueil&action=index">Accueil</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Travel</a></li>
            <li><a href="index.php?ctrl=article&action=portfolio">Portfolio</a></li>
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['is_admin'] == '1'): ?>
            <li><a href="index.php?ctrl=article&action=createArticle">Créer un article</a></li>
            <?php endif; ?>
            <!-- Vérification de l'existence de l'utilisateur dans la session -->
            <?php if (isset($_SESSION['user'])): ?>
                <li><a href="index.php?ctrl=user&action=profileUser">Profil</a></li>
                <li><a href="index.php?ctrl=user&action=logoutUser">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="index.php?ctrl=user&action=createUser">Créer un compte</a></li>
                <li><a href="index.php?ctrl=user&action=loginUser">Connexion</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Bannière -->
    <div class="banner">
        <h1>Blog d'Adrien</h1>
    </div>
</header>

<!-- CSS pour la navigation -->
<style>
    header {
        background-color: #f1f1f1;
        padding: 20px;
    }
    nav ul {
        list-style-type: none;
        padding: 0;
    }
    nav ul li {
        display: inline;
        margin-right: 15px;
    }
    nav ul li a {
        text-decoration: none;
        color: #333;
        font-size: 16px;
    }
    .banner {
        background-color: #d3d3d3;
        padding: 40px;
        text-align: center;
    }
    .banner h1 {
        font-size: 3em;
        margin: 0;
    }
</style>
