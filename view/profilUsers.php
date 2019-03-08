<?php include '../config.php'; ?>
<?php include '../controller/ctrlProfilUsers.php'; ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Vulgarcom</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <script src="../assets/js/jquery-3.3.1.min.js"></script>
        <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/style.css">
        <link rel="shortcut icon" type="image/png" href="../assets/img/favIconh2o.ico"/>
    </head>
    <body>
        <?php include 'navbar.php' ?>
        <div class="container userError">
            <?php if ($isSucess) { ?>
                <p class="alert alert-success">Votre Profil a était modifié</p>
            <?php } if ($isError) { ?>
                <p class="alert alert-danger">Votre Profil n'a pas plus étre modifier </p>
            <?php } ?>
        </div>
        <div class="container">
            <form method="POST" action="#">
                <div class="profilManagement">
                    <div class="form-group">
                        <label for="alias">Pseudo :</label>
                        <input name="alias" type="text" class="form-control pseudo" value="<?= $usersInfo->alias ?>" />
                        <p class="text-danger"><?= isset($formErrors['alias']) ? $formErrors['alias'] : '' //Si on on a des formErrors on les affiche?></p>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe :</label>
                        <input name="password" type="password" class="form-control password" placeholder="Modifier votre mot de passe"/>
                        <p class="text-danger"><?= isset($formErrors['password']) ? $formErrors['password'] : '' ?></p>
                    </div>
                    <div class="form-group">
                        <label for="passwordConfirm"> Confirmation du mot de passe :</label>
                        <input name="passwordConfirm" type="password" class="form-control password" placeholder="Confirmer votre mot de passe"/>
                        <p class="text-danger"><?= isset($formErrors['password']) ? $formErrors['password'] : '' ?></p>
                    </div>
                    <div class="form-group">
                        <label for="mail">Mail :</label>
                        <input type="text" name="mail" class="form-control mail" placeholder="example@example.com" value="<?= $usersInfo->mail ?>"/>
                        <p class="text-danger"><?= isset($formErrors['mail']) ? $formErrors['mail'] : '' ?></p>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary " name="modifySubmit">Modifier!</button>
                <button type="submit" class="btn btn-danger " name="deleteSubmit">Supprimer!</button>
            </form>
        </div>
        <?php include 'footer.php' ?>
    </body>
</html>

