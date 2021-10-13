<section>
    <h1>Liste des cocktails après navigation</h1>
    <!-- <h1>Liste des cocktails par recherche</h1> -->
    <div class="cocktails-list">
        
        <?php
            foreach($Recettes as $key => $value){ 
               echo "<article>
                    <div>
                        <i class=\"fas fa-heart\"></i>
                        <i class=\"far fa-heart\"></i>
                    </div>
                    <h2>".$value["titre"]."</h2>
                    <img src=\"res/Photos/Bloody_mary.jpg\">
                    <ol> \n";
               foreach ($value["index"] as $key2 => $value2) {
                    echo "<li>".$value2."</li> \n";
               }
               echo "</ol>
                    </article> \n";
            }
        ?>
    
    </div>
</section>