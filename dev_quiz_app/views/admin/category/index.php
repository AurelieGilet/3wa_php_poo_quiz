<main>
    <h1>Gestion des catégories</h1>

    <a href="/admin/categorie/ajouter">Ajouter une catégorie</a>

    <div>
        <ul>
            <?php foreach ($params['categories'] as $category) : ?>
                <li><?= htmlspecialchars($category->name) ?></li>
                <li><a href="/admin/categorie/modifier/<?= $category->id ?>">Modifier</a></li>
                <li>
                    <form action="/admin/categorie/supprimer/<?= $category->id ?>" method="POST">
                        <button type="submit">Supprimer</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</main>