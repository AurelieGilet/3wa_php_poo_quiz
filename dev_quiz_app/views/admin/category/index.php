<main class="admin-category">
    <h1>Gestion des catégories</h1>

    <?php if (isset($params['flashes'])) : ?>
    <ul>
        <?php foreach ($params['flashes'] as $flash) : ?>
            <?= $flash ?>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <div class="clipped-container large">
        <a href="/admin/categorie/ajouter" class="clipped-button">Ajouter une catégorie</a>
    
        <table class="table">
            <thead>
                <tr>
                    <th>Nom catégorie</th>
                    <th>Questions associées</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($params['categories'] as $category) : ?>
                <tr>
                    <td data-title="Nom de la catégorie" data-truncate="true" class="is-uppercase">
                        <?= htmlspecialchars($category->getName()) ?>
                    </td>
                    <td data-title="Questions associées">
                        <?= htmlspecialchars($category->getQuestionsCount()) ?>
                    </td>
                    <td class="option">
                        <a href="/admin/categorie/modifier/<?= $category->getId() ?>">
                            <span class="link is-hidden-md">Modifier</span>
                            <span class="icon-pencil is-visible-md" aria-label="Modifier la catégorie"></span>
                        </a>
                    </td>
                    <td class="option">
                        <a href="/admin/categorie/supprimer/<?= $category->getId() ?>">
                            <span class="link is-hidden-md">Supprimer</span>
                            <span class="icon-bin is-visible-md" aria-label="Supprimer la catégorie"></span>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>