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
        <div>
            <!-- Connexion renvoie une variable "connexion", pb: input hidden (moche) 
                Try modif avec css? trouver autre soluce? -->
            <form id="myForm" action="index.php" method="post">
                <input id="hidden" type="hidden" name="connexion"/>
                <a id="Connexion" href="#" onclick="document.getElementById('myForm').submit();">Se Connecter</a>
                <!-- <a>NOM PRENOM</a>
                <a>Se déconnecter</a> -->
            </form>
        </div>
    </div>
</header>