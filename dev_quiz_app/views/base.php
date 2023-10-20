<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Aurélie Gilet">
    <meta name="description" content="Dev Quiz est un site de quiz dédié aux langages de programmation. Vous pouvez y tester vos connaissances en HTML, CSS, Javascript, PHP ou encore SQL !">
    <meta name="keywords" content="quiz développeur web, quiz langage de programmation, quiz html, quiz css, quiz javascript, quiz sql, quiz php">
    <title>Dev Quiz !</title>
    <link rel="stylesheet" href="<?= SCRIPTS . 'style/style.min.css' ?>">
</head>
<body>
    <div class="page-container">
        <?php include('../views/partials/navbar.php'); ?>

        <?= $content ?>

        <?php include('../views/partials/footer.php'); ?>
    </div>

    <script src="<?= SCRIPTS . 'js/main.min.js' ?>"></script>
</body>
</html>