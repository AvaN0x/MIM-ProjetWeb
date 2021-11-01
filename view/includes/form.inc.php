<?php require_once(__DIR__ . '/../../model/utils.inc.php') ?>

<?php if ($action === 'inscription') : ?>
    <h1>Bienvenue sur l'espace d'inscription</h1>
<?php else : ?>
    <h1>Bienvenue sur l'espace de connexion</h1>
<?php endif; ?>

<form method="post" action='#'>
    <fieldset>
        <legend>Informations personnelles ([*] champs obligatoires)</legend>

        Nom d'utilisateur :
        <input type="text" name="login" required="required" <?php isErrorField($errors, 'login') ?> value="<?= $postedValues['login'] ?? '' ?>" />*
        <?php addErrorMessage($errors, 'login'); ?><br />


        Mot de passe :
        <input type="password" name="password" required="required" <?php isErrorField($errors, 'password') ?> value="<?= $postedValues['password'] ?? '' ?>" />*


        <?php if ($action === 'inscription') : ?>
            <span style="margin-left: 40px"></span>
            Confirmer le mot de passe :
            <input type="password" name="confirmPassword" required="required" <?php isErrorField($errors, 'password') ?> value="<?= $postedValues['password'] ?? '' ?>" />*
        <?php endif; ?>
        <?php addErrorMessage($errors, 'password'); ?>

        <br />
        <!-- If we want to get an inscription -->
        <?php if ($action === 'inscription') : ?>
            Sexe :
            <input type="radio" name="gender" value="f" <?php if ($postedValues["gender"] == "f") echo "checked" ?> /> Femme
            <input type="radio" name="gender" value="h" <?php if ($postedValues["gender"] == "h") echo "checked" ?> /> Homme
            <?php addErrorMessage($errors, 'gender'); ?>
            <br />

            Nom :
            <input type="text" name="name" <?php isErrorField($errors, 'name') ?> value="<?= $postedValues['name'] ?? '' ?>" />
            <?php addErrorMessage($errors, 'name'); ?><br />

            Prénom :
            <input type="text" name="fname" <?php isErrorField($errors, 'fname') ?> value="<?= $postedValues['fname'] ?? '' ?>" />
            <?php addErrorMessage($errors, 'fname'); ?><br />

            Adresse électronique :
            <input type="email" name="email" <?php isErrorField($errors, 'email') ?> value="<?= $postedValues['email'] ?? '' ?>" />
            <?php addErrorMessage($errors, 'email'); ?><br />

            Date de naissance :
            <input type="date" name="birthdate" placeholder='jj/MM/AAAA' <?php isErrorField($errors, 'birthdate') ?> value="<?= $postedValues['birthdate'] ?? '' ?>" />
            <?php addErrorMessage($errors, 'birthdate'); ?><br />

            Adresse postale <br />
            <input type="text" name="address" placeholder='adresse' <?php isErrorField($errors, 'address') ?> value="<?= $postedValues['address'] ?? '' ?>" />
            <?php addErrorMessage($errors, 'address'); ?><br />
            <input type="text" name="postcode" placeholder='code postal' <?php isErrorField($errors, 'postcode') ?> value="<?= $postedValues['postcode'] ?? '' ?>" />
            <?php addErrorMessage($errors, 'postcode'); ?><br />
            <input type="text" name="city" placeholder='ville' <?php isErrorField($errors, 'city') ?> value="<?= $postedValues['city'] ?? '' ?>" />
            <?php addErrorMessage($errors, 'city'); ?><br />

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