<header>
    <div>
        <a href="index.php">Navigation</a>
        <a href="index.php?route=favorite">Recettes <i class="fas fa-heart"></i></a>
    </div>
    <div>
        <form method="get" action="index.php">
            <label for="research">Recherche :</label>
            <input type="text" name="research" placeholder='"jus de fruits" +sel -whisky' value="<?php if (isset($_GET["research"])) echo str_replace('"', '&quot;', $_GET["research"]); ?>" />
            <button type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <?php if (isset($_SESSION['connected'])) : ?>
            <div>
                <?php if (isset($_SESSION['user']['name']) && !empty($_SESSION['user']['name'])) : ?>
                    <p>Nom : <span><?= $_SESSION['user']['name'] ?></span></p>
                <?php endif; ?>

                <?php if (isset($_SESSION['user']['fname']) && !empty($_SESSION['user']['fname'])) : ?>
                    <p>Prénom : <span><?= $_SESSION['user']['fname'] ?></span></p>
                <?php endif; ?>

                <?php if (
                    isset($_SESSION['user']['login'])
                    && !(isset($_SESSION['user']['name']) && !empty($_SESSION['user']['name']))
                    && !(isset($_SESSION['user']['fname']) && !empty($_SESSION['user']['fname']))
                ) : ?>
                    <p>Identifiant : <span><?= $_SESSION['user']['login'] ?></span></p>
                <?php endif; ?>
            </div>

            <br />
            <a href="index.php?route=editProfil">Mon profil</a>
            <br />
            <a href="index.php?route=deconnexion">Déconnexion</a>
        <?php else : ?>
            <form method="post" action='#'>
                Nom d'utilisateur :
                <input type="text" name="login" required="required" <?php isErrorField($errors, 'login') ?> value="<?= isset($postedValues['login']) ? $postedValues['login'] : '' ?>" />*

                Mot de passe :
                <input type="password" name="password" required="required" <?php isErrorField($errors, 'password') ?> value="<?= isset($postedValues['password']) ? $postedValues['password'] : '' ?>" />*

                <input type="submit" name="submit" value="Connexion" />
            </form>
            <a href="index.php?route=inscription">S'inscrire</a>
        <?php endif; ?>

    </div>
</header>