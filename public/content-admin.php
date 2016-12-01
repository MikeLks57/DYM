<?php

require_once 'header-admin.php';

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
							<textarea name="post" id="post" cols="80" rows="30" placeholder="Ecrivez ici votre article"></textarea>
						</p>
						<p>
							<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
							<input type="file" name="postPic">
							<?php if(isset($errors['postPic'])) echo $errors['postPic'] ?>
						</p>
						<p>
							<input type="text" name="postLegend" placeholder="Légende de l'image">
							<?php if(isset($errors['postLegend'])) echo $errors['postLegend'] ?>
						</p>
						<p>
							<label for="postAlt">Saisissez ici un texte alternatif pour votre image</label>
							<input type="text" name="postAlt" placeholder="Texte alternatif">
							<?php if(isset($errors['postAlt'])) echo $errors['postAlt'] ?>
						</p>
						<p>
							<input type="submit" name="postSubmit" value="Envoyer">
						</p>
					</fieldset>
				</form>
			</section>
		</div>
	</main>
	
</body>
</html>