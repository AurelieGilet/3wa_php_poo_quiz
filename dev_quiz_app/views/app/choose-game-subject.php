<main>
    <h1>Choisir un sujet</h1>
    <div>
        <?php foreach ($params['categories'] as $category) : ?>
        <ul>
            <li><a href="/jeu/categorie/<?= $category->getId() ?>"><?= htmlspecialchars($category->getName()) ?></a></li>
        </ul>
        <?php endforeach; ?>
    </div>
</main>