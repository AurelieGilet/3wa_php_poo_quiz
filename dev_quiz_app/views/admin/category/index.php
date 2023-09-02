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
            <li>Nom de la catégorie : <?= htmlspecialchars($category->getName()) ?></li>
            <li>Nombre de questions associées :<?= htmlspecialchars($category->getQuestionsCount()) ?></li>
            <li><a href="/admin/categorie/modifier/<?= $category->getId() ?>">Modifier</a></li>
            <li><a href="/admin/categorie/supprimer/<?= $category->getId() ?>">Supprimer</a></li>
        </ul>
        <?php endforeach; ?>
    </div>
</main>