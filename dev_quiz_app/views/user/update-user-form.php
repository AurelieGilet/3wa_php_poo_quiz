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
        Modifier mes informations
    </h1>

    <?php if (isset($params['flashes'])) : ?>
        <ul>
        <?php foreach ($params['flashes'] as $flash) : ?>
            <?= $flash ?>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" action="/profil-utilisateur/modifier">
        <div>
            <label for="alias">Modifier mon pseudo</label>
            <input type="text" name="alias" id="alias" 
                value="<?= isset($params['user']) ? htmlspecialchars($params['user']->getAlias()) : '' ?>">
            <?php if (isset($formErrors['alias'])) : ?>
                <ul>
                <?php foreach ($formErrors['alias'] as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <div>
            <label for="email">Modifier mon email</label>
            <input type="text" name="email" id="email" 
                value="<?= isset($params['user']) ? htmlspecialchars($params['user']->getEmail()) : '' ?>">
            <?php if (isset($formErrors['email'])) : ?>
                <ul>
                <?php foreach ($formErrors['email'] as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <div>
            <p>Modifier mon mot de passe</p>
            <p>Ne remplissez ces champs que si vous souhaitez modifier votre mot de passe</p>
            <?php /*TODO: don't forget to change back input type to password*/ ?>
            <label for="password">Nouveau mot de passe</label>
            <input type="text" name="password" id="password">
            <label for="passwordRepeat">Confirmez le nouveau mot de passe</label>
            <input type="text" name="passwordRepeat" id="passwordRepeat">
            <?php if (isset($formErrors['password'])) : ?>
                <ul>
                <?php foreach ($formErrors['password'] as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <div>
            <label for="passwordOld">Confirmez les modifications avec votre mot de passe actuel</label>
            <input type="text" name="passwordOld" id="passwordOld">
            <?php if (isset($formErrors['passwordOld'])) : ?>
                <ul>
                <?php foreach ($formErrors['passwordOld'] as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <button type="submit">Valider</button>
    </form>
    <a href="/profil-utilisateur">retour</a>
</main>