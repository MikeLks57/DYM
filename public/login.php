<?php

session_start();

require_once '../include/dbConnection.php';
require_once '../include/functions.php';

if(isset($_POST['login'])) {

    $errors = [];

    if(isset($_POST['mail'])) {
        $mail = trim($_POST['mail']);
        if(empty($mail)) {
            $errors['mail']['empty'] = true;
        } elseif(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $errors['mail']['invalid'] = true;
        }
    }

    if(isset($_POST['password'])) {
        $pass = $_POST['password'];
        if(empty($pass)) {
            $errors['pass']['empty'] = true;
        }
    }

    // Si pas d'erreur
    if(count($errors) == 0) {

        // Récupération de l'utilisateur selon le mail
        $user = getUserByMail($mail);

        // Si le mot de passe correspond à celui enregistré en DB
        if($user['password'] === $pass) {
        /*if(password_verify($pass, $user['password'])) {*/
        //En temps normal, on utilise cette fonction lorsque le mot de passe a été haché   


            // Ajout de l'utilisateur en session
            $_SESSION['user'] = [
                'id'            => $user['idUser'],
                'mail'          => $user['mail'],
                'firstname'   => $user['firstname'],
                'lastname'    => $user['lastname'],
                'owner'       => $user['owner'],  
            ];

            header('Location: general-admin.php?action=login');
            exit;
        } else {
            $errorLogin = true;
        }
    }
}

?><!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion à l'espace administrateur</title>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="assets/js/script.js"></script>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <?php if(isset($errorLogin)) : ?>
        <p>Identifiants incorrects</p>
    <?php endif ; ?>
    <?php if(isset($_GET['action']) && $_GET['action'] == 'logoff') : ?>
        <dialog open>Vous êtes déconnecté</dialog>
    <?php endif ; ?>
    
    <br><br><br>

    <form action="#" method="post">
        <input type="email" name="mail" required placeholder="Votre email" value="<?php if(isset($mail)) echo $mail ?>">
        <?php if(isset($errors['mail'])) {
            if(isset($errors['mail']['empty']))
                echo 'Merci de compléter ce champ';
            elseif(isset($errors['mail']['invalid']))
                echo 'Le mail n\'est pas valide';
        } ?>
        <input type="password" name="password" required placeholder="Votre mot de passe">
        <?php if(isset($errors['pass'])) {
            if(isset($errors['pass']['empty']))
                echo 'Merci de compléter ce champ';
        } ?>
        <button type="submit" name="login">Connexion</button>
     </form>
</body>
</html>