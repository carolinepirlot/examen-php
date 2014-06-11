<?php
session_start();

require("php/config.php");
include("php/fonctions.php");

include("php/try-membres.php");
?>

<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Politique de confidentialité</title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/styles.min.css" />

		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>
	</head>

<body id="politique">

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

			<h2 class="text-center">Politique de confidentialité et cession de droits</h2>

			<div class="row">

				<div class="col-sm-9 about">
					<p>Devant le développement des nouveaux outils de communication, 
						il est nécessaire de porter une attention particulière à la protection 
						de la vie privée.</p>

					<p>Les renseignements récupérés sont le nom, le prénom, l'adresse mail 
						de l'utilisateur, ainsi que ses préférences en matière de jeux de société.</p>

					<p>Les renseignements personnels cités ci-dessus sont recueillis au travers d'un formulaire 
						et grâce à l'interactivité établie entre l'utilisateur et ce site Web.</p>

					<p>Les données collectées serviront uniquement à éventuellement recontacter l'utilisateur 
						en cas de mises à jour ou pour lui rappeler ses événements à venir.</p>

					<p>Lors de l'ajout d'un jeu, l'utilisateur doit procurer une photo du jeu qu'il aura prise 
						par ses propres moyens. Une fois l'ajout du jeu terminé, toutes les photos deviennent la
						propriété de Société : La communauté du jeu de _. L'utilisateur cède alors ses droits dessus.</p>
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