<?php

session_start();

require_once '../include/dBConnection.php';
require_once '../include/functions.php';

if(isset($_POST['login'])) {
   

    $errors = [];


//email verifiaction//
    if(isset($_POST['mail'])) {
        $mail = trim($_POST['mail']);
        if(empty($mail)) {
            $errors['mail']['empty'] = true;
        } elseif(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $errors['mail']['invalid'] = true;
        }
    }


//pass verification//
    if(isset($_POST['password'])) {
        $pass = $_POST['password'];
        if(empty($pass)) {
            $errors['pass']['empty'] = true;
        }
    }
    if(count($errors) == 0) {

// User call according to mail//
        $user = getUserFromMail($pdo, $mail);

 
//DB Verify and connect//     
        if(password_verify($pass, $user['password'])) {
          
            $_SESSION['user'] = [
                'firstname' => $user['firstname'],
                'lastname' => $user['lastname'],
                'password' => $user['password'],
                'owner' => $user['owner'],
            ];

// Calling homepage ////   Code to add on homepage: 
// 
// if(!isset($_SESSION['user'])) { header('Location: login.php');  exit;}
//
// 

            header('Location: home.php?action=login');
            exit;
        } else {
            header('Location: login.php'); 
            exit;
           
            $errorLogin = true;
        }
    }
}


?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="assets/js/script.js"></script>
   <!-- <link href="https://fonts.googleapis.com/css?family=Rubik" rel="stylesheet">-->
    <!--<link rel="stylesheet" href="assets/css/styles.css">-->
</head>
<body>

    <?php if(isset($errorLogin)) : ?> 
        <p>Erreur de connection</p>
    <?php endif ; ?>
    <?php if(isset($_GET['action']) && $_GET['action'] == 'logoff') : ?>
        <dialog open>Vous êtes déconnecté</dialog>
    <?php endif ; ?>
    <br>
    <form action="#" method="post">
    <input type="email" name="mail" required placeholder="E-mail" value="<?php if(isset($mail)) echo $mail ?>">
<?php if(isset($errors['mail'])) {
    if(isset($errors['mail']['empty']))
        echo 'champ incomplet';
    elseif(isset($errors['mail']['invalid']))
        echo 'mail non valide';
} ?>
    <input type="password" name="password" required placeholder="Mot de passe">
    <?php if(isset($errors['pass'])) {
        if(isset($errors['pass']['empty']))

            echo 'Merci de compléter ce champ';

?>
    <button type="submit" name="login">Connexion</button>
</form>
</body>
</html>