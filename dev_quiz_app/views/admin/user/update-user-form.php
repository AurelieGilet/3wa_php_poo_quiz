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
        Modifier un utilisateur
    </h1>

    <?php if (isset($params['flashes'])) : ?>
        <ul>
        <?php foreach ($params['flashes'] as $flash) : ?>
            <?= $flash ?>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" action="/admin/utilisateur/modifier/<?= $params['user']->getId() ?>">
        <div>
            <label for="alias">Modifier le pseudo</label>
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
            <label for="email">Modifier l'email</label>
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
            <label for="email">Modifier le role</label>
            <p>
                Attention, passer un utilisateur en administrateur lui donnera accès au back-office et 
                l’empêchera de jouer aux quiz.
            </p>
            <select name="role" id="role">
                <option value="user" <?= $params['user']->getRole() === 'user' ? 'selected' : ''  ?> >
                    Utilisateur
                </option>
                <option value="admin" <?= $params['user']->getRole() === 'admin' ? 'selected' : '' ?> >
                    Administrateur
                </option>
            </select>
            <?php if (isset($formErrors['role'])) : ?>
            <ul>
                <?php foreach ($formErrors['role'] as $error) : ?>
                <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
        <div>
            <label for="adminPassword">Confirmez les modifications avec votre mot de passe administrateur</label>
            <?php /*TODO: don't forget to change back input type to password*/ ?>
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
    <a href="/admin/utilisateurs">retour</a>
</main>