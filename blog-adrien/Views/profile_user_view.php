<link rel="stylesheet" href="Assets/css/profile.css">

<div class="profile-container">
    <h1>Profil</h1>
    <p>Nom : <?= htmlspecialchars($_SESSION['user']['nom']); ?></p>
    <p>Prénom : <?= htmlspecialchars($_SESSION['user']['prenom']); ?></p>
    <p>Email : <?= htmlspecialchars($_SESSION['user']['email']); ?></p>
</div>

<?php if ($is_admin): ?>
    <h2>Panneau de modération</h2>
    <form method="POST" action="index.php?ctrl=user&action=banUser">
        <label for="user-search">Rechercher un utilisateur :</label>
        <input 
            type="text" 
            id="user-search" 
            name="user_email" 
            placeholder="Rechercher par nom, prénom ou email..." 
            list="user-list" 
            required
        />

        <!-- Liste de suggestions d'utilisateurs -->
        <datalist id="user-list">
            <?php foreach ($users as $user): ?>
                <option value="<?= htmlspecialchars($user['U_Mail']); ?>">
                    <?= htmlspecialchars($user['U_Nom'] . " " . $user['U_Prenom'] . " (" . $user['U_Mail'] . ")"); ?>
                </option>
            <?php endforeach; ?>
        </datalist>

        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir bannir cet utilisateur ?')">Bannir</button>
    </form>
<?php endif; ?>
