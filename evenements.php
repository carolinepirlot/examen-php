<?php
session_start();

require("php/config.php");
include("php/fonctions.php");

include("php/try-evenements.php");

include("php/try-membres.php");

?>

<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Trouver des gens avec qui jouer</title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/ihover.min.css" />
		<link rel="stylesheet" href="css/styles.min.css" />

		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>
	</head>

<body id="evenements">

	<header>
		<div class="container">
			<div class="row">
				<div class="col-sm-3 col-xs-12">
					<h1>
						<?php
							if(isset($_SESSION['pseudo'])){
								echo '<a href="accueil.php" class="logo">Société</a>';					
							} else {
		  		    		 	echo '<a href="index.php" class="logo">Société</a>';
							}
						?>
					</h1>
				</div>
				<div class="col-sm-9 col-xs-12">
					<ul class="pull-right nav nav-pills">

							<li><a href="jeux.php">Découvrir des jeux</a></li>
							<li class="active"><a href="evenements.php">Trouver des joueurs</a></li>

						<?php
							if(isset($_SESSION['pseudo'])){
						?>
							
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
						<?php
							} else {
						?>
		  		    		<li><a href="connexion.php">Se connecter</a></li>

						<?php
							}
						?>
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

		<div class="container">

				<h2 class="text-center">Trouver des gens avec qui jouer</h2>

			<div class="row">

				<div class="col-sm-12">

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
								if($events){

									foreach ($events as $key => $value) {

										$query = $conn->prepare("SELECT * FROM evenements_inscrits WHERE id_event = :id_event AND active = 1");
										$query->execute(array(
											':id_event' => $value['id_event']
										));
										$results = $query->fetchAll();

										$participant = array();
										foreach ($results as $result) {
											$participant[] = $result['id_user'];
										}
										if($query->rowCount() < $value['nbre'] || in_array($_SESSION['id'], $participant)){
												
											echo '<tr>';
												echo '<td><a class="titreEvent" href="fiche_evenement.php?id='.$value['id_event'].'">'.$value['titre'].'</a></td>';
												echo '<td>'.$value['jeux'].'</td>';
												echo '<td>'.$value['date'].'</td>';
												echo '<td class="tabNbre">'.$value['ville'].'</td>';
												echo '<td class="tabNbre">'.$value['nbre'].'</td>';
											echo '</tr>';

										}

									}
								}
								else {
									echo "Il n'y a actuellement aucun événement";
								}
							?>
						</tbody>
					</table>

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