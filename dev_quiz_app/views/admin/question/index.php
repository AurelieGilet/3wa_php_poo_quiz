<main>
    <h1>Gestion des questions</h1>

    <?php if (isset($params['flashes'])) : ?>
        <ul>
        <?php foreach ($params['flashes'] as $flash) : ?>
            <?= $flash ?>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <a href="/admin/question/ajouter">Ajouter une question</a>

    <div>
        <ul>
            <?php foreach ($params['questions'] as $question) : ?>
                <li><?= htmlspecialchars($question->getTitle()) ?></li>
                <li><a href="/admin/question/modifier/<?= $question->getId() ?>">Modifier</a></li>
                <li>
                    <form action="/admin/question/supprimer/<?= $question->getId() ?>" method="POST">
                        <button type="submit">Supprimer</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</main>