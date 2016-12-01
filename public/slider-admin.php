<?php 

require_once 'header-admin.php';

if (isset($_POST['send-file'])) {
    $errors = [];
    // Vérifier si le téléchargement du fichier n'a pas été interrompu
    if ($_FILES['picture']['error'] != UPLOAD_ERR_OK) {
        // A ne pas faire en-dehors du DOM, bien sur.. En réalité on utilisera une variable intermédiaire
        $errors['picture'] = 'Merci de choisir un fichier';
    } else {
        // Objet FileInfo
        $finfo = new finfo(FILEINFO_MIME_TYPE);

        // Récupération du Mime
        $mimeType = $finfo->file($_FILES['picture']['tmp_name']);

        $extFoundInArray = array_search(
            $mimeType, array(
                'bmp' => 'image/bmp',
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                )
            );
        if ($extFoundInArray === false) {
            $errors['picture'] =  'Le fichier n\'est pas une image';
        } else {
            // Renommer nom du fichier
            $shaFile = sha1_file($_FILES['picture']['tmp_name']);
            $nbFiles = 0;
            $fileName = ''; // Le nom du fichier, sans le dossier
            do {
                $fileName = $shaFile . $nbFiles . '.' . $extFoundInArray;
                $fullPath = '../include/uploads/' . $fileName;
                $nbFiles++;
            } while(file_exists($fullPath));

            $infos = getimagesize($_FILES['picture']['tmp_name']);
            $width = $infos[0];
            $height = $infos[1];

            if($width < 50 || $height < 50) {
                $errors['picture'] = 'L\'image doit mesurer plus de 50px de hauteur et de largeur';
            }

            $size = $_FILES['picture']['size'];
            if($size > 10000000) {
                // Si l'image fait plus de 10 Mo
                $errors['picture'] = 'L\'image est trop lourde (plus de 10 Mo)';
            }

            // Maintenant, on ajoute en base, et on place le fichier temporaire dans le dossier uploads/
            if(count($errors) == 0) {
                if (empty($getpicture)) {
                    addpicture($fileName, $_POST['alt'], $idUser);// ATTENTION ID USER ENTRER EN DURE A CHANGER PLUTARD
                    $getpicture = getpicture($idUser);
                } else {
                    unlink('../include/uploads/' . $getpicture['url'] );
                    updatepicture($fileName, $_POST['alt'], $idUser);
                    $getpicture = getpicture($idUser);
                }
                
                $moved = move_uploaded_file($_FILES['picture']['tmp_name'], $fullPath);
                if (!$moved) {
                    $errors['picture'] = 'Erreur lors de l\'enregistrement';
                }
            }
        }
    } // Fin si fichier présent
}
?>

<form enctype="multipart/form-data" action="#" method="POST">  
    Sélectionner le fichier : <input name="picture" type="file" />
    <?php if(isset($errors['picture'])) echo $errors['picture'] ?>
    Entrer un texte alternatif: <input type="text" name="alt">
    <input type="submit" name="send-file" value="Envoyer le fichier" />
</form>