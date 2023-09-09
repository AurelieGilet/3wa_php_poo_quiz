<main>
    <h1>Bienvenue <?= htmlspecialchars($params['user']->getAlias()) ?></h1>

    <div>
        <a href="/choisir-sujet">Choisir un sujet</a>
        <a href="/espace-utilisateur/scores">Voir mes scores</a>
    </div>
</main>

