<main class="game">
    <h1><?= htmlspecialchars($params['category']->getName()) ?></h1>

    <div id="game-question" class="game__question clipped-container">
        <?php include('_game-question.php'); ?>
    </div>

    <button id="validate-answer" class="clipped-button">Valider</button>
</main>