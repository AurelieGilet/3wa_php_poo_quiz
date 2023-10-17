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

<main class="contact">
    <div class="clipped-container">
        <h1>Contact</h1>

        <?php if (isset($params['flashes'])) : ?>
        <ul>
            <?php foreach ($params['flashes'] as $flash) : ?>
                <?= $flash ?>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <form method="POST" action="/contact" class="form">
            <div class="form-group">  
                <label for="email">
                    Merci de renseigner un email si vous souhaitez une réponse (facultatif)
                </label>
                <div class="clipped-input">
                    <input type="text" id="email" name="email" placeholder="Email" 
                        value="<?= isset($email) ? htmlspecialchars($email) : ''; ?>">
                </div>
    
                <?php if (isset($formErrors['email'])) : ?>
                <ul>
                    <?php foreach ($formErrors['email'] as $error) : ?>
                    <li class="error-message"><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
    
            <div class="form-group">   
                <label for="content">
                    Si votre demande concerne une question d'un des quiz merci de préciser 
                    le langage et l'intitulé de la question
                </label>
                <div class="clipped-input">
                    <textarea id="content" name="content" placeholder="content"><?=
                        isset($content) ? htmlspecialchars($content) : '';
                    ?></textarea>
                </div>
    
                <?php if (isset($formErrors['content'])) : ?>
                <ul>
                    <?php foreach ($formErrors['content'] as $error) : ?>
                    <li class="error-message"><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
    
            <button type="submit" class="clipped-button">
                Envoyer
            </button>
        </form>
    </div>
</main>