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
        Supprimer un utilisateur
    </h1>

    <?php if (isset($params['flashes'])) : ?>
        <ul>
        <?php foreach ($params['flashes'] as $flash) : ?>
            <?= $flash ?>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <p>
        Mise en garde : <br>
        Vous vous apprêtez à supprimer le compte de l'utilisateur 
        <strong><?= htmlspecialchars($params['user']->getAlias()) ?></strong> <br>
        Si vous décidez de supprimer ce compte, 
        toutes les informations de l'utilisateur seront supprimées dans leur totalité. <br>
        Cela inclus les informations personnelles (alias, email, mot de passe) mais également tous les scores. <br>
        <strong>
            Cette action est irréversible, il ne sera pas possible de récupérer les données supprimées !
        </strong>
    </p>

    <form method="POST" action="/admin/utilisateur/supprimer/<?= $params['user']->getId() ?>">
        <div>
            <label for="adminPassword">Validez la suppression avec le mot de passe administrateur</label>
            <input type="text" name="adminPassword" id="adminPassword">
            <?php if (isset($formErrors['adminPassword'])) : ?>
                <ul>
                <?php foreach ($formErrors['adminPassword'] as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <button type="submit">Valider</button>
    </form>
    <a href="/profil-utilisateur">retour</a>
</main>