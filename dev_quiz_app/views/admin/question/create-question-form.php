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
// Is used to repopulate the form inputs values in case of errors
if (isset($_SESSION['post'])) {
    extract($_SESSION['post']);
}

?>

<main>
    <h1>Ajouter une question</h1>

    <form method="POST" action="/admin/question/ajouter">
        <div>
            <label for="category">Catégorie de la question</label>

            <select id="category" name="category">
                <?php foreach ($params['categories'] as $cat) : ?>
                <option value="<?= $cat->getId() ?>" 
                    <?= isset($category) && $category == $cat->getId() ? 'selected' : '' ?> >
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

            <input type="text" name="title" id="title" 
                value="<?= isset($title) ? htmlspecialchars($title) : '' ?>">

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

                <input type="text" id="answer<?= $i ?>" name="answer[<?= $i ?>][content]"
                    value="<?= isset($answer[$i]['content']) ? htmlspecialchars($answer[$i]['content']) : '' ?>">
            </div>

            <div>
                <label for="goodAnswer<?= $i ?>">Est-ce la bonne réponse ?</label>

                <input type="checkbox" id="goodAnswer<?= $i ?>" name="answer[<?= $i ?>][goodAnswer]"
                    <?= isset($answer[$i]['goodAnswer']) && $answer[$i]['goodAnswer'] === 'on' ? 'checked' : '' ?>/>
            </div>
        </div>
        <?php endfor; ?>

        <button type="submit">Valider</button>
    </form>
    
    <a href="/admin/questions">retour</a>
</main>