<?php 

/*--------  fonction pour recuperer les infos de l'utilisateur ------*/

function getUserByMail($mail){
    global $pdo;

    $sql =  'SELECT idUser, firstname, lastname, mail, password, owner FROM users WHERE mail = :mail';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':mail', $mail);
    $stmt->execute();
    return $stmt->fetch();
}

function getUser($idUser){
	global $pdo;

    $sql =  'SELECT firstname, lastname, mail, password, owner FROM users WHERE idUser = :idUser';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idUser', $idUser);
    $stmt->execute();
    return $stmt->fetch();
}

/*----------  Fonction pour AVATAR  ----------*/


function addAvatar($url, $alt, $idUser)
{
    global $pdo;

    $sql = 'INSERT INTO avatars (url, alt, idUser) VALUES(:url, :alt, :idUser)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':url', $url);
    $stmt->bindParam(':alt', $alt);
    $stmt->bindParam(':idUser', $idUser);
    $stmt->execute();
}

function updateAvatar($url, $alt, $idUser){
    global $pdo;

    $sql = 'UPDATE avatars SET url = :url, alt = :alt WHERE idUser = :idUser';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':url', $url);
    $stmt->bindParam(':alt', $alt);
    $stmt->bindParam(':idUser', $idUser);
    $stmt->execute();
}

function getAvatar($idUser){
	global $pdo;

	$sql = 	'SELECT url, alt FROM avatars WHERE idUser = :idUser';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idUser', $idUser);
    $stmt->execute();
    return $stmt->fetch();

}

/*----------  Portfolio back  ----------*/


	function addPicture($pdo, $url, $alt, $idUser)
	{
		$sql = 'INSERT INTO pictures(url, alt, idUser) VALUES (:url, :alt, :idUser)';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':url', $url);
		$stmt->bindParam(':alt', $alt);
		$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
		$stmt->execute();
		$lastPic = $pdo->lastInsertId();
		return $lastPic;
	}

	function addPortfolio($pdo, $title, $legend, $idPicture, $idCategory)
	{
		$sql = 'INSERT INTO portfolios (title, legend, idPicture, idCategory) VALUES (:title, :legend, :idPicture, :idCategory)';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':title', $title);
	    $stmt->bindParam(':legend', $legend);
	    $stmt->bindParam(':idPicture', $idPicture, PDO::PARAM_INT);
	    $stmt->bindParam(':idCategory', $idCategory, PDO::PARAM_INT);
	    $stmt->execute();
	    $lastPf = $pdo->lastInsertId();
		return $lastPf;
	}

	function getPortfolio($pdo)
	{
		$sql = 'SELECT pictures.url, pictures.alt, portfolios.title, portfolios.legend FROM pictures INNER JOIN portfolios ON portfolios.idPicture = pictures.idPicture ORDER BY date_created DESC';
		$result = $pdo->query($sql);
		return $result;
	}

/*----------  Envoi de mail  ----------*/


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
}




