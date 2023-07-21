<?php

if (isset($_SESSION['errors'])) {
    $formErrors = [];
    foreach ($_SESSION['errors'] as $errorsArray) {
        foreach ($errorsArray as $errors => $value) {
            $formErrors[$errors] = $value;
        }
    }

    // Delete errors to avoid stacking them if the page is recharged
    session_destroy();
}

?>

<main>
    <h1>Connexion</h1>
    
    <form action="/connexion" method="post">
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
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
            <input type="password" name="password" id="password">
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