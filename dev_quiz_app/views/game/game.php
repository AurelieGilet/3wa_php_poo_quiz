<main>
    <h1><?= htmlspecialchars($params['category']->getName()) ?></h1>

    <div id="game-question">
        <?php include('_game-question.php'); ?>
    </div>

    <div id="game-progress"></div>
    
    <button>Valider</button>
</main>