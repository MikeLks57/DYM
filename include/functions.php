<?php 
/*----------  fonction pour recuperer les infos de l'utilisateur  ----------*/

function getUser($idUser){
    global $pdo;

    $sql =  'SELECT idUser, firstname, lastname, mail, password, owner FROM users WHERE idUser = :idUser';
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


/*----------  -----------------  ----------*/

