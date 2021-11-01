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

        <a href="index.php?route=connexion">Zone de connexion</a>
    </div>
</header>