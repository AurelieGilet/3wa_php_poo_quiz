<nav>
    <ul>
        <li><a href="/">Accueil</a></li>
    </ul>
    <?php if (isset($_SESSION['user'])) : ?>
    <ul>
        <li><a href="<?= $_SESSION['auth'] === 'user' ? '/espace-utilisateur' : '/espace-admin' ?>">Profil</a></li>
        <li><a href="/deconnexion">Déconnexion</a></li>
    </ul>
    <?php endif; ?>
</nav>
