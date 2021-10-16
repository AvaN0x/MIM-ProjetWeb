<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['type']) && $_POST['type'] === 'deconnexion')
    if (isset($_SESSION['connected'])) unset($_SESSION['connected']);
?>

<header>
    <div>
        <a href="index.php">Navigation</a>
        <a>Recettes <i class="fas fa-heart"></i></a>
    </div>
    <div>
        <form method="get" action="index.php">
            <label for="research">Recherche :</label>
            <input type="text" name="research" placeholder='"jus de fruit" +sel -whisky' />
            <button type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <?php if (isset($_SESSION['connected']['login']) && isset($_SESSION['connected']['password'])) : ?>
            <form method="post" action="#">
                <input type="hidden" name="type" value="deconnexion" />
                <input type="submit" value="Déconnexion" />
            </form>
        <?php else : ?>
            <form method="post" action="connexion.php">
                <input type="hidden" name="type" value="connexion" />
                <input type="submit" value="Se connecter" />
            </form>
        <?php endif; ?>
    </div>
</header>