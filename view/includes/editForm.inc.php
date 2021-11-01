<?php require_once(__DIR__ . '/../../model/utils.inc.php') ?>

<h1>Bienvenue sur l'espace de modification du profil</h1>

<form method="post" action='#'>
    <fieldset>
        Sexe :
        <input type="radio" name="gender" value="f" <?php if ($postedValues["gender"] == "f") echo "checked" ?> /> Femme
        <input type="radio" name="gender" value="h" <?php if ($postedValues["gender"] == "h") echo "checked" ?> /> Homme
        <br />

        Nom :
        <input type="text" name="name" <?php isErrorField($errors, 'name') ?> value="<?= $postedValues['name'] ?>" /><br />

        Prénom :
        <input type="text" name="fname" <?php isErrorField($errors, 'fname') ?> value="<?= $postedValues['fname'] ?>" /><br />

        Adresse électronique :
        <input type="email" name="email" <?php isErrorField($errors, 'email') ?> value="<?= $postedValues['email'] ?>" /><br />

        Date de naissance :
        <input type="date" name="birthdate" placeholder='jj/MM/AAAA' <?php isErrorField($errors, 'birthdate') ?> value="<?= $postedValues['birthdate'] ?>" /><br />

        Adresse postale <br />
        <input type="text" name="address" placeholder='adresse' <?php isErrorField($errors, 'address') ?> value="<?= $postedValues['address'] ?>" /><br />
        <input type="text" name="postcode" placeholder='code postal' <?php isErrorField($errors, 'postcode') ?> value="<?= $postedValues['postcode'] ?>" /><br />
        <input type="text" name="city" placeholder='ville' <?php isErrorField($errors, 'city') ?> value="<?= $postedValues['city'] ?>" /><br />

        <!-- //TODO phone number missing -->
    </fieldset>

    <input type="submit" name="submit" value="Modifier" />
</form>

<a href="index.php?route=profil">Retour à mon profil</a>