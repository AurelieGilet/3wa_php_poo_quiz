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

<main class="admin-user-form">
    <h1>Modifier un utilisateur</h1>

    <?php if (isset($params['flashes'])) : ?>
    <ul>
        <?php foreach ($params['flashes'] as $flash) : ?>
            <?= $flash ?>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <div class="clipped-container">
        <form method="POST" action="/admin/utilisateur/modifier/<?= $params['user']->getId() ?>"
            class="form">
            <div class="form-group">
                <label for="alias">
                    Modifier le pseudo
                </label>
    
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
                <label for="email">Modifier l'email</label>
    
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
                <label for="email">Modifier le role</label>
    
                <p class="form-instruction">
                    Attention, passer un utilisateur en administrateur lui donnera accès au back-office et 
                    l’empêchera de jouer aux quiz.
                </p>
    
                <div class="clipped-input">
                    <select id="role"name="role">
                        <option value="user" <?= $params['user']->getRole() === 'user' ? 'selected' : ''  ?>>
                            Utilisateur
                        </option>
                        <option value="admin" <?= $params['user']->getRole() === 'admin' ? 'selected' : '' ?>>
                            Administrateur
                        </option>
                    </select>
                </div>
    
                <?php if (isset($formErrors['role'])) : ?>
                <ul class="error-message">
                    <?php foreach ($formErrors['role'] as $error) : ?>
                    <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
    
            <div class="form-group">
                <label for="adminPassword">
                    Confirmez les modifications avec votre mot de passe administrateur
                </label>

                <div class="clipped-input">
                    <input type="password" id="adminPassword" name="adminPassword">
                </div>
    
                <?php if (isset($formErrors['adminPassword'])) : ?>
                <ul class="error-message">
                    <?php foreach ($formErrors['adminPassword'] as $error) : ?>
                    <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
    
            <button type="submit" class="clipped-button">
                Valider
            </button>
        </form>
        
        <a href="/admin/utilisateurs" class="abort-form has-link-border">
            retour
        </a>
    </div>
</main>