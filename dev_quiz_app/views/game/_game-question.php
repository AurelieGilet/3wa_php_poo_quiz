<div>
    <h2><?= $params['question']->getTitle() ?></h2>

    <?php foreach ($params['answers'] as $answer) : ?>
    <div>
        <input type="radio" id="answer<?= $answer->getId() ?>" name="answer" 
            value="<?= $answer->getContent() ?>">
        <label for="answer<?= $answer->getId() ?>"><?= $answer->getContent() ?></label>
    </div>
    <?php endforeach; ?>
</div>