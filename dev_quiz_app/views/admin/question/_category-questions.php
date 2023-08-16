<?php foreach ($params['questions'] as $question) : ?>
<ul>
    <li><?= htmlspecialchars($question->getTitle()) ?></li>
    <li><a href="/admin/question/modifier/<?= $question->getId() ?>">Modifier</a></li>
    <li>
        <form action="/admin/question/supprimer/<?= $question->getId() ?>" method="POST">
            <button type="submit">Supprimer</button>
        </form>
    </li>
</ul>
<?php endforeach; ?>
