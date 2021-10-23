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

        <form method="post" action="view/connexion.php">
            <input type="hidden" name="type" value="connexion" />
            <input type="submit" value="Zone de connexion" />
        </form>
    </div>
</header>