<main>
    <h1>Gestion des utilisateurs</h1>

    <?php if (isset($params['flashes'])) : ?>
        <ul>
        <?php foreach ($params['flashes'] as $flash) : ?>
            <?= $flash ?>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <div>
        <ul>
            <?php foreach ($params['users'] as $user) : ?>
                <li><?= htmlspecialchars($user->getId()) ?></li>
                <li><?= htmlspecialchars($user->getAlias()) ?></li>
                <li><?= htmlspecialchars($user->getEmail()) ?></li>
                <li><?= htmlspecialchars($user->getRole()) ?></li>
                <li><a href="/admin/utilisateur/modifier/<?= $user->getId() ?>">Modifier</a></li>
                <li>
                    <form action="/admin/utilisateur/supprimer/<?= $user->getId() ?>" method="POST">
                        <button type="submit">Supprimer</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</main>