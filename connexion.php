<?php 
    // session_start(); 
    include_once('verifForm.php');

    if (isset($_POST) && isset($_POST['submit']) && (count($errors) === 0))
        header("Location: index.php");

    $isInscription = isset($_POST['type']) && ($_POST['type'] === 'inscription');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="icon" href="favicon.ico" />
    <!-- <link rel="stylesheet" href="css/style.css" /> -->
    <!-- <link rel="stylesheet" media="screen and (max-width:720px)" href="css/mobile.css" /> -->
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=max-device-width, initial-scale=1" />
    <!-- <script src="https://code.jquery.com/jquery-1.10.2.js"></script> -->
    <script src="https://kit.fontawesome.com/0383df481c.js" crossorigin="anonymous"></script>

    <style>
        .errorField {
            background-color: #F44336;
        }
    </style>
</head>

<body>
    <main>
        <h1>Bienvenue sur l'espace <?php echo($isInscription ? "d'inscription" : "de connexion")?></h1>
        <form method="post" action='#'>
        <fieldset>
            <legend>Informations personnelles ([*] champs obligatoires)</legend>
            Nom d'utilisateur :    
            <input 
                type="text" 
                name="login" 
                required="required" 
                <?php if (isset($errors['login'])) echo 'class="errorField"' ?>
                value="<?php echo($postedValues['login']) ?>"
            />*<br/>   

            Mot de passe : 
            <input 
                type="password" 
                name="pwd" 
                required="required" 
                <?php if (isset($errors['pwd'])) echo 'class="errorField"' ?>
                value="<?php echo($postedValues['pwd']) ?>"
            />*<br/> 
            
            <!-- If we want to get an inscription -->
            <?php if($isInscription): ?>
                Sexe :  
                <input type="radio" name="gender" value="f"/> Femme 	
                <input type="radio" name="gender" value="h"/> Homme
                <br/>


                Nom :    
                <input 
                    type="text" 
                    name="name" 
                    <?php if (isset($errors['name'])) echo 'class="errorField"' ?>
                    value="<?php echo($postedValues['name']) ?>"
                /><br/> 


                Prénom :    
                <input 
                    type="text" 
                    name="fname" 
                    <?php if (isset($errors['fname'])) echo 'class="errorField"' ?>
                    value="<?php echo($postedValues['fname']) ?>"
                /><br/> 
                

                Adresse électronique :    
                <input 
                    type="text" 
                    name="mail" 
                    <?php if (isset($errors['mail'])) echo 'class="errorField"' ?>
                    value="<?php echo($postedValues['mail']) ?>"
                /><br/> 


                Date de naissance :    
                <input 
                    type="date" 
                    name="date" 
                    placeholder='jj/MM/AAAA' 
                    <?php if (isset($errors['date'])) echo 'class="errorField"' ?>
                    value="<?php echo($postedValues['date']) ?>"
                /><br/> 


                Adresse postale <br/>   
                <input 
                    type="text" 
                    name="address" 
                    placeholder='adresse' 
                    <?php if (isset($errors['address'])) echo 'class="errorField"' ?>
                    value="<?php echo($postedValues['address']) ?>"
                /><br/> 
                <input 
                    type="text" 
                    name="postcode" 
                    placeholder='code postal' 
                    <?php if (isset($errors['postcode'])) echo 'class="errorField"' ?>
                    value="<?php echo($postedValues['postcode']) ?>"
                /><br/> 
                <input 
                    type="text" 
                    name="city" 
                    placeholder='ville' 
                    <?php if (isset($errors['city'])) echo 'class="errorField"' ?>
                    value="<?php echo($postedValues['city']) ?>"
                /><br/> 
            <?php endif; ?>

            <!-- Hidden field to show if we are in connection or inscription -->
            <input 
                type="hidden" 
                name="type" 
                value="<?php echo (($isInscription) ? "inscription" : "connexion")?>"
            />
        </fieldset>

        <input type="submit" name="submit" value="<?php echo (($isInscription) ? "S'inscrire" : "Connexion")?>" />
        </form>

        </br>
        <button><a href="index.php">Retour à la page d'accueil</a></button>
        
        <form method="post" action="#">
            <input type="hidden" name="type" value="<?php echo (($isInscription) ? "connexion" : "inscription")?>"/>
            <input type="submit" value="<?php echo (($isInscription) ? "Retour à la page de connexion" : "S'inscrire")?>"/>
        </form>
    </main>
</body>

</html>