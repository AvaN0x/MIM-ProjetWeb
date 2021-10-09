<?php
    // Si l'utilisateur a cliqué sur connexion, mais n'a pas rempli le formulaire : Affichage du formulaire
    if(isset($_POST["connexion"]) && !(isset($_GET["identifiant"])) && !(isset($_GET["m2p"]))){
?>
        <aside>
            <form method="post" action="#">
                Identifiant :
                <input type="text" name="identifiant" required="required"/>
                </br>
                Mot de passe :
                <input type="text" name="m2p" required="required"/>
                <button type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>   
        </aside> 
<?php
    }
    //Si l'utilisateur a rempli le formulaire : Vérification du formulaire
    if(isset($_POST["connexion"]) && isset($_POST["identifiant"]) && isset($_POST["m2p"])){
?>
        <aside>
            <!-- TODO -->
        </aside>
<?php
    }
?>