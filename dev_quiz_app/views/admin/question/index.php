<?php
//TODO: change button style for active category being displayed
var_dump('catégorie active', $params['activeCategory']);
?>

<main>
    <h1>Gestion des questions</h1>

    <?php if (isset($params['flashes'])) : ?>
        <ul>
        <?php foreach ($params['flashes'] as $flash) : ?>
            <?= $flash ?>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <a href="/admin/question/ajouter">Ajouter une question</a>

    <div>
        <ul>
        <?php foreach ($params['categories'] as $category) : ?>
            <li>
                <button data-controls="category-filter" data-category-id="<?= $category->getId() ?>"
                    class="<?= $params['activeCategory'] === $category->getId() ? 'active' :'' ?>">
                    <?= htmlspecialchars($category->getName()) ?>
                </button>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>

    <div id="category-questions">
        <?php include('_category-questions.php'); ?>
    </div>

</main>