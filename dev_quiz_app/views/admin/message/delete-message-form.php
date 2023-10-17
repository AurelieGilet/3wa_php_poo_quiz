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
    <h1>Supprimer un message</h1>

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
                Vous vous apprêtez à supprimer le message suivant :
            </p>
            <p>
                <strong>Reçu le :</strong>  
                <?= date('m/d/y', strtotime($params['message']->getCreatedAt())) ?>
            </p>
            <p>
                <strong>Email de contact :</strong>  
                <?= !empty($params['message']->getEmail()) ? htmlspecialchars($params['message']->getEmail()) : 'aucun' ?>
            </p>
            <p><strong>Message :</strong> <?= htmlspecialchars($params['message']->getContent()) ?></p>

            <p class="warning">
                Toute suppression est définitive !
            </p>
        </div>
    
        <form method="POST" action="/admin/message/supprimer/<?= $params['message']->getId() ?>"
            class="form">
            <div class="form-group">
                <label for="adminPassword">
                    Validez la suppression avec le mot de passe administrateur
                </label>
    
                <div class="clipped-input">
                    <input type="password" id="adminPassword" name="adminPassword">
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
    
        <a href="/admin/messagerie" class="abort-form has-link-border">
            retour
        </a>
    </div>
</main>