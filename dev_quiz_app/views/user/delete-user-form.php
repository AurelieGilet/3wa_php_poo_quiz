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
    <h1>Supprimer mon compte</h1>

    <?php if (isset($params['flashes'])) : ?>
    <ul>
        <?php foreach ($params['flashes'] as $flash) : ?>
            <?= $flash ?>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <div class="clipped-container">
        <div class="form-instruction">
            <h3>Mise en garde</h3>
            <p>
                Si vous décidez de supprimer votre compte, toutes vos informations seront supprimées dans leur totalité.
            </p>
            <p>
                Cela inclus vos informations personnelles (alias, email, mot de passe) mais également tous vos scores.
            </p>
            <p>
                <strong>
                    Cette action est irréversible, il ne nous sera pas possible de récupérer les données supprimées !
                </strong>
            </p>
        </div>
    
        <form method="POST" action="/profil-utilisateur/supprimer">
            <div class="form-group">
                <label for="password">Validez la suppression avec votre mot de passe</label>
    
                <div class="clipped-input">
                    <input type="password" id="password" name="password" placeholder="Mot de passe">
                </div>
    
                <?php if (isset($formErrors['password'])) : ?>
                <ul class="error-message">
                    <?php foreach ($formErrors['password'] as $error) : ?>
                    <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
    
            <button type="submit" class="clipped-button">Valider</button>
        </form>
        
        <a href="/profil-utilisateur" class="abort-form has-link-border">retour</a>
    </div>
</main>