<div>
    <p>Nom : <?= isset($_SESSION['connected']['name']) ? $_SESSION['connected']['name'] : 'error name' ?></p>
    <p>Prénom : <?= isset($_SESSION['connected']['fname']) ? $_SESSION['connected']['fname'] : 'error first name' ?></p>
</div>

<br />
<a href="index.php?route=editProfil">Mon profil</a>
<br />
<a href="index.php?route=deconnexion">Déconnexion</a>