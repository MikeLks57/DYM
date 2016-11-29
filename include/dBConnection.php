<?php

$options = array(
    PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND    => 'SET NAMES \'UTF8\'',
);
$strConnection = 'mysql:host=localhost;dbname=dym';
$pdo = new PDO($strConnection, 'root', '1234', $options);