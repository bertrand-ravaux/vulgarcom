<?php include '../config.php' ?>
<?php include '../controller/ctrlUsersList.php'; ?>
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
        <?php include 'navbar.php'; ?>
        <div class="container userError">
            <?php if ($isSucess) { ?>
                <div class="alert alert-success ">Le grade de l'utilisateur à bien été mis jour</div>
            <?php } if ($isError) { ?>
                <p class="alert alert-danger ">Le grade de l'utilisateur n'a pu être mis a jour</p>
            <?php } ?>
        </div>
        <div class="container">
            <div class ="row">
                <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-12 col-12">
                    <table class="table-responsive tableUsers">
                        <thead>
                            <tr>
                                <th>Pseudo</th>
                                <th>Mail</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php //On parcours la liste des utilisateurs et on les affiche
                            foreach ($userList as $user) {
                                ?>
                                <tr>
                                    <td><?= $user->alias ?></td>
                                    <td><?= $user->mail ?></td>
                                    <td>
                                        <form method="POST" action="">
                                            <select name="userStatus">
                                                <?php
                                                foreach ($userStateList as $state) {
                                                    //cette ternaire permet de selectionner le grade actuel de l'utilisateur dans le select
                                                    //en ajoutant selected en html si l'id du status est egal a l'id du status de l'user'
                                                    ?>
                                                    <option value="<?= $state->id ?>" <?= $state->id == $user->status ? 'selected="selected"' : '' ?>><?= $state->status ?></option>

                                                <?php } ?>
                                            </select>
                                            <input type="hidden" name="userId" value="<?= $user->id ?>">
                                            <button type="submit" name="updateUserStatus" class="btn btn-primary">Modifier</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>
