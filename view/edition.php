<!DOCTYPE html>
<html lang="fr">

<?php
include("includes/head.inc.php");
?>

<body>
    <main>
        <?php if (isset($errors['deletedProfil'])) : ?>
            <p class='error-field'>Une erreur est survenu : votre profil a été supprimé</p>
        <?php else : ?>
            <?php require_once(__DIR__ . "/../model/utils.inc.php") ?>

            <h1>Bienvenue sur l'espace de modification du profil</h1>

            <form method="post" action='#'>
                <fieldset>
                    Sexe :
                    <input type="radio" name="gender" value="f" <?= (isset($postedValues["gender"]) && $postedValues["gender"] === "f") ? "checked" : "" ?> /> Femme
                    <input type="radio" name="gender" value="h" <?= (isset($postedValues["gender"]) && $postedValues["gender"] === "h") ? "checked" : "" ?> /> Homme
                    <?php addErrorMessage($errors, 'gender'); ?><br />
                    <br />

                    Nom :
                    <input type="text" name="name" <?php isErrorField($errors, 'name') ?> value="<?= isset($postedValues['name']) ? $postedValues['name'] : '' ?>" />
                    <?php addErrorMessage($errors, 'name'); ?><br /><br />

                    Prénom :
                    <input type="text" name="fname" <?php isErrorField($errors, 'fname') ?> value="<?= isset($postedValues['fname']) ? $postedValues['fname'] : '' ?>" />
                    <?php addErrorMessage($errors, 'fname'); ?><br /><br />

                    Adresse électronique :
                    <input type="email" name="email" <?php isErrorField($errors, 'email') ?> value="<?= isset($postedValues['email']) ? $postedValues['email'] : '' ?>" />
                    <?php addErrorMessage($errors, 'email'); ?><br /><br />

                    Date de naissance :
                    <input type="date" name="birthdate" placeholder='jj/MM/AAAA' <?php isErrorField($errors, 'birthdate') ?> value="<?= isset($postedValues['birthdate']) ? $postedValues['birthdate'] : '' ?>" />
                    <?php addErrorMessage($errors, 'birthdate'); ?><br /><br />

                    Adresse postale <br />
                    <input type="text" name="address" placeholder='adresse' <?php isErrorField($errors, 'address') ?> value="<?= isset($postedValues['address']) ? $postedValues['address'] : '' ?>" />
                    <?php addErrorMessage($errors, 'address'); ?><br /><br />
                    <input type="text" name="postcode" placeholder='code postal' <?php isErrorField($errors, 'postcode') ?> value="<?= isset($postedValues['postcode']) ? $postedValues['postcode'] : '' ?>" />
                    <?php addErrorMessage($errors, 'postcode'); ?><br /><br />
                    <input type="text" name="city" placeholder='ville' <?php isErrorField($errors, 'city') ?> value="<?= isset($postedValues['city']) ? $postedValues['city'] : '' ?>" />
                    <?php addErrorMessage($errors, 'city'); ?><br /><br />

                    Numéro de téléphone :
                    <input type="tel" name="phone" placeholder='+33|0 X XX XX XX XX' <?php isErrorField($errors, 'phone') ?> value="<?= isset($postedValues['phone']) ? $postedValues['phone'] : '' ?>" pattern="^(?:\+33\s|0)[1-9](?:\s?\d\d){4}$" />
                    <?php addErrorMessage($errors, 'phone'); ?><br />
                </fieldset>

                <input type="submit" name="submit" value="Modifier" />
            </form>

            <a href="index.php?route=accueil">Retour à l'accueil</a>
        <?php endif; ?>
    </main>
</body>

</html>