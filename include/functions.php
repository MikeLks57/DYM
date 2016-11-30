<?php  


//à côté de la plaque...//

/*
require 'connection.php';
$conn    = Connect();
$name    = $conn->real_escape_string($_POST['nom']);
$email   = $conn->real_escape_string($_POST['mail']);
$message = $conn->real_escape_string($_POST['message']);
$query   = "INSERT into users (name,mail,sujet,message) VALUES('" . $name . "','" . $email . "','" . $message . "')";
$success = $conn->query($query);
 
if (!$success) {
    die("Couldn't enter data: ".$conn->error);
 
}
 
echo "message envoyé! merci! <br>";
 
$conn->close();
 
*/




/*echo $_SESSION['user']['login'];*/

  function sendMail ($destinataire, $Subject, $Body, $AltBody) {
    require 'vendor/autoload.php';

    $mail = new PHPMailer();

    $mail->isSMTP();                                      	// On va se servir de SMTP
    $mail->Host = 'smtp.gmail.com';  						// Serveur SMTP
    $mail->SMTPAuth = true;                               	// Active l'autentification SMTP
    $mail->Username = 'wf3.mailer@gmail.com';            	// SMTP username
    $mail->Password = 'something';                   		// SMTP password
    $mail->SMTPSecure = 'ssl';                            	// TLS Mode
    $mail->Port = 587;                                    	// Port TCP à utiliser

    // $mail->SMTPDebug = 2;

    $mail->setFrom($_SESSION['users']['mail'] , 'Mon site web', false);
    $mail->addAddress($destinataire, "Admin");     			// Ajouter un destinataire
   /* $mail->addAddress('jaffarn@example.com');             // Le nom est optionnel
    $mail->addReplyTo('contact@monsite.fr', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');*/

    $mail->isHTML(true);                                  	 // Set email format to HTML

    $mail->Subject = $Subject;
    $mail->Body    = $Body;
    $mail->AltBody = $AltBody;

    if(!$mail->send()) {
        echo 'Le message n\'a pas pu être envoyé';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Le message a été envoyé';
    }
}/* end sendMail*/



function getUserFromMail($pdo, $mail) {
	$sql = 'SELECT firstname, lastname, password, mail FROM users WHERE mail = :mail LIMIT 1;';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['mail' => $mail]);
    return $stmt->fetch();
}

function getAdminMail($pdo) {
	$sql = 'SELECT mail FROM users LIMIT 1';
	$result = $pdo->query($sql);
	$userInfos = $result->fetch();
	return $userInfos['mail'];
}
