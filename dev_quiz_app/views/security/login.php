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
    <h1>Connexion</h1>

    <?php if (isset($params['flashes'])) : ?>
    <ul>
        <?php foreach ($params['flashes'] as $flash) : ?>
            <?= $flash ?>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
    
    <form method="POST" action="/connexion">
        <div>
            <label for="email">Email</label>

            <input type="email" id="email" name="email">

            <?php if (isset($formErrors['email'])) : ?>
            <ul>
                <?php foreach ($formErrors['email'] as $error) : ?>
                <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>

        <div>
            <label for="password">Mot de passe</label>

            <?php /*TODO: don't forget to change back input type to password*/ ?>
            <input type="text" id="password" name="password">

            <?php if (isset($formErrors['password'])) : ?>
            <ul>
                <?php foreach ($formErrors['password'] as $error) : ?>
                <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
        
        <button type="submit">Se connecter</button>
    </form>
</main>