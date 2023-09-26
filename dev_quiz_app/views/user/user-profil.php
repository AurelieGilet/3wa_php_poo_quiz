<main class="user-profil">
    <h1>Mon profil</h1>

    <?php if (isset($params['flashes'])) : ?>
    <ul>
        <?php foreach ($params['flashes'] as $flash) : ?>
            <?= $flash ?>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <div class="user-profil__container">
        <div>
            <p>Mon pseudo</p>
            <p><?= htmlspecialchars($params['user']->getAlias()) ?></p>
        </div>
    
        <div>
            <p>Mon email</p>
            <p><?= htmlspecialchars($params['user']->getEmail()) ?></p>
        </div>
        
        <div>
            <p>Mon mot de passe</p>
            <p>********</p>
        </div>
    </div>

    <a href="/profil-utilisateur/modifier" class="has-link-border">Modifier mes infos</a>
    <a href="/profil-utilisateur/supprimer" class="has-link-border">Supprimer mon compte</a>
</main>