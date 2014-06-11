<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

require("config.php");
include("fonctions.php");

try {
	$stmt = $conn->prepare('SELECT * FROM membres WHERE pseudo = :pseudo');
	$stmt->execute(array(
		':pseudo' => $_SESSION['pseudo']
	));

	$membre = $stmt->fetch();

} catch(PDOException $e) {
	echo 'ERROR: ' . $e->getMessage();
}

$id = $membre['id'];

try {
	$stmt = $conn->prepare('DELETE from membres WHERE id =:id ');
	$stmt->execute(array(
		':id'=>$id
	));
	header("Location: ../index.php");

}

catch (Exception $e){ 
	die('Erreur : ' . $e->getMessage());
}

?>