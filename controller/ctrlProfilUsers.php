<?php

$formErrors = array();
$regexAlias = '/^[a-zA-Z0-9éèêçîô \'-.]+$/';
$isSucess = FALSE;
$isError = FALSE;

// je vérifie que le post de validation de mon formulaire existe 
if (isset($_POST['modifySubmit'])) {
    //si  le post de mon alias et différent de vide
    if (!empty($_POST['alias'])) {
        // je compare ma regex aux post insérer par l'utilisateur si cela correspond j'instancie ma variable au post de mon utilisateur
        if (preg_match($regexAlias, $_POST['alias'])) {
            $alias = htmlspecialchars($_POST['alias']);
        } else {
            //sinon je stocke mon message d'erreur dans un tableau
            $formErrors['alias'] = 'Saisie invalide';
        }
    } else {
        //sinon je stocke mon message d' erreur dans un tableau
        $formErrors['alias'] = 'le champs est vide';
    }
    if (!empty($_POST['password']) && !empty($_POST['passwordConfirm'])) {
        if ($_POST['password'] == $_POST['passwordConfirm']) {
            // je hash le password pour qu'il soit crypter dans ma base de données
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        } else {
            $formErrors['password'] = 'Les mots de passe doivent étre identiques';
        }
    } else {
        $formErrors['password'] = 'veuillez insérez votre mot de passe ou modifier le';
    }
    if (!empty($_POST['mail'])) {
        // j' utilise la fonction php filter_var pour vérifier que la chaine de caractére ressemble a un email
        if (filter_var(($_POST['mail']), FILTER_VALIDATE_EMAIL)) {
            $mail = htmlspecialchars($_POST['mail']);
        } else {
            $formErrors['mail'] = 'Saisie invalide';
        }
    } else {
        $formErrors['mail'] = 'le champs est vide';
    }
    if (count($formErrors) == 0) {
        $users = new users();
        $users->id = $_SESSION['userId'];
        $users->alias = $alias;
        $users->password = $password;
        $users->mail = $mail;
        //Si on un alias correspondant dans la table jero_users
        if ($users->checkFreeAliasProfil() != 0) {
            //On stocke un message d'erreur
            $formErrors['alias'] = 'Pseudo déja enregistré';
        }
        //Si on un mail correspondant dans la table jero_users
        if ($users->checkFreeMailProfil() != 0) {
            //On stocke un message d'erreur
            $formErrors['mail'] = 'Adresse mail déja enregistrée';
        }
        //Si on a pas de message d'erreur on crée l'utilisateur
        if (count($formErrors) == 0) {
            // Si l' utilisateur est créer
            if ($users->getModifyUsersSelect()) {
                // on met le booleen a true  pour avoir le message de succés
                $isSucess = TRUE;
            } else {
                // on met le booleen a true  pour avoir le message de d'erreur
                $isError = TRUE;
            }
        }
    }
}

//Si on a un POST qui correspond a une suppression
if (isset($_POST['deleteSubmit'])) {
    $user = new users();
    $user->id = htmlspecialchars($_SESSION['userId']);
    //on execute un requete pour suprrimer l'utilisateur
    //grace a DELETE CASCADE, ses commentaires et articles sont supprimés aussi
    $user->deleteUsersSelect();
    //on le deconnecte
    session_destroy();
    //et on le redirige sur l'index
    header('Location:index.php');
}
// j'instancie un nouvelle objet users le new fait appele a la méthode magique __construct
$users = new users();
$users->id = $_SESSION['userId'];
//On stocke le resultat de getUsersSelect() dans $usersinfo
$usersInfo = $users->getUsersSelect();
?>