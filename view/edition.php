<!DOCTYPE html>
<html lang="fr">

<?php
include(__DIR__ . "/includes/head.inc.php");
?>

<body>
    <?php
    include("includes/header.inc.php");
    ?>

    <main class="main-form-page">
        <?php if (isset($errors['deletedProfil'])) : ?>
            <p class='error-field'>Une erreur est survenu : votre profil a été supprimé</p>
        <?php else : ?>
            <h1>Bienvenue sur l'espace de modification du profil</h1>

            <form method="post" action='#'>
                <fieldset>
                    <legend>Changement de mot de passe</legend>

                    <div>
                        <label for="prevPassword">Ancien mot de passe :</label>
                        <div class="form-input-container <?php if (isset($errors["prevPassword"])) echo "error-field" ?>">
                            <input type="password" name="prevPassword" id="prevPassword" />
                            <?php if (isset($errors["prevPassword"]))
                                echo '<span>' . $errors["prevPassword"] . '</span>';
                            ?>
                        </div>
                    </div>


                    <div>
                        <label for="newPassword">Nouveau mot de passe :</label>
                        <div class="form-input-container <?php if (isset($errors["newPassword"])) echo "error-field" ?>">
                            <input type="password" name="newPassword" id="newPassword" />
                            <?php if (isset($errors["newPassword"]))
                                echo '<span>' . $errors["newPassword"] . '</span>';
                            ?>
                        </div>
                    </div>


                    <div>
                        <label for="confirmPassword">Confimer le mot de passe :</label>
                        <div class="form-input-container <?php if (isset($errors["confirmPassword"])) echo "error-field" ?>">
                            <input type="password" name="confirmPassword" id="confirmPassword" />
                            <?php if (isset($errors["confirmPassword"]))
                                echo '<span>' . $errors["confirmPassword"] . '</span>';
                            ?>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Informations personnelles</legend>

                    <div>
                        <label for="gender">Sexe :</label>
                        <div class="form-input-container <?php if (isset($errors["gender"])) echo "error-field" ?>">
                            <div>
                                <div>
                                    <input type="radio" name="gender" value="h" id="gender-h" <?= (isset($postedValues["gender"]) && $postedValues["gender"] === "h") ? "checked" : "" ?> />
                                    <label for="gender-h" class="input-radio-label">Homme</label>
                                </div>
                                <div>
                                    <input type="radio" name="gender" value="f" id="gender-f" <?= (isset($postedValues["gender"]) && $postedValues["gender"] === "f") ? "checked" : "" ?> />
                                    <label for="gender-f" class="input-radio-label">Femme</label>
                                </div>
                            </div>
                            <?php if (isset($errors["gender"]))
                                echo '<span>' . $errors["gender"] . '</span>';
                            ?>
                        </div>
                    </div>


                    <div>
                        <label for="name">Nom :</label>
                        <div class="form-input-container <?php if (isset($errors["name"])) echo "error-field" ?>">
                            <input type="text" name="name" id="name" value="<?= isset($postedValues['name']) ? $postedValues['name'] : '' ?>" />
                            <?php if (isset($errors["name"]))
                                echo '<span>' . $errors["name"] . '</span>';
                            ?>
                        </div>
                    </div>

                    <div>
                        <label for="fname">Prénom :</label>
                        <div class="form-input-container <?php if (isset($errors["fname"])) echo "error-field" ?>">
                            <input type="text" name="fname" id="fname" value="<?= isset($postedValues['fname']) ? $postedValues['fname'] : '' ?>" />
                            <?php if (isset($errors["fname"]))
                                echo '<span>' . $errors["fname"] . '</span>';
                            ?>
                        </div>
                    </div>

                    <div>
                        <label for="email">Adresse électronique :</label>
                        <div class="form-input-container <?php if (isset($errors["email"])) echo "error-field" ?>">
                            <input type="email" name="email" id="email" value="<?= isset($postedValues['email']) ? $postedValues['email'] : '' ?>" />
                            <?php if (isset($errors["email"]))
                                echo '<span>' . $errors["email"] . '</span>';
                            ?>
                        </div>
                    </div>

                    <div>
                        <label for="birthdate">Date de naissance :</label>
                        <div class="form-input-container <?php if (isset($errors["birthdate"])) echo "error-field" ?>">
                            <input type="date" name="birthdate" id="birthdate" placeholder='jj/MM/AAAA' value="<?= isset($postedValues['birthdate']) ? $postedValues['birthdate'] : '' ?>" />
                            <?php if (isset($errors["birthdate"]))
                                echo '<span>' . $errors["birthdate"] . '</span>';
                            ?>
                        </div>
                    </div>


                    <div>
                        <label for="address">Adresse postale </label>
                        <div class="form-input-container <?php if (isset($errors["address"])) echo "error-field" ?>">
                            <input type="text" name="address" id="address" placeholder="Adresse" value="<?= isset($postedValues['address']) ? $postedValues['address'] : '' ?>" />
                            <?php if (isset($errors["address"]))
                                echo '<span>' . $errors["address"] . '</span>';
                            ?>
                        </div>
                        <div class="form-input-container <?php if (isset($errors["postcode"])) echo "error-field" ?>">
                            <input type="text" name="postcode" id="postcode" placeholder="Code postal" value="<?= isset($postedValues['postcode']) ? $postedValues['postcode'] : '' ?>" />
                            <?php if (isset($errors["postcode"]))
                                echo '<span>' . $errors["postcode"] . '</span>';
                            ?>
                        </div>
                        <div class="form-input-container <?php if (isset($errors["city"])) echo "error-field" ?>">
                            <input type="text" name="city" id="city" placeholder="Ville" value="<?= isset($postedValues['city']) ? $postedValues['city'] : '' ?>" />
                            <?php if (isset($errors["city"]))
                                echo '<span>' . $errors["city"] . '</span>';
                            ?>
                        </div>
                    </div>


                    <div>
                        <label for="phone">Numéro de téléphone :</label>
                        <div class="form-input-container <?php if (isset($errors["phone"])) echo "error-field" ?>">
                            <input type="tel" name="phone" id="phone" placeholder='0X XX XX XX XX' value="<?= isset($postedValues['phone']) ? $postedValues['phone'] : '' ?>" pattern="^0\d(?:\s?\d{2}){4}$" />
                            <?php if (isset($errors["phone"]))
                                echo '<span>' . $errors["phone"] . '</span>';
                            ?>
                        </div>
                    </div>

                </fieldset>

                <button type="submit" name="submit">
                    Valider les modifications
                </button>

            </form>
        <?php endif; ?>
    </main>

    <?php
    include("includes/footer.inc.php");
    ?>
</body>

</html>