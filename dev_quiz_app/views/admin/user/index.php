<main>
    <h1>Gestion des utilisateurs</h1>

    <?php if (isset($params['flashes'])) : ?>
    <ul>
        <?php foreach ($params['flashes'] as $flash) : ?>
            <?= $flash ?>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <div class="clipped-container large">
        <table class="table">
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
                    <td data-title="Id"><?= htmlspecialchars($user->getId()) ?></td>
                    <td data-title="Pseudo" data-truncate="true"><?= htmlspecialchars($user->getAlias()) ?></td>
                    <td data-title="Email" data-truncate="true"><?= htmlspecialchars($user->getEmail()) ?></td>
                    <td data-title="Role"><?= htmlspecialchars($user->getRole()) ?></td>
                    <td class="option">
                        <a href="/admin/utilisateur/modifier/<?= $user->getId() ?>">
                            <span class="link is-hidden-md">Modifier</span>
                            <span class="icon-pencil is-visible-md"></span>
                        </a>
                    </td>
                    <td class="option">
                        <a href="/admin/utilisateur/supprimer/<?= $user->getId() ?>">
                            <span class="link is-hidden-md">Supprimer</span>
                            <span class="icon-bin is-visible-md"></span>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
