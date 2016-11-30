<?php 
session_start();
require_once '../include/dBConnection.php';
require_once '../include/functions.php';

if (isset($_POST['send-file'])) {
	$errors = [];
	// Vérifier si le téléchargement du fichier n'a pas été interrompu
	if ($_FILES['avatar']['error'] != UPLOAD_ERR_OK) {
        // A ne pas faire en-dehors du DOM, bien sur.. En réalité on utilisera une variable intermédiaire
		$errors['avatar'] = 'Merci de choisir un fichier';
	} else {
        // Objet FileInfo
		$finfo = new finfo(FILEINFO_MIME_TYPE);

        // Récupération du Mime
		$mimeType = $finfo->file($_FILES['avatar']['tmp_name']);

		$extFoundInArray = array_search(
			$mimeType, array(
				'bmp' => 'image/bmp',
				'jpg' => 'image/jpeg',
				'png' => 'image/png',
				'gif' => 'image/gif',
				)
			);
		if ($extFoundInArray === false) {
			$errors['avatar'] =  'Le fichier n\'est pas une image';
		} else {
            // Renommer nom du fichier
			$shaFile = sha1_file($_FILES['avatar']['tmp_name']);
			$nbFiles = 0;
            $fileName = ''; // Le nom du fichier, sans le dossier
            do {
            	$fileName = $shaFile . $nbFiles . '.' . $extFoundInArray;
            	$fullPath = '../include/uploads/' . $fileName;
            	$nbFiles++;
            } while(file_exists($fullPath));

            $infos = getimagesize($_FILES['avatar']['tmp_name']);
            $width = $infos[0];
            $height = $infos[1];

            if($width < 50 || $height < 50) {
            	$errors['avatar'] = 'L\'image doit mesurer plus de 50px de hauteur et de largeur';
            }

            $size = $_FILES['avatar']['size'];
            if($size > 10000000) {
                // Si l'image fait plus de 10 Mo
            	$errors['avatar'] = 'L\'image est trop lourde (plus de 10 Mo)';
            }

            // Maintenant, on ajoute en base, et on place le fichier temporaire dans le dossier uploads/
            if(count($errors) == 0) {
            	addAvatar($fileName, $_FILES['avatar']['tmp_name'], 1);// ATTENTION ID USER ENTRER EN DURE A CHANGER PLUTARD
            	$moved = move_uploaded_file($_FILES['avatar']['tmp_name'], $fullPath);
            	if (!$moved) {
            		$errors['avatar'] = 'Erreur lors de l\'enregistrement';
            	}
            }
        }
    } // Fin si fichier présent
}
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
	<form enctype="multipart/form-data" action="#" method="POST">
		Votre nom: <input type="text">
		Avatar: Sélectionner le fichier : <input name="avatar" type="file" />
		<?php if(isset($errors['avatar'])) echo $errors['avatar'] ?>
		<input type="submit" name="send-file" value="Envoyer le fichier" />
		
	</form>
</body>
</html>