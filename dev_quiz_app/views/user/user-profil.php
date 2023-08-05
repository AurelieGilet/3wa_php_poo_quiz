<main>
    <h1>Mon profil</h1>

    <?php if (isset($params['flashes'])) : ?>
        <ul>
        <?php foreach ($params['flashes'] as $flash) : ?>
            <?= $flash ?>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <div>
        <p>Mon pseudo</p>
        <p><?=  $params['user']->getAlias() ?></p>
    </div>
    <div>
        <p>Mon email</p>
        <p><?=  $params['user']->getEmail() ?></p>
    </div>
    <div>
        <p>Mon mot de passe</p>
        <p>********</p>
    </div>

    <a href="/profil-utilisateur/modifier">Modifier mes infos</a>
    <a href="">Supprimer mon compte</a>
</main>