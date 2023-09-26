<main class="user-score">
    <h1>Mes scores</h1>

    <div class="user-score__container">
        <!-- Mobile -->
        <div id="custom-select" class="custom-select__wrapper is-hidden-lg">
            <div class="custom-select">
                <div class="custom-select__trigger"><span>HTML</span>
                    <div class="arrow"></div>
                </div>
                <ul class="custom-select__options">
                    <?php foreach ($params['categories'] as $category) : ?>
                    <li data-controls="user-score-filter" data-category-id="<?= $category->getId() ?>" 
                        class="select-option <?= $params['activeCategory'] === $category->getId() ? 'selected' :'' ?>">
                        <?= htmlspecialchars($category->getName()) ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    
        <!-- Desktop -->
        <div class="is-visible-lg">
            <ul>
                <?php foreach ($params['categories'] as $category) : ?>
                <li data-component="category-filter" 
                    data-controls="user-score-filter" 
                    data-category-id="<?= $category->getId() ?>" 
                    class="clipped-button <?= $params['activeCategory'] === $category->getId() ? 'active' :'' ?>">
                    <?= htmlspecialchars($category->getName()) ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    
        <!-- Mobile lines (svg) -->
        <span class="icon-lines is-hidden-lg"></span>

        <!-- Desktop lines (js canvas) -->
        <div id="canvas" class="canvas is-visible-lg"></div>

        <!-- Scores -->
        <div id="category-scores" class="score-billboard clipped-container">
            <?php include('_category-scores.php'); ?>
        </div>
    </div>

</main>