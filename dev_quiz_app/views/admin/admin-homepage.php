<main>
    <h1>Bienvenue <?= htmlspecialchars($params['user']->getAlias()) ?></h1>

    <div class="grid-column-container">
        <a href="/admin/utilisateurs" class="clipped-button">
            Gestion des utilisateurs
        </a>
        <a href="/admin/categories" class="clipped-button">
            Gestion des catégories
        </a>
        <a href="/admin/questions" class="clipped-button">
            Gestion des questions
        </a>
    </div>
</main>

