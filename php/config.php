<?php 

$dbHost = 'localhost';
$dbName = 'tfe';
$dbUser = 'root';
$dbPassword = 'root';

$conn = new PDO('mysql:host='.$dbHost.';dbname='.$dbName, $dbUser, $dbPassword);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



 ?>