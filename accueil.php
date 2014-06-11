<?php
session_start();

require("php/config.php");
include("php/fonctions.php");

if (!isset($_SESSION['pseudo'])) {
	header("Location: index.php");
}

include("php/try-membres.php");

$id_user = $membre['id'];


// Récupération du dernier jeu validé
$lastJeu = $conn->query('SELECT * FROM jeux WHERE validation = "oui" ORDER BY id_jeu DESC LIMIT 1');


// Récupération des évènements
include("php/try-evenements.php");


//récupération des events inscrit
include("php/try-inscription.php");

?>

<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Société : La communauté du jeu de ________</title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/styles.min.css" />

		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>
	</head>

<body id="indexPerso">

	<header>
		<div class="container">
			<div class="row">
				<div class="col-sm-3 col-xs-12">
					<h1>
						<a href="accueil.php" class="logo">Société</a>
					</h1>
				</div>
				<div class="col-sm-9 col-xs-12">
					<ul class="pull-right nav nav-pills">
					    <li><a href="jeux.php">Découvrir des jeux</a></li>
			  		    <li><a href="evenements.php">Trouver des joueurs</a></li>
					    <li class="dropdown">
					        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $_SESSION['pseudo']; ?><span class="caret"></span>
					    	</a>
					        <ul class="dropdown-menu">
					        	<li><a href="edition_profil.php">Editer mon profil</a></li>
			  		    		<li><a href="ajout.php">Ajouter un jeu</a></li>
			  		    		<li><a href="creationevenement.php">Organiser un événement</a></li>
			  		    		<?php if( $membre['role'] == "administrateur" ) { echo '<li><a href="liste.php">Modérer les jeux</a></li>'; } ?>
			  		    		<li><a href="php/deconnexion.php">Me déconnecter</a></li>
					      	</ul>
					    </li>
					    <li class="quick-search">
							<form class="navbar-search search" action="resultats.php" method="post">
								<input id="search" type="search" name="search" placeholder="Nom d'un jeu">
								<input id="submit" type="submit" name="rapide" value="">
							</form>
						</li>
					</ul>
				</div>
				
			</div>
		</div>
	</header>

	<div id="content">

		<?php

			while ($last = $lastJeu->fetch(PDO::FETCH_ASSOC)) {
				$image = '<div class="visuelFiche dernierJeu" style="background-image: url(\'images/visuels/'.$last['visuel'].'\');">
				<div class="container"><div class="row"><div class="col-sm-12"><h2 class="test">Jeu du moment : '.$last['nom'].'</h2>
				</div></div><a href="fiche.php?id='.$last['id_jeu'].'" type="button" class="btn btn-primary">Découvrir le jeu</a> <a href="jeux.php" type="button" class="btn btn-primary catalogue">Accéder au catalogue complet</a></div></div>';
				echo $image;
			}
				$lastJeu->closeCursor();

		?>

		<div class="container">


			<div>

				<div class="row">
					<div class="col-xs-12"><h3 class="derniersIndex">Derniers événements que vous avez créés</h3></div>
				</div>

				<table class="table table-hover">
					<thead>
						<tr>
							<td>Nom de l'événement</td>
							<td>Jeu</td>
							<td>Date</td>
							<td class="tabNbre">Lieu</td>
							<td class="tabNbre">Personnes recherchées</td>
						</tr>	
					</thead>
					<tbody>
						<?php 

							if($evenements){
								foreach ($evenements as $event) {

									if($event['membre_id'] == $membre['id']) {
											
										echo '<tr>';
											echo '<td><a class="titreEvent" href="fiche_evenement.php?id='.$event['id_event'].'">'.$event['titre'].'</a></td>';
											echo '<td>'.$event['jeux'].'</td>';
											echo '<td>'.$event['date'].'</td>';
											echo '<td class="tabNbre">'.$event['ville'].'</td>';
											echo '<td class="tabNbre">'.$event['nbre'].'</td>';
										echo '</tr>';
									}
								}
							}
							else {
								echo 'Vous n\'avez créé aucun événement';
							}
						?>
					</tbody>
				</table>

				<div class="row">
					<div class="col-xs-12"><h3 class="auxquels">Derniers événements auxquels vous vous êtes inscrit(e)</h3></div>
				</div>

				<table class="table table-hover">
						<?php 
							if($inscrits){

								echo '<thead>';
									echo '<tr>';
										echo '<td class="nomEvent">Nom de l\'événement</td>';
										echo '<td>Jeu</td>';
										echo '<td>Date</td>';
										echo '<td class="tabNbre">Lieu</td>';
										echo '<td class="tabNbre">Personnes recherchées</td>';
									echo '</tr>';
								echo '</thead>';
								echo '<tbody>';

								foreach ($inscrits as $inscrit) {
											
									echo '<tr>';
										echo '<td><a class="titreEvent" href="fiche_evenement.php?id='.$inscrit['id_event'].'">'.$inscrit['titre'].'</a></td>';
										echo '<td>'.$inscrit['jeux'].'</td>';
										echo '<td>'.$inscrit['date'].'</td>';
										echo '<td class="tabNbre">'.$inscrit['ville'].'</td>';
										echo '<td class="tabNbre">'.$inscrit['nbre'].'</td>';
									echo '</tr>';
								}
							}
							else {
								echo 'Vous n\'êtes actuellement inscrit(e) à aucun événement';
							}
						?>
					</tbody>
				</table>


				<div class="row">
					<div class="col-sm-12 text-center">
						<a href="evenements.php" type="button" class="btn btn-primary listing acces">Accéder à tous les événements</a>
						<a href="creationevenement.php" type="button" class="btn btn-primary listing">Organiser votre événement</a>
					</div>
				</div>

			</div>

		</div>

	</div>

	<?php include("footer.php"); ?>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/scripts.min.js"></script>

</body>

</html>