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

	<h1>Créez ici votre nouvel article</h1>

	<main>
		<div class="content">
			<section class="form">
				<form enctype="multipart/form-data" action="#" method="post" id="postForm">
					<fieldset>
						<p>
							<input type="text" name="postTitle" placeholder="Titre de l'article">
							<?php if(isset($errors['postTitle'])) echo $errors['postTitle'] ?>
						</p>
						<p>
							<textarea name="posy" id="post" cols="30" rows="30"></textarea>
						</p>
						<p>
							<input type="text" name="postLegend" placeholder="Légende de l'image">
							<?php if(isset($errors['postLegend'])) echo $errors['postLegend'] ?>
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
		</div>
	</main>
	
</body>
</html>