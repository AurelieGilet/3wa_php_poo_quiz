<?php

if (isset($_SESSION['errors'])) {
    $formErrors = [];
    foreach ($_SESSION['errors'] as $errorsArray) {
        foreach ($errorsArray as $errors => $value) {
            $formErrors[$errors] = $value;
        }
    }

    // Delete errors to avoid stacking them if the page is recharged
    unset($_SESSION["errors"]);
}

// Uses array keys as variable name and values as variable values for each element of the array
if (isset($_SESSION['post'])) {
    extract($_SESSION['post']);
}

?>

<main>
    <h1>Modifier une question</h1>

    <?php if (isset($params['flashes'])) : ?>
    <ul>
        <?php foreach ($params['flashes'] as $flash) : ?>
            <?= $flash ?>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <form method="POST" action="/admin/question/modifier/<?= $params['question']->getId() ?>">
        <div>
            <label for="category">Catégorie de la question</label>

            <select id="category" name="category">
                <?php foreach ($params['categories'] as $cat) : ?>
                <option value="<?= $cat->getId() ?>" 
                    <?= $params['question']->getCategoryId() === $cat->getId()
                    || (isset($category) && $category == $cat->getId())
                    ? 'selected'
                    : '' ?>>
                    <?= htmlspecialchars($cat->getName()) ?>
                </option>
                <?php endforeach; ?>
            </select>

            <?php if (isset($formErrors['category'])) : ?>
            <ul>
                <?php foreach ($formErrors['category'] as $error) : ?>
                <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
        <div>
            <label for="title">Intitulé de la question</label>

            <input type="text" id="title" name="title" 
                value="<?= htmlspecialchars($params['question']->getTitle()) ?>">

            <?php if (isset($formErrors['title'])) : ?>
            <ul>
                <?php foreach ($formErrors['title'] as $error) : ?>
                <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>

        <?php if (isset($formErrors['answer'])) : ?>
        <ul>
            <?php foreach ($formErrors['answer'] as $error) : ?>
            <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <?php if (isset($formErrors['goodAnswer'])) : ?>
        <ul>
            <?php foreach ($formErrors['goodAnswer'] as $error) : ?>
            <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <?php for ($i = 1; $i < 5; $i++) : ?>
        <div>
            <div>
                <label for="answer<?= $i ?>">Réponse <?= $i ?></label>
                <input type="text" id="answer<?= $i ?>" 
                    name="<?= isset($params['answers'][$i - 1])
                    ? 'answer[' . $params['answers'][$i - 1]->getId() . '][content]'
                    : 'answer[newAnswer' . $i . '][content]' ?>"

                    value="<?php
                    if (isset($params['answers'][$i - 1])
                        && isset($answer[$params['answers'][$i - 1]->getId()])) {
                        echo htmlspecialchars($answer[$params['answers'][$i - 1]->getId()]['content']);
                    } elseif (isset($answer['newAnswer' . $i]['content'])) {
                        echo htmlspecialchars($answer['newAnswer' . $i]['content']);
                    } elseif (isset($params['answers'][$i - 1])) {
                        echo htmlspecialchars($params['answers'][$i - 1]->getContent());
                    } else {
                        echo '';
                    }
                    ?>">
            </div>

            <div>
                <label for="goodAnswer<?= $i ?>">Est-ce la bonne réponse ?</label>

                <input type="checkbox" id="goodAnswer<?= $i ?>"
                    name="<?= isset($params['answers'][$i - 1])
                    ? 'answer[' . $params['answers'][$i - 1]->getId() . '][goodAnswer]'
                    : 'answer[newAnswer' . $i .'][goodAnswer]' ?>"

                    <?php
                    if (isset($params['answers'][$i - 1])
                        && isset($answer[$params['answers'][$i - 1]->getId()]['goodAnswer'])) {
                        echo 'checked';
                    } elseif (isset($answer['newAnswer' . $i]['goodAnswer'])) {
                        echo 'checked';
                    } elseif ((isset($params['answers'][$i - 1])
                        && !isset($answer[$params['answers'][$i - 1]->getId()]))
                        && isset($params['answers'][$i - 1])
                        && $params['answers'][$i - 1]->getIsGoodAnswer()) {
                        echo 'checked';
                    } else {
                        echo '';
                    }
                    ?>>
            </div>
        </div>
        <?php endfor; ?>

        <button type="submit">Valider</button>
    </form>

    <a href="/admin/questions">retour</a>
</main>