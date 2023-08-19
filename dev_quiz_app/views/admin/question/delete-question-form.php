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
        Supprimer une question
    </h1>

    <?php if (isset($params['flashes'])) : ?>
        <ul>
        <?php foreach ($params['flashes'] as $flash) : ?>
            <?= $flash ?>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <p>
        Êtes-vous sûr de vouloir supprimer cette question ? <br>
        <strong><?= htmlspecialchars($params['question']->getTitle()) ?></strong> <br>
        Toutes les réponses associées seront également supprimées : <br>
        <?php foreach ($params['answers'] as $answer) : ?>
        <strong><?= htmlspecialchars($answer->getContent()) ?></strong> <br>
        <?php endforeach; ?>
    </p>

    <form method="POST" action="/admin/question/supprimer/<?= $params['question']->getId() ?>">
        <div>
            <label for="adminPassword">Validez la suppression avec le mot de passe administrateur</label>
            <input type="text" name="adminPassword" id="adminPassword">
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
    <a href="/admin/questions">retour</a>
</main>