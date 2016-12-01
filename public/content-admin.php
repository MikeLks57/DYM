<?php

require_once 'header-admin.php';



if (isset($_POST['postSubmit'])) {
	$errors = [];
	if (empty($_POST['postTitle'])) {
		$errors['postTitle'] = 'Entrer un titre';
	} else {
		$title = $_POST['postTitle'];
	};

	if (empty($_POST['post'])) {
		$errors['post'] = 'Entrer le texte de votre article';
	} else {
		$content = $_POST['post'];
	}
	
	if (empty($_POST['postAlt'])) {
		$errors['postAlt'] = 'Entrer un texte alernatif pour votre image';
	} else {
		$alt = $_POST['postAlt'];
	}

	if ($_FILES['postPic']['error'] != UPLOAD_ERR_OK) {
        // A ne pas faire en-dehors du DOM, bien sur.. En réalité on utilisera une variable intermédiaire
        $errors['postPic'] = 'Merci de choisir une image';
    } else {
        // Objet FileInfo
        $finfo = new finfo(FILEINFO_MIME_TYPE);

        // Récupération du Mime
        $mimeType = $finfo->file($_FILES['postPic']['tmp_name']);

        $extFoundInArray = array_search(
            $mimeType, array(
                'bmp' => 'image/bmp',
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            )
        );
        if ($extFoundInArray === false) {
            $errors['postPic'] =  'Le fichier n\'est pas une image';
        } else {
            // Renommer nom du fichier
            $shaFile = sha1_file($_FILES['postPic']['tmp_name']);
            $nbFiles = 0;
            $fileName = ''; // Le nom du fichier, sans le dossier
            do {
                $fileName = $shaFile . $nbFiles . '.' . $extFoundInArray;
                $fullPath = '../include/uploads/' . $fileName;
                $nbFiles++;
            } while(file_exists($fullPath));

            $infos = getimagesize($_FILES['postPic']['tmp_name']);
            $width = $infos[0];
            $height = $infos[1];

            if($width < 50 || $height < 50) {
                $errors['postPic'] = 'L\'image doit mesurer plus de 50px de hauteur et de largeur';
            }

            $size = $_FILES['postPic']['size'];
            if($size > 5000000) {
                // Si l'image fait plus de 5 Mo
                $errors['postPic'] = 'L\'image est trop lourde (plus de 5 Mo)';
            }

            // Maintenant, on ajoute en base, et on place le fichier temporaire dans le dossier uploads/
            if(count($errors) == 0) {
                $idPicture = addPicture($pdo, $fileName, $alt, $idUser);
                addContent($title, $content, $idPicture, $idUser);
                $moved = move_uploaded_file($_FILES['postPic']['tmp_name'], $fullPath);
                $display = true;
                if (!$moved) {
                    $errors['postPic'] = 'Erreur lors de l\'enregistrement';
                }

            }
        }
    }

	

	
	
}

?>

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
							<?php if(isset($errors['post'])) echo $errors['post'] ?>
						</p>
						<p>
							<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
							<input type="file" name="postPic">
							<?php if(isset($errors['postPic'])) echo $errors['postPic'] ?>
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