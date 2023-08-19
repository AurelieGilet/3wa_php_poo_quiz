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

    <p>
        Mise en garde : <br>
        Si vous décidez de supprimer votre compte, toutes vos informations seront supprimées dans leur totalité. <br>
        Cela inclus vos informations personnelles (alias, email, mot de passe) mais également tous vos scores. <br>
        <strong>
            Cette action est irréversible, il ne nous sera pas possible de récupérer les données supprimées !
        </strong>
    </p>

    <form method="POST" action="/profil-utilisateur/supprimer">
        <div>
            <label for="password">Validez la suppression avec votre mot de passe</label>

            <input type="text" id="password" name="password">

            <?php if (isset($formErrors['password'])) : ?>
            <ul>
                <?php foreach ($formErrors['password'] as $error) : ?>
                <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>

        <button type="submit">Valider</button>
    </form>
    
    <a href="/profil-utilisateur">retour</a>
</main>