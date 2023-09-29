<?php if (count($params['questions']) === 0) : ?>
<p class="is-centered">Pas encore de question pour cette catégorie</p>
<?php endif; ?>

<table>
    <tbody>
        <?php $i = 1; ?>
        <?php foreach ($params['questions'] as $question) : ?>
        <tr>
            <td class="is-family-primary is-light-bold">Question <?= $i ?></td>
            <td class="option">
                <a href="/admin/question/modifier/<?= $question->getId() ?>">
                    <span class="link is-visible-lg">Modifier</span>
                    <span class="icon-pencil is-hidden-lg" aria-label="Modifier la question"></span>
                </a>
            </td>
            <td class="option">
                <a href="/admin/question/supprimer/<?= $question->getId() ?>">
                    <span class="link is-visible-lg">Supprimer</span>
                    <span class="icon-bin is-hidden-lg" aria-label="Supprimer la question"></span>
                </a>
            </td>
        </tr>

        <tr>
            <td colspan="3"><?= htmlspecialchars($question->getTitle()) ?></td>
        </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
    </tbody>
</table>