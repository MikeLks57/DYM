<?php

session_start();

require_once '../include/dBConnection.php';
require_once '../include/functions.php';

// Vérifier qu'on soit bien connecté pour accéder à la page
if(!isset($_SESSION['user'])) { 
	header('Location: home.php');
} else {
	$idUser = $_SESSION['user']['id'];
}


//Je crée une variable qui va me permettre d'afficher un contenu en cas de succès de chargement du formulaire en bdd
$display = false;

// J'ai recu des données de formulaire
if (isset($_POST['pfSubmit'])) {

	$errors = [];

	//on vérifie que le titre est conforme
	if(isset($_POST['pfTitle'])) {
        $title = trim($_POST['pfTitle']);
        if(strlen($title) < 3 || strlen($title) > 50) {
            $errors['pfTitle'] = 'Le titre doit être compris entre 3 et 50 caractères';
        } else {
            $confirmTitle = $title;
        }
    }

    //on vérifie que la légende est conforme
    if(isset($_POST['pfLegend'])) {
        $legend = trim($_POST['pfLegend']);
        if(strlen($legend) < 3 || strlen($legend) > 50) {
            $errors['pfLegend'] = 'La légende doit être comprise entre 3 et 50 caractères';
        } else {
            $confirmLegend = $legend;
        }
    }

    //on vérifie que le texte alternatif est conforme
    if(isset($_POST['pfAlt'])) {
        $alt = trim($_POST['pfAlt']);
        if(strlen($alt) < 3 || strlen($alt) > 50) {
            $errors['pfAlt'] = 'Le texte alternatif doit être compris entre 3 et 50 caractères';
        } else {
            $confirmAlt = $alt;
        }
    }

    //on vérifie que le fichier image téléchargé est conforme
    // Vérifier si le téléchargement du fichier n'a pas été interrompu
    if ($_FILES['pfPic']['error'] != UPLOAD_ERR_OK) {
        // A ne pas faire en-dehors du DOM, bien sur.. En réalité on utilisera une variable intermédiaire
        $errors['pfPic'] = 'Merci de choisir une image';
    } else {
        // Objet FileInfo
        $finfo = new finfo(FILEINFO_MIME_TYPE);

        // Récupération du Mime
        $mimeType = $finfo->file($_FILES['pfPic']['tmp_name']);

        $extFoundInArray = array_search(
            $mimeType, array(
                'bmp' => 'image/bmp',
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            )
        );
        if ($extFoundInArray === false) {
            $errors['pfPic'] =  'Le fichier n\'est pas une image';
        } else {
            // Renommer nom du fichier
            $shaFile = sha1_file($_FILES['pfPic']['tmp_name']);
            $nbFiles = 0;
            $fileName = ''; // Le nom du fichier, sans le dossier
            do {
                $fileName = $shaFile . $nbFiles . '.' . $extFoundInArray;
                $fullPath = '../include/uploads/' . $fileName;
                $nbFiles++;
            } while(file_exists($fullPath));

            $infos = getimagesize($_FILES['pfPic']['tmp_name']);
            $width = $infos[0];
            $height = $infos[1];

            if($width < 50 || $height < 50) {
                $errors['pfPic'] = 'L\'image doit mesurer plus de 50px de hauteur et de largeur';
            }

            $size = $_FILES['pfPic']['size'];
            if($size > 5000000) {
                // Si l'image fait plus de 5 Mo
                $errors['pfPic'] = 'L\'image est trop lourde (plus de 5 Mo)';
            }

            // Maintenant, on ajoute en base, et on place le fichier temporaire dans le dossier uploads/
            if(count($errors) == 0) {
                $lastPicId = addPicture($pdo, $fileName, $confirmAlt, 1);
                echo $lastPicId;
                addPortfolio($pdo, $confirmTitle, $confirmLegend, $lastPicId, 1);
                $moved = move_uploaded_file($_FILES['pfPic']['tmp_name'], $fullPath);
                $display = true;
                if (!$moved) {
                    $errors['pfPic'] = 'Erreur lors de l\'enregistrement';
                }
            }
        }
    } // Fin si fichier présent



}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>

	<h1>Portfolio</h1>

	<main>
		<section class="form">
			<form enctype="multipart/form-data" action="#" method="post" id="portfolioForm">
				<fieldset>
					<p>
						<input type="text" name="pfTitle" placeholder="Titre">
						<?php if(isset($errors['pfTitle'])) echo $errors['pfTitle'] ?>
					</p>
					<p>
						<input type="text" name="pfLegend" placeholder="Légende">
						<?php if(isset($errors['pfLegend'])) echo $errors['pfLegend'] ?>
					</p>
					<p>
						<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
						<input type="file" name="pfPic">
						<?php if(isset($errors['pfPic'])) echo $errors['pfPic'] ?>
					</p>
					<p>
						<label for="pfAlt">Saisissez ici un texte alternatif pour votre image</label>
						<input type="text" name="pfAlt" placeholder="Texte alternatif">
						<?php if(isset($errors['pfAlt'])) echo $errors['pfAlt'] ?>
					</p>
					<p>
						<input type="submit" name="pfSubmit" value="Envoyer">
					</p>
				</fieldset>
			</form>
		</section>
		<br><br>
		<?php if($display) : ?>
			<section class="envoiConfirm">
				<div class="confirm">
					<p>Votre portfolio a bien été chargé!</p>
				</div>
			</section>
		<?php endif ; ?>
	</main>
	
</body>
</html>

	

