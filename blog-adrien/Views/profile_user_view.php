<h1>Profil</h1>
<p>Nom : <?= htmlspecialchars($_SESSION['user']['nom']); ?></p>
<p>Prénom : <?= htmlspecialchars($_SESSION['user']['prenom']); ?></p>
<p>Email : <?= htmlspecialchars($_SESSION['user']['email']); ?></p>

<?php if ($is_admin): ?>
    <h2>Panneau de modération</h2>
    <form method="POST" action="index.php?ctrl=user&action=banUser">
        <label for="user">Sélectionnez un utilisateur :</label>
        <input type="text" id="user-search" placeholder="Rechercher un utilisateur..." oninput="filterUsers()" />

        <select id="user-dropdown" name="user_id" required>
            <?php foreach ($users as $user): ?>
                <option value="<?= htmlspecialchars($user['U_ID']); ?>">
                    <?= htmlspecialchars($user['U_Nom'] . " " . $user['U_Prenom'] . " (" . $user['U_Mail'] . ")"); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir bannir cet utilisateur ?')">Bannir</button>
    </form>

    <script>
        function filterUsers() {
            const searchInput = document.getElementById('user-search').value.toLowerCase();
            const dropdown = document.getElementById('user-dropdown');
            const options = dropdown.options;

            for (let i = 0; i < options.length; i++) {
                const text = options[i].textContent.toLowerCase();
                options[i].style.display = text.includes(searchInput) ? '' : 'none';
            }
        }
    </script>
<?php endif; ?>
