<main>
    <h1>Mes scores</h1>

    <div>
        <ul>
            <?php foreach ($params['categories'] as $category) : ?>
            <li>
                <button data-controls="user-score-filter" data-category-id="<?= $category->getId() ?>"
                    class="<?= $params['activeCategory'] === $category->getId() ? 'active' :'' ?>">
                    <?= htmlspecialchars($category->getName()) ?>
                </button>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div id="category-scores">
        <?php include('_category-scores.php'); ?>
    </div>

</main>