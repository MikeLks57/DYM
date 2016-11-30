<?php 
function getUser($idUser){
    global $pdo;

    $sql =  'SELECT idUser, firstname, lastname, mail, password, owner FROM users WHERE idUser = :idUser';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idUser', $idUser);
    $stmt->execute();
    return $stmt->fetch();
}

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