<main>
    <h1><?= isset($params['category']->name) ? 'Modifier la catégorie ' . $params['category']->name : 'Ajouter une catégorie' ?></h1>

    <form method="POST"
        action="<?= isset($params['category'])
        ? '/admin/categorie/modifier/' . $params['category']->id
        : '/admin/categorie/ajouter'?>">
        <div>
            <label for="name">Nom de la catégorie</label>
            <input type="text" name="name" id="name" value="<?= $params['category']->name ?? '' ?>">
        </div>
        <button type="submit">Valider</button>
    </form>
</main>