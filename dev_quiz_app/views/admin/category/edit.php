<main>
    <h1>Modifier la catégorie <?= $params['category']->name ?></h1>

    <form action="/admin/categorie/modifier/<?= $params['category']->id ?>" method="POST">
        <div>
            <label for="name">Nom de la catégorie</label>
            <input type="text" name="name" id="name" value="<?= $params['category']->name ?>">
        </div>
        <button type="submit">Valider</button>
    </form>
</main>