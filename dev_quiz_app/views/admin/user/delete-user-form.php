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
    <h1>Supprimer un utilisateur</h1>

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
                Vous vous apprêtez à supprimer le compte de l'utilisateur 
                <strong><?= htmlspecialchars($params['user']->getAlias()) ?></strong>
            </p>
            <p>
                Si vous décidez de supprimer ce compte, 
                toutes les informations de l'utilisateur seront supprimées dans leur totalité.
            </p>
            <p>
                Cela inclus les informations personnelles (alias, email, mot de passe) mais également tous les scores.
            </p>
            <p>
                <strong>
                    Cette action est irréversible, il ne sera pas possible de récupérer les données supprimées !
                </strong>
            </p>
        </div>

        <form method="POST" action="/admin/utilisateur/supprimer/<?= $params['user']->getId() ?>"
            class="form">
            <div class="form-group">
                <label for="adminPassword">Validez la suppression avec le mot de passe administrateur</label>
    
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
    
            <button type="submit" class="clipped-button">Valider</button>
        </form>
        
        <a href="/admin/utilisateurs" class="abort-form has-link-border">retour</a>
    </div>
</main>