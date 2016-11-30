<?php 
session_start();
require_once '../include/dBConnection.php';
require_once '../include/functions.php';


?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header id="mainHeader" class="mainHeader">
	<nav>
		<a href="general-admin.php"><div>Général</div></a>
		<a href="slider-admin.php"><div>Slider</div></a>
		<a href="content-admin.php"><div>Contenu de la home page</div></a>
		<a href="portfolio-admin.php"><div>Portfolio</div></a>
	</nav>
</header><!-- /header -->