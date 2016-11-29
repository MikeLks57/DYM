<?php

	function addPicturePf($pdo, $url, $title, $legend, $alt, $idUser) 
	{
    
	    $sql = 'INSERT INTO pictures (url, title, legend, alt, idUser) VALUES(:url, :title, :legend, :alt, :idUser)';
	    $stmt = $pdo->prepare($sql);
	    $stmt->bindParam(':url', $url);
	    $stmt->bindParam(':title', $title);
	    $stmt->bindParam(':legend', $legend);
	    $stmt->bindParam(':alt', $alt);
	    $stmt->bindParam(':idUser', $idUser);
	    $stmt->execute();
	}

	

