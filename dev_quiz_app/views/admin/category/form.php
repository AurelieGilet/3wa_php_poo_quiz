<?php

if (isset($_SESSION['errors'])) {
    $formErrors = [];
    foreach ($_SESSION['errors'] as $errorsArray) {
        foreach ($errorsArray as $errors => $value) {
            $formErrors[$errors] = $value;
        }
    }

    // Delete errors to avoid stacking them if the page is recharged
    session_destroy();
}

?>

<main>
    <h1>
        <?= isset($params['category']->name)
            ? 'Modifier la catégorie ' . $params['category']->name
            : 'Ajouter une catégorie' ?>
    </h1>

    <form method="POST"
        action="<?= isset($params['category'])
            ? '/admin/categorie/modifier/' . $params['category']->id
            : '/admin/categorie/ajouter'?>">
        <div>
            <label for="name">Nom de la catégorie</label>
            <input type="text" name="name" id="name" value="<?= $params['category']->name ?? '' ?>">
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
</main>