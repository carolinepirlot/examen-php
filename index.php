<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Société : La communauté du jeu de ________</title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/styles.min.css" />

		<link href='http://fonts.googleapis.com/css?family=Satisfy' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>
	</head>

<body id="accueil">

	<header>
		<div class="container">
			<div class="row">
				<div class="col-sm-3 col-xs-12">
					<h1>
						<a href="index.php" class="logo">Société</a>
					</h1>
				</div>
				<div class="col-sm-9 col-xs-12">
					<ul class="pull-right nav nav-pills">
					    <li><a href="jeux.php">Découvrir des jeux</a></li>
					    <li><a href="evenements.php">Trouver des joueurs</a></li>
		  		    	<li><a href="connexion.php">Se connecter</a></li>
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

		<div class="bgElem bgUn">
			<div class="container">
				<div class="accroche">
					<h2 class="h2titre text-center">Société</h2>
				
					<div class="text-center slogan">
						<a class="btn btn-default btnaccueil" href="jeux.php">Découvrir de nouveaux jeux</a>
						<a class="btn btn-default btnaccueil" href="evenements.php">Trouver des gens avec qui jouer</a>
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