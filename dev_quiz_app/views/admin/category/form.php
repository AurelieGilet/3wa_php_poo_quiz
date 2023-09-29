<?php

if (isset($_SESSION['errors'])) {
    $formErrors = [];
    foreach ($_SESSION['errors'] as $errorsArray) {
        foreach ($errorsArray as $errors => $value) {
            $formErrors[$errors] = $value;
        }
    }

    // Delete errors to avoid stacking them if the page is recharged
    unset($_SESSION["errors"]);
}

?>

<main>
    <h1>
        <?= isset($params['category']) && $params['category']->getName() !== null
            ? 'Modifier la catégorie ' . htmlspecialchars($params['category']->getName())
            : 'Ajouter une catégorie' ?>
    </h1>

    <div class="clipped-container">
        <form method="POST"
            action="<?= isset($params['category'])
                ? '/admin/categorie/modifier/' . $params['category']->getId()
                : '/admin/categorie/ajouter'?>"
            class="form">
            <div class="form-group">
                <?php if (isset($params['category'])) : ?>
                <p class="form-instruction">
                    Attention, la modification de cette catégorie sera appliquée à toutes
                    les questions qui lui sont associées.
                </p>
                <?php endif; ?>
                
                <label for="name">Nom de la catégorie</label>
    
                <div class="clipped-input">
                    <input type="text" id="name" name="name"
                        value="<?= isset($params['category'])
                        ? htmlspecialchars($params['category']->getName())
                        : '' ?>">
                </div>
    
                <?php if (isset($formErrors['name'])) : ?>
                <ul class="error-message">
                    <?php foreach ($formErrors['name'] as $error) : ?>
                    <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
    
            <button type="submit" class="clipped-button">
                Valider
            </button>
        </form>
    
        <a href="/admin/categories" class="abort-form has-link-border">
            retour
        </a>
    </div>
</main>