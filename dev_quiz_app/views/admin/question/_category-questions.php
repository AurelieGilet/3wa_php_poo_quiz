
<table>
    <tbody>
        <?php $i = 1; ?>
        <?php foreach ($params['questions'] as $question) : ?>
        <tr>
            <td>Question <?= $i ?></td>
            <td>
                <a href="/admin/question/modifier/<?= $question->getId() ?>">Modifier</a>
            </td>
            <td>
                <a href="/admin/question/supprimer/<?= $question->getId() ?>">Supprimer</a>
            </td>
        </tr>

        <tr>
            <td colspan="3"><?= htmlspecialchars($question->getTitle()) ?></td>
        </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
    </tbody>
</table>