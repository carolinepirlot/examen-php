<?php
session_start();

error_reporting(E_ALL ^ E_NOTICE);

require("config.php");
include("fonctions.php");

$id = $_GET['id'];

$requete = 'DELETE from jeux WHERE id_jeu=:id_jeu';

if (isset($_GET['verif']) && $_GET['verif'] == true) {
	$requete = 'DELETE from jeux_attente WHERE id_jeu=:id_jeu';
} 

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
					$stmt = $conn->prepare($requete);
					$stmt->execute(array(
						':id_jeu'=>$id
					));
					echo "<p>Jeu supprimé</p>";
					echo '<a href="../liste.php">Retour à la liste de modération</a>';
				}

				catch (Exception $e){ 
					die('Erreur : ' . $e->getMessage());
				}
			?>
		</div>
	</div>
</body>
</html>

