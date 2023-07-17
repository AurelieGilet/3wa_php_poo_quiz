<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dev Quiz !</title>
    <link rel="stylesheet" href="<?= SCRIPTS . 'style' . DIRECTORY_SEPARATOR . 'style.min.css' ?>">
</head>
<body>
    <div class="page-container">
        <?php include('../views/partials/navbar.php'); ?>
        
        <?= $content ?>

        <?php include('../views/partials/footer.php'); ?>
    </div>
</body>
</html>