<?php require_once(__DIR__ . '/../model/utils.inc.php') ?>

<h1>Bienvenue sur l'espace d'inscription</h1>

<form method="post" action='#'>
    <fieldset>
        <legend>Informations personnelles ([*] champs obligatoires)</legend>

        Nom d'utilisateur :
        <input type="text" name="login" required="required" <?php isErrorField($errors, 'login') ?> value="<?= isset($postedValues['login']) ? $postedValues['login'] : '' ?>" />*
        <?php addErrorMessage($errors, 'login'); ?><br />


        Mot de passe :
        <input type="password" name="password" required="required" <?php isErrorField($errors, 'password') ?> value="<?= isset($postedValues['password']) ? $postedValues['password'] : '' ?>" />*
        <span style="margin-left: 40px"></span>


        Confirmer le mot de passe :
        <input type="password" name="confirmPassword" required="required" <?php isErrorField($errors, 'password') ?> value="<?= isset($postedValues['password']) ? $postedValues['password'] : '' ?>" />*
        <?php addErrorMessage($errors, 'password'); ?>
        <br />


        Sexe :
        <input type="radio" name="gender" value="f" <?php if (!empty($postedValues["gender"]) && $postedValues["gender"] == "f") echo "checked" ?> /> Femme
        <input type="radio" name="gender" value="h" <?php if (!empty($postedValues["gender"]) && $postedValues["gender"] == "h") echo "checked" ?> /> Homme
        <?php addErrorMessage($errors, 'gender'); ?>
        <br />


        Nom :
        <input type="text" name="name" <?php isErrorField($errors, 'name') ?> value="<?= isset($postedValues['name']) ? $postedValues['name'] : '' ?>" />
        <?php addErrorMessage($errors, 'name'); ?><br />


        Prénom :
        <input type="text" name="fname" <?php isErrorField($errors, 'fname') ?> value="<?= isset($postedValues['fname']) ? $postedValues['fname'] : '' ?>" />
        <?php addErrorMessage($errors, 'fname'); ?><br />


        Adresse électronique :
        <input type="email" name="email" <?php isErrorField($errors, 'email') ?> value="<?= isset($postedValues['email']) ? $postedValues['email'] : '' ?>" />
        <?php addErrorMessage($errors, 'email'); ?><br />


        Date de naissance :
        <input type="date" name="birthdate" placeholder='jj/MM/AAAA' <?php isErrorField($errors, 'birthdate') ?> value="<?= isset($postedValues['birthdate']) ? $postedValues['birthdate'] : '' ?>" />
        <?php addErrorMessage($errors, 'birthdate'); ?><br />


        Adresse postale <br />
        <input type="text" name="address" placeholder='adresse' <?php isErrorField($errors, 'address') ?> value="<?= isset($postedValues['address']) ? $postedValues['address'] : '' ?>" />
        <?php addErrorMessage($errors, 'address'); ?><br />
        <input type="text" name="postcode" placeholder='code postal' <?php isErrorField($errors, 'postcode') ?> value="<?= isset($postedValues['postcode']) ? $postedValues['postcode'] : '' ?>" />
        <?php addErrorMessage($errors, 'postcode'); ?><br />
        <input type="text" name="city" placeholder='ville' <?php isErrorField($errors, 'city') ?> value="<?= isset($postedValues['city']) ? $postedValues['city'] : '' ?>" />
        <?php addErrorMessage($errors, 'city'); ?><br />


        Numéro de téléphone :
        <input type="tel" name="phone" placeholder='+33 X XX XX XX XX' <?php isErrorField($errors, 'phone') ?> value="<?= isset($postedValues['phone']) ? $postedValues['phone'] : '' ?>" pattern="^(?:\+33\s|0)[1-9](?:\s?\d\d){4}$" />
        <?php addErrorMessage($errors, 'phone'); ?><br />
    </fieldset>

    <input type="submit" name="submit" value="S'inscrire" />
</form>

<a href="index.php?route=accueil">Retour à l'accueil</a>