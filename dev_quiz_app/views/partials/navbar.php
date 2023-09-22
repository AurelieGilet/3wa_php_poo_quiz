<?php if ($_SESSION['path'] !== "") : ?>
<nav class="nav">
    <ul>
        <li>
            <a href="<?= isset($_SESSION['auth']) && $_SESSION['auth'] === 'admin'
                ? '/espace-admin'
                : (isset($_SESSION['auth']) && $_SESSION['auth'] === 'user'
                ? '/espace-utilisateur'
                : '/') ?>">
                <span class="icon-home is-hidden-tablet" aria-label="Accueil"></span>
                <span class="is-hidden-mobile has-link-border">Accueil</span>
            </a>
        </li>
    </ul>

    <?php if (isset($_SESSION['user'])) : ?>
    <span id="nav-options" 
        class="icon-options is-hidden-tablet" 
        aria-label="Options">
    </span>

    <ul id="options-menu" class="nav__options">
        <li>
            <a href="/profil-utilisateur">
                Profil
            </a>
        </li>
        <li>
            <a href="/deconnexion">
                Déconnexion
            </a>
        </li>
    </ul>

    <ul class="nav__options--desktop is-hidden-mobile">
        <li>
            <a href="/profil-utilisateur">
                Profil
            </a>
        </li>
        <li>
            <a href="/deconnexion">
                Déconnexion
            </a>
        </li>
    </ul>
    <?php endif; ?>
</nav>
<?php endif; ?>