<main>
    <h1>Gestion des utilisateurs</h1>

    <?php if (isset($params['flashes'])) : ?>
        <ul>
        <?php foreach ($params['flashes'] as $flash) : ?>
            <?= $flash ?>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Pseudo</th>
                <th>Email</th>
                <th>Role</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($params['users'] as $user) : ?>
            <tr>
                <td><?= htmlspecialchars($user->getId()) ?></td>
                <td><?= htmlspecialchars($user->getAlias()) ?></td>
                <td><?= htmlspecialchars($user->getEmail()) ?></td>
                <td><?= htmlspecialchars($user->getRole()) ?></td>
                <td>
                    <a href="/admin/utilisateur/modifier/<?= $user->getId() ?>">Modifier</a>
                </td>
                <td>
                <a href="/admin/utilisateur/supprimer/<?= $user->getId() ?>">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>