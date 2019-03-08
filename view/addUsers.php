<?php include '../config.php' ?>
<?php include '../controller/ctrlAddUsers.php' ?>
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
            <div class="alert alert-success col-7 offset-2">Bienvenue dans la communautée Vulgarcom </div>   
        <?php } if ($isError) { ?>
            <div class="alert alert-danger col-7 offset-2"> Désolé vous n' avez pas était enregistré </div>
        <?php } ?>
        </div>
        <div class="container">
            <form method="POST" action="">
                <div class="addUsers">
                    <div class="form-group">
                        <label for="alias">Pseudo :</label>
                        <input name="alias" type="text" class="form-control"  placeholder="science02"/>
                        <p class="text-danger"><?= isset($formErrors['alias']) ? $formErrors['alias'] : '' //Si on on a des formErrors on les affiche?></p>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe :</label>
                        <input name="password" type="password" class="form-control" placeholder="remplir le champ"/>
                        <p class="text-danger"><?= isset($formErrors['password']) ? $formErrors['password'] : '' ?></p>
                    </div>
                    <div class="form-group">
                        <label for="passwordConfirm"> Confirmation du mot de passe :</label>
                        <input name="passwordConfirm" type="password" class="form-control" placeholder="remplir le champ"/>
                        <p class="text-danger"><?= isset($formErrors['password']) ? $formErrors['password'] : '' ?></p>
                    </div>
                    <div class="form-group">
                        <label for="mail">Mail :</label>
                        <input type="text" name="mail" class="form-control" placeholder="example@example.com"/>
                        <p class="text-danger"><?= isset($formErrors['mail']) ? $formErrors['mail'] : '' ?></p>
                    </div>
                </div>
                <button type="submit" class="btn btn-danger validateButton" name="formSubmit">Valider!</button>
            </form>
        </div>
        <?php include 'footer.php' ?>
    </body>
</html>
