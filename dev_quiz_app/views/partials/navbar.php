<?php
    $path = $_SESSION['path'];

    echo'<pre>'; var_dump($path); echo'</pre>';
?>

<nav>
    <ul>
        <li>
            <a href="<?= isset($_SESSION['auth']) && $_SESSION['auth'] === 'admin'
                ? '/espace-admin'
                : (isset($_SESSION['auth']) && $_SESSION['auth'] === 'user'
                ? '/espace-utilisateur'
                : '/') ?>">
                Accueil
            </a>
        </li>
    </ul>

    <?php if (isset($_SESSION['user'])) : ?>
    <ul>
        <?php if ($_SESSION['path'] === 'profil-utilisateur') :  ?>
        <li>
            <a href="<?= $_SESSION['auth'] === 'admin' ? '/espace-admin' : '/espace-utilisateur' ?>">
                Retour
            </a>
        </li>
        <?php else : ?>
        <li>
            <a href="/profil-utilisateur">
                Profil
            </a>
        </li>
        <?php endif; ?>
        <li>
            <a href="/deconnexion">
                Déconnexion
            </a>
        </li>
    </ul>
    <?php endif; ?>
</nav>
