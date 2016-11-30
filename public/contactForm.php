<?php  

	session_start();

	require_once '../include/vendor/autoload.php';
	require_once '../include/dBConnection.php';
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

	    if(isset($_POST['surname'])) {
	        $surname = $_POST['surname'];
	        if(empty($surname)) {
	            $errors['surname']['empty'] = true;
	        }
	    }

	    if(isset($_POST['name'])) {
	        $name = $_POST['name'];
	        if(empty($name)) {
	            $errors['name']['empty'] = true;
	        }
	    }

	     if(isset($_POST['message'])) {
	        $message = $_POST['message'];
	        if(empty($message)) {
	            $errors['message']['empty'] = true;
	        }
	    }

	     if(isset($_POST['objet'])) {
	        $objet = $_POST['objet'];
	        if(empty($objet)) {
	            $errors['objet']['empty'] = true;
	        }
	    }

	    // Si pas d'erreur
	    if(count($errors) == 0) {

	    	$bodyHtml = '<h1>Nouveau message de ' . $surname . ' ' . $name . '</h1>' . $message;
	    	$bodyHtml = 'Nouveau message de ' . $surname . ' ' . $name . ' : '. $message;

	        //envoi du mail
	        sendMail(getAdminMail($pdo), $objet, $bodyHtml, $bodyPlain);
        }
    }


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<!--    <script src="assets/js/script.js"></script>  SCRIPT.JS TEMPORAIRE-->
	<title>Formulaire de Contact</title>
	<!-- <link rel="stylesheet" href=""> -->
</head>
<body>

	<h2>Contact</h2>

<!--Boites de dialogue interaction user-->
		<?php if(isset($errorMail)) echo '<dialog open>Merci de compléter tous les champs et de vérifier votre e-mail!</dialog>'; ?>
		<?php if(isset($_GET['action'])) echo 'merci de votre envoi!<br>'; ?>




 		 <form action="#" role="form" method="POST">

 		 		<label for="surname">Préom :</label><input type="text" name="surname" required placeholder="surname">
            	 <?php if(isset($errors['surname'])) {
        			if(isset($errors['surname']['empty']))
           		 	echo 'Merci de compléter ce truc';
    				 } ?>  <br>

            	<label for="name">Nom :</label><input type="text" name="name" required placeholder="name">
            	 <?php if(isset($errors['name'])) {
        			if(isset($errors['name']['empty']))
           		 	echo 'Merci de compléter ce champ';
    				 } ?>  <br>

            	<label for="mail">Adresse mail :</label><input type="text" name="mail"  required placeholder="mail" value="<?php if(isset($mail)) echo $mail ?>">
				<?php if(isset($errors['mail'])) {
    					if(isset($errors['mail']['empty']))
       					 echo 'Merci de compléter ce champ';
    					elseif(isset($errors['mail']['invalid']))
        				echo 'Le mail n\'est pas valide';
						} ?>  <br>

            	<label for="objet">Objet :</label><input type="text" name="objet" required placeholder="objet">
            	 <?php if(isset($errors['objet'])) {
        			if(isset($errors['objet']['empty']))
           		 	echo 'Merci de compléter ce champ';
    				 } ?>  <br>   

            	<label for="message">Message :</label><input type="text" name="message" required placeholder="message">
            	 <?php if(isset($errors['message'])) {
        			if(isset($errors['message']['empty']))
           		 	echo 'Merci de compléter ce champ';
    				 } ?>  <br>
            	   
          
            	<button type="submit" name="login">Envoyer</button>
        </form>







		 

	

/*$_SESSION['user']['login']*/

echo $_SESSION['user']['lastname'];

?>




	
</body>
</html>