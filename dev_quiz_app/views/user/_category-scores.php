
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