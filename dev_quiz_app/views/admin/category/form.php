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

    <form method="POST"
        action="<?= isset($params['category'])
            ? '/admin/categorie/modifier/' . $params['category']->getId()
            : '/admin/categorie/ajouter'?>">
        <div>
            <?php if (isset($params['category'])) : ?>
            <p>
                Attention, la modification de cette catégorie sera appliquée à toutes
                les questions qui lui sont associées.
            </p>
            <?php endif; ?>
            
            <label for="name">Nom de la catégorie</label>

            <input type="text" id="name" name="name"
                value="<?= isset($params['category'])
                ? htmlspecialchars($params['category']->getName())
                : '' ?>">

            <?php if (isset($formErrors['name'])) : ?>
            <ul>
                <?php foreach ($formErrors['name'] as $error) : ?>
                <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>

        <button type="submit">Valider</button>
    </form>

    <a href="/admin/categories">retour</a>
</main>