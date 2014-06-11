<?php
session_start();

require("php/config.php");
include("php/fonctions.php");

include("php/try-membres.php");

?>

<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Crédits</title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/styles.min.css" />

		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>
	</head>

<body id="credits">

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

				<h2 class="text-center">Crédits</h2>

				<div class="row">

					<div class="col-sm-6 about">
						<h3>A propos</h3>

						<p>Société : La communauté du jeu hors ligne est un projet réalisé dans le cadre du Travail de Fin d'Etudes de la section Web Design &amp; Multimedia de l'<a href="http://www.infographie-sup.be" target="_blank">ESIAJ</a> de Namur.</p>

						<p>Derrière tout ça, l'auteur de ce projet, c'est moi : <a href="http://carolinepirlot.be" target="_blank">Caroline Pirlot</a>.</p>

						<p>Mon but était de créer une solution qui permette à une communauté de se créer, afin de découvrir des jeux de société et d'en faire découvrir à d'autres, mais aussi et surtout, de se rencontrer.</p>

						<p>Ce projet m'aura également permis de faire mes premiers pas du côté développement grâce au Php.</p>

						<p>Tous les droits sont réservés à Société : La communauté du jeu hors ligne. Pour toute réclamation, n'hésitez pas à <a href="http://carolinepirlot.be/contact.php" target="_blank">me contacter</a>.</p>
					</div>

					<div class="col-sm-5 col-md-offset-1">
						<h3 class="soutien">Conseils et soutien</h3>
						<ul>
							<li>Professeurs de la section <a href="http://dwm.re/" target="_blank">DWM</a></li>
							<li><a href="https://twitter.com/PierreStoffe" target="_blank">Pierre Stoffe</a></li>
							<li><a href="https://twitter.com/ColinetSteve" target="_blank">Steve Colinet</a></li>
							<li><a href="https://twitter.com/Cobaydy" target="_blank">Yohan Massart</a></li>
							<li>Ma famille et mon entourage</li>
						</ul>

						<h3 class="sources">Ressources</h3>

						<ul>
							<li><a href="http://getbootstrap.com" target="_blank">Bootstrap</a> - <a href="http://sass-lang.com" target="_blank">Sass</a></li>
							<li><a href="http://www.entypo.com" target="_blank">Entypo</a> - <a href="http://www.shutterstock.com" target="_blank">Shutterstock</a></li>
							<li><a href="http://www.google.com/fonts/" target="_blank">Google Web Font</a> - <a href="http://gudh.github.io/ihover/dist/" target="_blank">iHover</a></li>
							<li><a href="http://jquery.com" target="_blank">jQuery</a> - <a href="http://jsfiddle.net" target="_blank">JSFiddle</a></li>
							<li><a href="http://fr.openclassrooms.com" target="_blank">OpenClassrooms</a></li>
						</ul>
					</div>


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