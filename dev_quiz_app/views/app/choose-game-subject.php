<main>
    <h1>Choisir un sujet</h1>
    <div>
        <?php foreach ($params['categories'] as $category) : ?>
        <ul>
            <li class="clipped-button">
                <a href="/jeu/categorie/<?= $category->getId() ?>" class="stretched-link">
                    <?= htmlspecialchars($category->getName()) ?>
                </a>
            </li>
        </ul>
        <?php endforeach; ?>
    </div>
</main>