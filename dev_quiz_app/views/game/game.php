<main>
    <h1><?= htmlspecialchars($params['category']->getName()) ?></h1>

    <div id="game-question">
        <?php include('_game-question.php'); ?>
    </div>

    <button id="validate-answer">Valider</button>
</main>