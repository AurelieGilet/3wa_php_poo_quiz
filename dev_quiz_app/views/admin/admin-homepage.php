<main>
    <h1>Bienvenue <?= htmlspecialchars($params['user']->getAlias()) ?></h1>

    <div>
        <a href="/admin/utilisateurs">Gestion des utilisateurs</a>
        <a href="/admin/categories">Gestion des catégories</a>
        <a href="/admin/questions">Gestion des questions</a>
    </div>
</main>

