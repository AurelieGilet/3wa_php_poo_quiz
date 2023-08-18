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

    <form method="POST"
        action="/admin/question/modifier/<?= $params['question']->getId() ?>">
        <div>
            <label for="category">Catégorie de la question</label>
            <select name="category" id="category">
                <?php foreach ($params['categories'] as $category) : ?>
                <option value="<?= $category->getId() ?>" 
                    <?= $params['question']->getCategoryId() === $category->getId() ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category->getName()) ?>
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
            <input type="text" name="title" id="title" 
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
                <input type="text" name="answer[<?= $i ?>]" id="answer<?= $i ?>" 
                    value="<?= isset($params['answers'][$i - 1])
                    ? htmlspecialchars($params['answers'][$i - 1]->getContent())
                    : '' ?>">
            </div>
            <div>
                <label for="goodAnswer<?= $i ?>">Est-ce la bonne réponse ?</label>
                <input type="checkbox" name="goodAnswer[<?= $i ?>]" id="goodAnswer<?= $i ?>"
                    <?= isset($params['answers'][$i - 1]) && $params['answers'][$i - 1]->getIsGoodAnswer()
                    ? 'checked'
                    : '' ?>/>
            </div>
        </div>
        <?php endfor; ?>
        <button type="submit">Valider</button>
    </form>
    <a href="/admin/questions">retour</a>
</main>