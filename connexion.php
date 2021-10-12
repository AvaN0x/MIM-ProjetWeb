<?php session_start(); ?>

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
        <h1>Bienvenue sur l'espace de connexion</h1>
        <form method="post" action="verifForm.php">
        <fieldset>
            <legend>Informations personnelles</legend>
            Nom d'utilisateur :    
            <input type="text" name="login" required="required" <?php if (isset($_SESSION['errors']['login'])) echo 'class = "errorField"' ?>/>*<br />

            Mot de passe : 
            <input type="password" name="pwd" required="required" <?php if (isset($_SESSION['errors']['pwd'])) echo 'class = "errorField"' ?>/>*<br />

            <!-- Hidden field to show if we are in connection or inscription -->
            <input type="hidden" name="type" value="connexion"/>
        </fieldset>
        <input type="submit" value="Se connecter" />
        </form>
        (*) champs obligatoires
        <a id="inscription" href="inscription.php">S'inscrire</a>
        <a id="return" href="index.php">Retour</a>
    </main>
</body>

</html>