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

?>

<main>
    <div class="clipped-container">
        <h1>Inscription</h1>
        
        <form method="POST" action="/inscription">
            <div class="form-group">    
                <div class="clipped-input">
                    <input type="text" id="email" name="email" placeholder="Email">
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
                <?php /*TODO: don't forget to change back input type to password*/ ?>
                <div class="clipped-input">
                    <input type="text" id="password" name="password" placeholder="Mot de passe">
                </div>
    
                <?php if (isset($formErrors['password'])) : ?>
                <ul>
                    <?php foreach ($formErrors['password'] as $error) : ?>
                    <li class="error-message"><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
    
            <button type="submit" class="clipped-button">
                S'inscrire
            </button>
        </form>
    </div>
</main>