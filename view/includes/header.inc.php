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
                <p>
                    <?php
                    if (
                        isset($_SESSION['user']['name']) && !empty($_SESSION['user']['name'])
                        && isset($_SESSION['user']['fname']) && !empty($_SESSION['user']['fname'])
                    ) {
                    ?>
                        <span><?= ucfirst($_SESSION['user']['name']) . " " . ucfirst($_SESSION['user']['fname']) ?></span>
                    <?php
                    } elseif (
                        isset($_SESSION['user']['name']) && !empty($_SESSION['user']['name'])
                    ) {
                    ?>
                        <span><?= ucfirst($_SESSION['user']['name']) ?></span>
                    <?php
                    } elseif (isset($_SESSION['user']['fname']) && !empty($_SESSION['user']['fname'])) {
                    ?>
                        <span><?= ucfirst($_SESSION['user']['fname']) ?></span>
                    <?php
                    } else {
                    ?>
                        <span><?= $_SESSION['user']['login'] ?></span>
                    <?php
                    }
                    ?>
                </p>
            </div>

            <br />
            <a href="index.php?route=editProfil">Profil</a>
            <br />
            <a href="index.php?route=deconnexion">Déconnexion</a>
        <?php else : ?>
            <form method="post" action='#'>
                <label for="password">Login</label>
                <input type="text" name="login" required="required" <?php isErrorField($errors, 'login') ?> value="<?= isset($postedValues['login']) ? $postedValues['login'] : '' ?>" />

                <label for="password">Mot de passe</label>
                <input type="password" name="password" required="required" <?php isErrorField($errors, 'password') ?> value="<?= isset($postedValues['password']) ? $postedValues['password'] : '' ?>" />

                <input type="submit" name="submit" value="Connexion" />
            </form>
            <a href="index.php?route=inscription">S'inscrire</a>
        <?php endif; ?>

    </div>
</header>