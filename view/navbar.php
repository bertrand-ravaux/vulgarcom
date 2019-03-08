<?php include '../controller/ctrlLoginUsers.php'; ?>
<?php include '../controller/ctrlCategoryList.php'; ?>
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="#">Vulgarcom</a>
    <button class="navbar-toggler color" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <svg>
        <rect fill="white" width="34" height="3"/>
        <rect y="11" fill="white" width="34" height="3"/>
        <rect y="23" fill="white" width="34" height="3"/>
        </svg>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Acceuil<span class="sr-only">(current)</span></a>
            </li>
            <?php if (isset($_SESSION['userAlias'])) { ?>
                <li class="nav-item active">
                    <a class="nav-link" href="profilUsers.php">Profil</a>
                </li>
            <?php } else { ?>
                <li class="nav-item active">
                    <a class="nav-link" href="addUsers.php">Inscription</a>
                </li>
            <?php } ?>
            <li class="nav-item active">
                <a class="nav-link" href="articleList.php">Derniers articles</a>
            </li>
            <?php
            //Si l'utilisateur est connecté
            if (isset($_SESSION['userAlias'])) {
                //et qu'il est modérateur
                if ($_SESSION['userRank'] == 3) {
                    ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="usersList.php"> liste d'utilisateur</a>
                    </li>
                    <?php
                }
            }
            ?>
            <li class="nav-item dropdown">
                <?php
                //Si l'utilisateur est connecté
                if (isset($_SESSION['userAlias'])) {
                    //et qu'il est administrateur ou rédacteur
                    if ($_SESSION['userRank'] == 1 || $_SESSION['userRank'] == 2) {
                        ?>
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Rédacteur
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="addArticles.php">Créer un article</a>
                            <a class="dropdown-item" href="userArticleList.php">liste de vos articles</a>
                        </div>
                        <?php
                    }
                }
                ?> 
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Categorie
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php
                    //pour chaque catégorie on ajouter un lien dans notre dropdown
                    foreach ($categoriesList as $categories) {
                        ?>
                        <a class="dropdown-item" href="articleCategoryList.php?category=<?= $categories->id ?>"><?= $categories->name ?></a>   
                    <?php } ?>
                </div>
            </li>
            <li class="nav-item dropdown">
                <?php
                //Si l'utilisateur est connecté
                if (isset($_SESSION['userAlias'])) {
                    //et qu'il est administrateur
                    if ($_SESSION['userRank'] == 1) {
                        ?>
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Admin
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="../po_admin/articleListAdmin.php">Liste des articles</a>
                            <a class="dropdown-item" href="../po_admin/usersListAdmin.php">Liste des utilisateurs</a>
                        </div>
                        <?php
                    }
                }
                ?> 
            </li>
        </ul>
        <?php
        //Si l'utilisateur est connecté
        if (isset($_SESSION['userAlias'])) {
            ?>
            <div class="loginMsg">Bonjour <?= $_SESSION['userAlias'] ?> </div>
            <form method="POST" action="#" >
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit" name="logoutSubmit">Deconnexion</button>
            </form>
            <?php
        } else { //Sinon on lui affiche le formulaire de connexion
            ?>   
            <?php if ($isErrorLogin) { ?>
                <div> Désolé veuillez réesayer </div>
            <?php } ?>
            <p class="loginMsg"><?= isset($formError['password']) ? $formError['password'] : '' //Si on on a des formErrors on les affiche  ?></p>
            <p class="loginMsg"><?= isset($formError['alias']) ? $formError['alias'] : '' ?></p>
            <form class="form-inline my-2 my-lg-0" method="POST" action="#">
                <input class="form-control mr-sm-2" type="text" placeholder="Pseudonyme" aria-label="Pseudonyme" name="alias">
                <input class="form-control mr-sm-2"  placeholder="Mot de passe" aria-label="Mot de passe" type="password" name="password"><br />
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit" name="loginSubmit">Connexion</button>
            </form>
        <?php } ?>
    </div>
</nav>