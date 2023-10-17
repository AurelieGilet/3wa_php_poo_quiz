<main class="admin-message">
    <h1>Messagerie</h1>

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
                    <th>Reçu le</th>
                    <th>Email contact</th>
                    <th>Message</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($params['messages'] as $message) : ?>
                <tr>
                    <td data-title="Reçu le">
                        <?= date('m/d/y à H:m', strtotime($message->getCreatedAt())) ?>
                    </td>
                    <td data-title="Email contact" data-truncate="true">
                        <?= !empty($message->getEmail()) ? htmlspecialchars($message->getEmail()) : 'aucun' ?>
                    </td>
                    <td data-title="Message" class="message">
                        <?= htmlspecialchars($message->getContent()) ?>
                    </td>
                    <td class="option" colspan="2">
                        <a href="/admin/message/supprimer/<?= $message->getId() ?>">
                            <span class="link is-hidden-md">Supprimer</span>
                            <span class="icon-bin is-visible-md" aria-label="Supprimer le message"></span>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ($params['totalPages'] > 1) : ?>
        <div class="pagination">
            <a href="/admin/messagerie?page=<?= $params['currentPage'] <= 1 ? 1 :  $params['currentPage'] - 1 ?>">
                <span class="icon-prev"></span>
            </a>
            <span>
                <?= $params['currentPage'] ?> sur <?= $params['totalPages'] ?>
            </span>
            <a href="/admin/messagerie?page=<?= $params['currentPage'] >= $params['totalPages'] ? $params['totalPages'] : $params['currentPage'] + 1 ?>">
                <span class="icon-next"></span>
            </a>
        </div>
        <?php endif; ?>
    </div>
</main>