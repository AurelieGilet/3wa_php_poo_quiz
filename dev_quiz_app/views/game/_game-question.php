<div class="form">
    <p class="form-instruction"><?= htmlspecialchars($params['question']->getTitle()) ?></p>

    <?php foreach ($params['answers'] as $answer) : ?>
    <div class="clipped-input">
        <input type="radio" id="answer<?= $answer->getId() ?>" name="answer" 
            value="<?= $answer->getId() ?>">
        <label for="answer<?= $answer->getId() ?>"><?= htmlspecialchars($answer->getContent()) ?></label>
    </div>
    <?php endforeach; ?>
    <p id="errors" class="error-message"></p>
</div>
<div id="game-progress" class="game__progress" 
    data-progress="<?= htmlspecialchars($_SESSION['questionIndex']) ?>">
    Question <?= htmlspecialchars($_SESSION['questionIndex'] + 1) ?>/10
</div>