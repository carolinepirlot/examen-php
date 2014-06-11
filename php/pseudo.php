<?php
include("config.php");

if(isset($_POST['pseudo']) && !empty($_POST['pseudo'])) {

	$pseudo = trim($_POST['pseudo']);
	$query = $conn->prepare("SELECT * FROM membres WHERE pseudo= :pseudo");
	$query->execute(array(":pseudo" => $pseudo));
	$rows = $query->rowCount();

	if($rows==1){
		echo "Ce pseudo n'est pas disponible";
	} 
	// else {
	// 	echo "Ce pseudo est disponible";
	// }
}

?>