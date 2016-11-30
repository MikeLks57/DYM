<?php 
require_once '../include/dBConnection.php';
require_once '../include/functions.php';

$idUser = 1;
$getAvatar = getAvatar($idUser);
$getUser = getUser($idUser);

?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header id="Header" class="Header">
	<div>
		<img src="../include/uploads/<?php echo $getAvatar['url'] ?>" alt="<?php echo $getAvatar['alt'] ?>">
		<p><?php echo $getUser['firstname'] ?></p>
		<nav>
			<a href="index.php"><div>Accueil</div></a>
			<a href="portfolio.php"><div>Portfolio</div></a>
			<a href="contact.php"><div>Contact</div></a>
		</nav>
	</div>

</header><!-- /header -->