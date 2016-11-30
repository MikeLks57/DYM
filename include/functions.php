<?php 
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