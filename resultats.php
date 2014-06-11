<?php
session_start();

require("php/config.php");
include("php/fonctions.php");

include("php/try-membres.php");
?>

<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Résultats de votre recherche</title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/styles.min.css" />

		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>
	</head>

<body>

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
							<li><a href="evenements.php">Trouver des joueurs</a></li>

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

			<section>

				<h2>Les résultats</h2>

				<div class="row">

					<ul>

						<?php

   							if (isset($_POST['rapide'])) {


								try {

									$Mot= htmlspecialchars($_POST['search']);
									$result = $conn->query('SELECT * FROM jeux WHERE nom LIKE "%'.$Mot.'%"');

									
									if (($Mot == "")||($Mot == "%")) {
										echo "Vous n'avez pas effectué de recherche";
									}
								    
									else {
										$nombre_res= $result-> rowcount(); 
										echo '<div class="col-sm-12"><h4 class="results"> Nombre de r&eacutesultats : '. $nombre_res . '</h4></div>';

									   	for($i=0 ; $i < $nombre_res; $i++) { 

									   		$donnee = $result-> fetch();

									   		if($donnee['validation'] == "oui") {
												$li = '<li class="col-sm-3 col-xs-6"><a href="fiche.php?id='.$donnee['id_jeu'].'"><img src="images/miniatures/'.$donnee['visuel'].'" alt="'.$donnee['nom'].'" /><h3>'.$donnee['nom'].'</h3></a></li>';
												echo $li;
											}
									   	}	   

									}
									
									$result -> closeCursor();
								}
									

								catch (Exception $e) {																																																	
								  	die('Erreur : ' . $e->getMessage());
								}

							}
    

						 ?>

					</ul>
				</div>

			</section>

			

		</div>

	</div>

	<?php include("footer.php"); ?>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/scripts.min.js"></script>

</body>

</html>