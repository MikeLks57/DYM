<?php

$options = array(
    PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND    => 'SET NAMES \'UTF8\'',
);
$strConnection = 'mysql:host=localhost;dbname=dym';
$pdo = new PDO($strConnection, 'root', '', $options);



// a côté de la plaque...
/*function Connect()
{
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "";
 $dbname = "DYM";
 
 // Creation de la connection avec mysqli

 $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die($connection->connect_error);
 
 return $connection;
}
*/