<main class="game-score">
    <h1>Résultats</h1>
    <div class="clipped-container">
        <p><?= $params['score']['total'] ?>/10</p>
        <p><?= $params['score']['percentage'] ?>%</p>
        <p><?= $params['score']['mention'] ?></p>
    </div>

    <div class="game-score__buttons">
        <a href="/espace-utilisateur/scores" class="clipped-button">Mes scores</a>
        <a href="/choisir-sujet" class="clipped-button">Nouveau Quiz</a>
    </div>
</main>