<?php
session_start();

error_reporting(E_ALL ^ E_NOTICE);

require("config.php");
include("fonctions.php");

$id = $_GET['id'];


?>


<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Suppression d'un jeu</title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="../css/bootstrap.min.css" />
		<link rel="stylesheet" href="../css/styles.min.css" />

		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>
	</head>

<body>
	<div class="container">
		<div class="suppre">
			<?php
				try {
					$stmt = $conn->prepare('DELETE from evenements WHERE id_event=:id_event');
					$stmt->execute(array(
						':id_event'=>$id
					));
					echo "<p>Evénement supprimé</p>";
					echo '<a href="../evenements.php">Retour aux événements</a>';

				}

				catch (Exception $e){ 
					die('Erreur : ' . $e->getMessage());
				}
			?>
		</div>
	</div>
</body>
</html>

