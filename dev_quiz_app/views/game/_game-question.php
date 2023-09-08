<div>
    <h2><?= htmlspecialchars($params['question']->getTitle()) ?></h2>

    <?php foreach ($params['answers'] as $answer) : ?>
    <div>
        <input type="radio" id="answer<?= $answer->getId() ?>" name="answer" 
            value="<?= $answer->getId() ?>">
        <label for="answer<?= $answer->getId() ?>"><?= htmlspecialchars($answer->getContent()) ?></label>
    </div>
    <?php endforeach; ?>
    <p id="errors"></p>
</div>
<div id="game-progress" data-progress="<?= htmlspecialchars($_SESSION['questionIndex']) ?>">
    Question <?= htmlspecialchars($_SESSION['questionIndex'] + 1) ?>/10
</div>