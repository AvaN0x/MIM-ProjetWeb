<h1>Bienvenue sur l'espace de modification du profil</h1>

<form method="post" action='#'>
    <fieldset>
        Sexe :
        <input type="radio" name="gender" value="f" <?php if ($postedValues["gender"] == "f") echo "checked" ?> /> Femme
        <input type="radio" name="gender" value="h" <?php if ($postedValues["gender"] == "h") echo "checked" ?> /> Homme
        <br />

        Nom :
        <input type="text" name="name" <?php if (isset($errors['name'])) echo 'class="error-field"' ?> value="<?= $postedValues['name'] ?>" /><br />

        Prénom :
        <input type="text" name="fname" <?php if (isset($errors['fname'])) echo 'class="error-field"' ?> value="<?= $postedValues['fname'] ?>" /><br />

        Adresse électronique :
        <input type="email" name="email" <?php if (isset($errors['email'])) echo 'class="error-field"' ?> value="<?= $postedValues['email'] ?>" /><br />

        Date de naissance :
        <input type="date" name="birthdate" placeholder='jj/MM/AAAA' <?php if (isset($errors['birthdate'])) echo 'class="error-field"' ?> value="<?= $postedValues['birthdate'] ?>" /><br />

        Adresse postale <br />
        <input type="text" name="address" placeholder='adresse' <?php if (isset($errors['address'])) echo 'class="error-field"' ?> value="<?= $postedValues['address'] ?>" /><br />
        <input type="text" name="postcode" placeholder='code postal' <?php if (isset($errors['postcode'])) echo 'class="error-field"' ?> value="<?= $postedValues['postcode'] ?>" /><br />
        <input type="text" name="city" placeholder='ville' <?php if (isset($errors['city'])) echo 'class="error-field"' ?> value="<?= $postedValues['city'] ?>" /><br />

        <!-- //TODO phone number missing -->
    </fieldset>

    <input type="submit" name="submit" value="Modifier" />
</form>

<a href="index.php?route=profil">Retour à mon profil</a>