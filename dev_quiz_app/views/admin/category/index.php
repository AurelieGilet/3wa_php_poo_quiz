<main>
    <h1>Gestion des catégories</h1>

    <?php if (isset($params['flashes'])) : ?>
        <ul>
        <?php foreach ($params['flashes'] as $flash) : ?>
            <?= $flash ?>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <a href="/admin/categorie/ajouter">Ajouter une catégorie</a>

    <div>
        <?php foreach ($params['categories'] as $category) : ?>
        <ul>
            <li><?= htmlspecialchars($category->getName()) ?></li>
            <li><a href="/admin/categorie/modifier/<?= $category->getId() ?>">Modifier</a></li>
            <li>
                <form action="/admin/categorie/supprimer/<?= $category->getId() ?>" method="POST">
                    <button type="submit">Supprimer</button>
                </form>
            </li>
        </ul>
        <?php endforeach; ?>
    </div>
</main>