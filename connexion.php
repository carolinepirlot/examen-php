<?php
error_reporting(E_ALL ^ E_NOTICE);

require("php/config.php");
include("php/fonctions.php");

if (isset($_POST['connect'])) {

	$pseudo = trim(strip_tags($_POST['pseudo']));
	$mdp = trim(strip_tags($_POST['mdp']));

	if(isset($_POST['pseudo']) && isset($_POST['mdp']) ){

		$errors = array();

		$stmt = $conn->prepare('SELECT COUNT(*) FROM membres WHERE pseudo = ?');
		$stmt->execute(array($pseudo));
		$connexion = $stmt->fetch();

		if(empty($mdp)) {
			$errors['mdp'][] = "Mot de passe incorret";
		}

		if ($connexion[0] == 0){
			$errors['pseudo'][] = "Pseudo incorrect";
		} else {
			$e = $conn->prepare('SELECT mdp, pseudo, id FROM membres WHERE pseudo = ?');
			$e->execute(array($pseudo));
			$rep = $e->fetch();

			if ($mdp == $rep['mdp']){
				session_start();
				$_SESSION['pseudo'] = $pseudo;
				$_SESSION['id'] = $rep['id'];
				header('Location: accueil.php'); 
			} 
		}

	}

}


?>

<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Connexion</title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/styles.min.css" />

		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>
	</head>

<body id="connexion">

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
		  		   	 	<li><a href="inscription.php">S'inscrire</a></li>
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

	<div id="content" class="sign">

		<div class="container">

			<h2 class="text-center">Se connecter</h2>

			<p class="text-center">Parce que c'est toujours mieux de jouer ensemble.</p>
			<p class="text-center">Pas encore membre ? <a href="inscription.php" class="turquoise">Inscris-toi</a> sans attendre !</p>

			<form method="post" action="#" class="connexion form-horizontal col-sm-4 col-sm-offset-4" role="form">

				<div class="form-group">
					<label for="pseudo" class="text-center col-sm-12">Nom d'utilisateur</label>
					<input class="form-control" type="text" name="pseudo" id="pseudo" value="<?php echo $pseudo; ?>" />
					<?php echo message_erreur($errors, 'pseudo'); ?>
				</div>	

				<div class="form-group">
					<label for="mdp" class="text-center col-sm-12">Mot de passe</label>
					<input class="form-control" type="password" name="mdp" id="mdp" value="<?php echo $mdp; ?>" />
					<?php echo message_erreur($errors, 'mdp'); ?>
				</div>	

				<div class="text-center">
					<input class="btn btn-default" type="submit" name="connect" value="Je me connecte" id="connect" />
				</div>
			</form>

		</div>

	</div>

	<?php include("footer.php"); ?>


	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/scripts.min.js"></script>

</body>

</html>