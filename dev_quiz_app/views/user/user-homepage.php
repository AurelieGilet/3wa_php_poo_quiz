<main>
    <div class="flex-column-container">
        <h1>Bienvenue <?= htmlspecialchars($params['user']->getAlias()) ?></h1>
    

        <div class="grid-column-container">
            <a href="/choisir-sujet" class="clipped-button">
                Choisir un sujet
            </a>
    
            <a href="/espace-utilisateur/scores" class="clipped-button">
                Voir mes scores
            </a>
        </div>
    </div>
</main>

