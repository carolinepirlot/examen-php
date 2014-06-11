<?php
session_start();

//error_reporting(E_ALL ^ E_NOTICE);

require("php/config.php");
include("php/fonctions.php");
if(!isset($_SESSION['pseudo'])) {

	if(count($_POST)>0) {

		$errors = array();

		$pseudo = trim(strip_tags($_POST['pseudo']));
		$email = trim(strip_tags($_POST['email']));
		$mdp = trim(strip_tags($_POST['mdp']));
		$role = "utilisateur";

		if(empty($pseudo)){
			$errors['pseudo'][] = "N'oubliez pas de choisir votre pseudo";
		}

		if(empty($mdp)){
			$errors['mdp'][] = "Vous devez définir un mot de passe";
		}
			
		if(!is_valid_email($email)) {
			$errors['email'][] = "Vous devez fournir votre adresse email";
		} 
		
		if(!isset($_POST['termes']) || $_POST['termes'] != 'checked'){
			$errors['termes'][] = "Les termes doivent être validés";
		}	

		if(count($errors)<1){

			try {       
				$stmt = $conn->prepare('INSERT INTO membres (pseudo, email, mdp, role) VALUES (:pseudo, :email, :mdp, :role)');
				$stmt->execute(array(
					   ':pseudo' => $pseudo,
					   ':email' => $email,
					   ':mdp' => $mdp,
					   ':role' => $role,
				));

			} catch(PDOException $e) {
				echo 'ERROR: ' . $e->getMessage();
			}

			$_SESSION['pseudo'] = $pseudo;	
			header("Location: edition_profil.php");
		}
			
	}

}
?>

<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Inscription</title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/styles.min.css" />

		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>
	</head>

<body id="connexion">

	<header class="headerBottom">
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


	<div id="content" class="sign">

		<div class="container">

			<h2 class="text-center">S'inscrire</h2>

			<p class="text-center">Venez partager votre passion avec nous.</p>
			<p class="text-center">Déjà membre ? <a href="connexion.php" class="turquoise">Connecte-toi</a> dès maintenant !</p>


			<form method="post" action="#" class="connexion form-horizontal col-sm-4 col-sm-offset-4" role="form">

				<div class="form-group">
					<label for="pseudo" class="text-center col-sm-12">Nom d'utilisateur</label>
					<input class="form-control" type="text" name="pseudo" id="pseudo" value="<?php echo $pseudo; ?>" />
					<span class="feedback"></span>
					<?php echo message_erreur($errors, 'pseudo'); ?>
				</div>	

				<div class="form-group">
					<label for="email" class="text-center col-sm-12">Email</label>
					<input class="form-control" type="email" name="email" id="email" value="<?php echo $email; ?>" />
					<?php echo message_erreur($errors, 'email'); ?>
				</div>

				<div class="form-group">
					<label for="mdp" class="text-center col-sm-12">Mot de passe</label>
					<input class="form-control" type="password" name="mdp" id="mdp" value="<?php echo $mdp; ?>" />
					<?php echo message_erreur($errors, 'mdp'); ?>
				</div>	

				<div class="checkbox text-center">
				    <label>
				      	<input type="checkbox" class="termes" value="checked" name="termes"> Je certifie avoir pris connaissance des <a href="confidentialite.php" target="_blank">termes</a> et les accepte.
				    </label>
				    <?php echo message_erreur($errors, 'termes'); ?>
				</div>

				<div class="text-center">
					<input class="btn btn-default" type="submit" name="inscription" value="Je m'inscris" id="inscription" />
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
