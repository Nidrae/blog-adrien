<!-- Views/_partial/header.php -->
<header>
    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="#">About</a></li>
            <li><a href="#">Travel</a></li>
            <li><a href="#">Portfolio</a></li>
            <li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="profile.php">Profil</a>
                <?php else: ?>
                    <a href="index.php?ctrl=user&action=createUser">Créer un compte</a> <!-- Lien vers la création d'utilisateur -->
                    <a href="login.php">Connexion</a>
                <?php endif; ?>
            </li>
        </ul>
    </nav>

    <!-- Bannière -->
    <div class="banner">
        <h1>Blog d'Adrien</h1>
    </div>
</header>
<style>
    header {
        background-color: #f1f1f1; /* Gris clair */
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
