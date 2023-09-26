<?php if (count($params['scores']) === 0) : ?>
<p class="is-centered">Pas encore de score</p>
<a href="/choisir-sujet" class="clipped-button">Faire un quiz</a>
<?php endif; ?>

<table>
    <tbody>
        <?php foreach ($params['scores'] as $score) : ?>
        <tr>
            <td><?= date('m/d/y', strtotime($score->getCreatedAt())) ?></td>
            <td><?= htmlspecialchars($score->getResult()) ?>%</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>