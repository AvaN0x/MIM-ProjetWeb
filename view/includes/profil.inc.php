<div>
    <?php
    if (isset($_SESSION['user']['name']) && !empty($_SESSION['user']['name'])) {
    ?>
        <p>Nom : <span><?= $_SESSION['user']['name'] ?></span></p>
    <?php
    }
    if (isset($_SESSION['user']['fname']) && !empty($_SESSION['user']['fname'])) {
    ?>
        <p>Prénom : <span><?= $_SESSION['user']['fname'] ?></span></p>
    <?php
    }
    if (isset($_SESSION['user']['login'])) {
    ?>
        <p>Identifiant : <span><?= $_SESSION['user']['login'] ?></span></p>
    <?php
    }
    ?>
</div>

<br />
<a href="index.php?route=editProfil">Mon profil</a>
<br />
<a href="index.php?route=deconnexion">Déconnexion</a>