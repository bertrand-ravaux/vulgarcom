<?php

$formError = array();
$regexAlias = '/^[a-zA-Z0-9éèêçîô \'-.]+$/';
$isErrorLogin = FALSE;


if (isset($_POST['loginSubmit'])) {
    if (!empty($_POST['alias'])) {
        // je compare ma regex aux post insérer par l'utilisateur si cela correspond j'instancie ma variable au post de mon utilisateur
        if (preg_match($regexAlias, $_POST['alias'])) {
            $alias = htmlspecialchars($_POST['alias']);
        } else {
            //sinon je stocke mon message d'erreur dans un tableau
            $formError['alias'] = 'Saisie invalide';
        }
    } else {
        //sinon je stocke mon message d' erreur dans un tableau
        $formError['alias'] = 'le champs est vide';
    }
    if (!empty($_POST['password'])) {
        if ($_POST['password']) {
            // je hash le password pour qu'il soit crypter dans ma base de données
            $password = htmlspecialchars($_POST['password']);
        }
    } else {
        $formError['password'] = 'le champs est vide';
    }
    if (count($formError) == 0) {
        $users = new users();
        $users->alias = $alias;
        //on recupere les information de l'utilisateur via son alias
        $userInfo = $users->LoginUsersSelect();
        //si on a un résultat
        if ($userInfo) {
            //si l'utilisateur n'est pas banni
            if ($userInfo->status != 5) {
                //si le mot de passe est le bon
                if (password_verify($password, $userInfo->password)) {
                    //on cree nos variables de session correspondantes a l'utlisateur
                    $_SESSION['userAlias'] = $alias;
                    $_SESSION['userId'] = $userInfo->id;
                    $_SESSION['userRank'] = $userInfo->status;
                    //on redirige sur l'accueil apres la connexion
                    header('Location:index.php');
                    //sinon on affiche un message d'erreur
                } else {
                    $isErrorLogin = TRUE;
                }
            //on affiche un message d'erreur si l'utilisateur est banni
            }else {
                $formError['alias'] = 'Utilisateur banni';
            }
        //on affiche un message d'erreur si on ne trouve pas l'utilisateur
        } else {
            $formError['alias'] = 'Utilisateur non trouvé';
        }
    }
}
//Si on a un POST logoutSubmit
if (isset($_POST['logoutSubmit'])) {
    //on deconnecte l'utilisateur
    session_destroy();
    //on le redirige sur l'index avec un chemin absolu  pour la zone admin
    header('Location:http://vulgarcom/view/index.php');
}

