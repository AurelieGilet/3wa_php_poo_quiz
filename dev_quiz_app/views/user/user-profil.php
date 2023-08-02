<main>
    <h1>Mon profil</h1>

    <div>
        <p>Mon pseudo</p>
        <p><?=  $params['user']->getAlias() ?></p>
    </div>
    <div>
        <p>Mon email</p>
        <p><?=  $params['user']->getEmail() ?></p>
    </div>
    <div>
        <p>Mon mot de passe</p>
        <p>********</p>
    </div>

    <a href="">Modifier mes infos</a>
    <a href="">Supprimer mon compte</a>
</main>