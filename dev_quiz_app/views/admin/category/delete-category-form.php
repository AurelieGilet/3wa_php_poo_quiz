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
    <h1>Supprimer une catégorie</h1>

    <?php if (isset($params['flashes'])) : ?>
    <ul>
        <?php foreach ($params['flashes'] as $flash) : ?>
            <?= $flash ?>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <p>
        Êtes-vous sûr de vouloir supprimer cette catégorie ? <br>
        <strong><?= htmlspecialchars($params['category']->getName()) ?></strong> <br>

        <?php if ($params['questions']) : ?>
        Toutes les questions associées seront également supprimées : <br>
            <?php foreach ($params['questions'] as $question) : ?>
            <strong><?= htmlspecialchars($question->getTitle()) ?></strong> <br>
            <?php endforeach; ?>
        Si vous souhaitez conserver ces questions, vous devrez d'abord les associer à une nouvelle catégorie.
        <?php endif; ?>
    </p>

    <form method="POST" action="/admin/categorie/supprimer/<?= $params['category']->getId() ?>">
        <div>
            <label for="adminPassword">Validez la suppression avec le mot de passe administrateur</label>

            <input type="text" id="adminPassword" name="adminPassword">

            <?php if (isset($formErrors['adminPassword'])) : ?>
            <ul>
                <?php foreach ($formErrors['adminPassword'] as $error) : ?>
                <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>

        <button type="submit">Valider</button>
    </form>

    <a href="/admin/categories">retour</a>
</main>