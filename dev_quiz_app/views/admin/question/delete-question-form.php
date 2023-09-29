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
    <h1>Supprimer une question</h1>

    <?php if (isset($params['flashes'])) : ?>
    <ul>
        <?php foreach ($params['flashes'] as $flash) : ?>
            <?= $flash ?>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <div class="clipped-container">
        <div class="form-instruction">
            <h3>Mise en garde :</h3>
            <p>
                Vous vous apprêtez à supprimer la question suivante : <br>
                <strong><?= htmlspecialchars($params['question']->getTitle()) ?></strong> <br>
            </p>
            <p class="warning">
                Toutes les réponses associées seront également supprimées :
            </p>
            <?php foreach ($params['answers'] as $answer) : ?>
            <p><?= htmlspecialchars($answer->getContent()) ?></p>
            <?php endforeach; ?>
        </div>
    
        <form method="POST" action="/admin/question/supprimer/<?= $params['question']->getId() ?>"
            class="form">
            <div class="form-group">
                <label for="adminPassword">
                    Validez la suppression avec le mot de passe administrateur
                </label>
    
                <div class="clipped-input">
                    <input type="text" id="adminPassword" name="adminPassword">
                </div>
    
                <?php if (isset($formErrors['adminPassword'])) : ?>
                <ul class="error-message">
                    <?php foreach ($formErrors['adminPassword'] as $error) : ?>
                    <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
    
            <button type="submit" class="clipped-button">
                Valider
            </button>
        </form>
    
        <a href="/admin/questions" class="abort-form has-link-border">
            retour
        </a>
    </div>
</main>