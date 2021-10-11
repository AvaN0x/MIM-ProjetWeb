<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="icon" href="favicon.ico" />
    <link rel="stylesheet" href="css/style.css" />
    <!-- <link rel="stylesheet" media="screen and (max-width:720px)" href="css/mobile.css" /> -->
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=max-device-width, initial-scale=1" />
    <!-- <script src="https://code.jquery.com/jquery-1.10.2.js"></script> -->
    <script src="https://kit.fontawesome.com/0383df481c.js" crossorigin="anonymous"></script>
</head>

<body>
    <main>
        <h1>Bienvenue sur l'espace d'inscription</h1>
        <form method="post" action="verifForm.php">
        <fieldset>
            <legend>Informations personnelles</legend>
            Nom d'utilisateur :    
            <input type="text" name="login" required="required"/>*<br/>   
            Mot de passe : 
            <input type="text" name="pwd" required="required"/>*<br/> 
            
            Sexe :  
            <input type="radio" name="gender" value="f"/> Femme 	
            <input type="radio" name="gender" value="h"/> Homme
            <br/>
            Nom :    
            <input type="text" name="name"/><br/> 
            Prénom :    
            <input type="text" name="fname"/><br/> 
            
            Adresse électronique :    
            <input type="text" name="mail"/><br/> 
            Date de naissance :    
            <input type="date" name="date" placeholder='jj/MM/AAAA'/><br/> 
            Adresse postale <br/>   
            <input type="text" name="address" placeholder='adresse'/><br/> 
            <input type="text" name="postcode" placeholder='code postal'/><br/> 
            <input type="text" name="city" placeholder='ville'/><br/> 

            <!-- Hidden field to show if we are in connection or inscription -->
            <input type="hidden" name="type" value="inscription"/>
        </fieldset>
        <input type="submit" value="S'inscrire" />
        </form>
        (*) champs obligatoires
        <a id="return" href="connexion.php">Retour</a>
    </main>
</body>

</html>