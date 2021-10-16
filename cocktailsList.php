<section>
    <h1>Liste des cocktails après navigation</h1>
    <!-- <h1>Liste des cocktails par recherche</h1> -->
    <div class="cocktails-list">

        <?php
        foreach ($Recettes as $key => $value) {
            $PhotoExist = false;
            // TODO @AvaN0x optimisation

            //On vérifie si une photo du cocktail existe
            //On compare donc le titre du cocktail et le titre de la photo
            //On les met au même format xxx_xxx
            $temp = explode(" ", $value["titre"]);

            //Les images du dossier ont un nom de maximum 2 mots, pas besoin de faire les autres
            if (count($temp) == 2) {
                $img = $temp[0] . "_" . strtolower($temp[1]);
            } else {
                $img = $value["titre"];
            }

            $Photos[] = scandir("res/Photos/");
            $PhotosArray = $Photos[0];
            array_splice($PhotosArray, 0, 2);

            foreach ($PhotosArray as $key2 => $value2) {
                $nomPhoto = explode(".", $value2);
                if ($img == $nomPhoto[0]) {
                    $PhotoExist = true;
                }
            }

            //Si la photo n'existe pas, on affiche une image par défaut (Bloody Mary)
            if ($PhotoExist == false) {
                $img = "Bloody_mary";
            }

            echo "<article>
                    <div>
                        <i class=\"fas fa-heart\"></i>
                        <i class=\"far fa-heart\"></i>
                    </div>
                    <h2>" . $value["titre"] . "</h2>
                    <img src=\"res/Photos/$img.jpg\">
                    <ul> \n";
            foreach ($value["index"] as $key3 => $value3) {
                echo "<li>" . $value3 . "</li> \n";
            }
            echo "</ul>
                    </article> \n";
        }
        ?>

    </div>
</section>