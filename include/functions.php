<?php

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



