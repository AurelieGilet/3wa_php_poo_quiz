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
    <h1>Inscription</h1>
    
    <form method="POST" action="/inscription">
        <div>
            <label for="email">Email</label>

            <input type="text" id="email" name="email">

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

        <button type="submit">S'inscrire</button>
    </form>
</main>