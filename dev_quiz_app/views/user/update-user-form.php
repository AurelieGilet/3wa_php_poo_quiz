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

<main class="user-profil-update">
    <h1>Modifier mes informations</h1>

    <?php if (isset($params['flashes'])) : ?>
    <ul>
        <?php foreach ($params['flashes'] as $flash) : ?>
            <?= $flash ?>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <div class="clipped-container">
        <form method="POST" action="/profil-utilisateur/modifier" class="form">
            <div class="form-group">
                <label for="alias">Modifier mon pseudo</label>
    
                <div class="clipped-input">
                    <input type="text" id="alias" name="alias"
                        value="<?= isset($params['user']) ? htmlspecialchars($params['user']->getAlias()) : '' ?>">
                </div>
    
                <?php if (isset($formErrors['alias'])) : ?>
                <ul class="error-message">
                    <?php foreach ($formErrors['alias'] as $error) : ?>
                    <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
    
            <div class="form-group">
                <label for="email">Modifier mon email</label>
    
                <div class="clipped-input">
                    <input type="text" id="email" name="email"
                        value="<?= isset($params['user']) ? htmlspecialchars($params['user']->getEmail()) : '' ?>">
                </div>
    
                <?php if (isset($formErrors['email'])) : ?>
                <ul class="error-message">
                    <?php foreach ($formErrors['email'] as $error) : ?>
                    <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
    
            <div class="form-group">
                <p class="main-label">Modifier mon mot de passe</p>
                <small class="instruction">
                    Ne remplissez ces champs que si vous souhaitez modifier votre mot de passe
                </small>
    
                <div class="form-group">
                    <label for="password">Nouveau mot de passe</label>
        
                    <div class="clipped-input">
                        <input type="password" id="password" name="password">
                    </div>
                </div>
    
                <div class="form-group">
                    <label for="passwordRepeat">Confirmez le nouveau mot de passe</label>
    
                    <div class="clipped-input">
                        <input type="password" id="passwordRepeat" name="passwordRepeat">
                    </div>
                </div>
    
                <?php if (isset($formErrors['password'])) : ?>
                <ul class="error-message">
                    <?php foreach ($formErrors['password'] as $error) : ?>
                    <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
    
            <div class="form-group">
                <label for="passwordOld" class="main-label">
                    Confirmez les modifications avec votre mot de passe actuel
                </label>
    
                <div class="clipped-input">
                    <input type="password" id="passwordOld" name="passwordOld" placeholder="Mot de passe">
                </div>
    
                <?php if (isset($formErrors['passwordOld'])) : ?>
                <ul class="error-message">
                    <?php foreach ($formErrors['passwordOld'] as $error) : ?>
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