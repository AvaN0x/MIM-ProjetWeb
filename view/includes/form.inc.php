<?php if ($action === 'inscription') : ?>
    <h1>Bienvenue sur l'espace d'inscription</h1>
<?php else : ?>
    <h1>Bienvenue sur l'espace de connexion</h1>
<?php endif; ?>

<form method="post" action='#'>
    <fieldset>
        <legend>Informations personnelles ([*] champs obligatoires)</legend>

        Nom d'utilisateur :
        <input type="text" name="login" required="required" <?php if (isset($errors['login'])) echo 'class="error-field"' ?> value="<?= $postedValues['login'] ?>" />*<br />
        

        Mot de passe :
        <input type="password" name="password" required="required" <?php if (isset($errors['password'])) echo 'class="error-field"' ?> value="<?= $postedValues['password'] ?>" />*
        
        <?php if ($action === 'inscription'): ?>
            <span style="margin-left: 40px"></span>
            Confirmer le mot de passe :
            <input type="password" name="confirmPassword" required="required" <?php if (isset($errors['password'])) echo 'class="error-field"' ?> value="<?= $postedValues['password'] ?>" />*
        <?php endif; ?>

        <br />
        <!-- If we want to get an inscription -->
        <?php if ($action === 'inscription') : ?>
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
        <?php endif; ?>
    </fieldset>

    <?php if ($action === 'inscription') : ?>
        <input type="submit" name="submit" value="S'inscrire" />
    <?php else : ?>
        <input type="submit" name="submit" value="Connexion" />
    <?php endif; ?>
</form>

<?php if ($action === 'inscription') : ?>
    <a href="index.php?route=connexion">Retour à la page de connexion</a>
<?php else : ?>
    <a href="index.php?route=inscription">S'inscrire</a>
<?php endif; ?>
