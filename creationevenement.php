<?php
session_start();

error_reporting(E_ALL ^ E_NOTICE);

require("php/config.php");
include("php/fonctions.php");

if (!isset($_SESSION['pseudo'])) {
	header("Location: index.php");
}

include("php/try-membres.php");


if(count($_POST)>0) {

	$errors = array();

	$titre = trim(strip_tags($_POST['titre']));
	$jeux = trim(strip_tags($_POST['jeux']));
	$ville = trim(strip_tags($_POST['ville']));
	$date = trim(strip_tags($_POST['date']));
	$heure = trim(strip_tags($_POST['heure']));
	$nbre = trim(strip_tags($_POST['nbre']));
	$regles = trim(strip_tags($_POST['regles']));
	$infos = trim(strip_tags($_POST['infos']));
	$membre_id = trim(strip_tags($_POST['membre_id']));
	$pseudo = trim(strip_tags($_POST['pseudo']));

	if(empty($titre)){
		$errors['titre'][] = "Quel est le titre de votre événement ?";
	}

	if(empty($jeux)){
		$errors['jeux'][] = "A quel jeu souhaitez-vous jouer ?";
	}

	if(empty($ville)){
		$errors['ville'][] = "Où cela aura-t-il lieu ?";
	}

	if(empty($date)){
		$errors['date'][] = "A quelle date ?";
	}

	if(empty($heure)){
		$errors['heure'][] = "A quelle heure ?";
	}

	if(empty($nbre)){
		$errors['nbre'][] = "Combien de joueurs recherchez-vous ?";
	}

	if(empty($regles)){
		$errors['regles'][] = "Quelles sont les règles avec lesquelles vous comptez jouer ?";
	}

	if(empty($infos)){
		$errors['infos'][] = "Y a-t-il besoin d'apporter quelque chose ou autre chose à indiquer ?";
	}

	if(count($errors)<1) {

		try {       
			$stmt = $conn->prepare('INSERT INTO evenements (titre, jeux, ville, date, heure, nbre, regles, infos, membre_id, pseudo) VALUES (:titre, :jeux, :ville, :date, :heure, :nbre, :regles, :infos, :membre_id, :pseudo)');
			$stmt->execute(array(
				':titre' => $titre,
				':jeux' => $jeux,
				':ville' => $ville,
				':date' => $date,
				':heure' => $heure,
				':nbre' => $nbre,
				':regles' => $regles,
				':infos' => $infos,
				':membre_id' => $membre_id,
				':pseudo' => $pseudo,
			));

		} catch(PDOException $e) {
			echo 'ERROR: ' . $e->getMessage();
		}
		header("Location: evenements.php");
	}


}
?>

<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Organisation d'un événement</title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/styles.min.css" />

		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>
	</head>

<body id="creation">

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
					    <li class="dropdown active">
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

		<div class="container">

			<h2 class="text-center">Organisation d'un événement</h2>

			<form method="post" action="#" class="connexion form-horizontal" role="form">

				<div class="row">

					<div class="form-group col-sm-6">
						<label for="titre" class="control-label">Nom de l'événement</label>
						<input class="form-control" type="text" name="titre" id="titre" placeholder="Soirée entre amis" value="<?php echo $titre; ?>" />
						<?php echo message_erreur($errors, 'titre'); ?>
					</div>	

					<div class="form-group col-sm-6">
						<label for="jeux" class="control-label">Jeu</label>
						<input class="form-control" type="text" name="jeux" id="jeux" placeholder="Monopoly" value="<?php echo $jeux; ?>" />
						<?php echo message_erreur($errors, 'jeux'); ?>
					</div>
				</div>	

				<div class="row">

					<div class="form-group col-sm-3">
						<label for="ville" class="control-label">Ville</label>
						<input class="form-control" type="text" name="ville" id="ville" placeholder="Namur" value="<?php echo $ville; ?>" />
						<?php echo message_erreur($errors, 'ville'); ?>
					</div>

					<div class="form-group col-sm-3">
						<label for="date" class="control-label">Date</label>
						<input class="form-control" type="text" name="date" id="date" placeholder="16 Septembre 2014" value="<?php echo $date; ?>" />
						<?php echo message_erreur($errors, 'date'); ?>
					</div>

					<div class="form-group col-sm-3">
						<label for="heure" class="control-label">Heure</label>
						<input class="form-control" type="text" name="heure" id="heure" placeholder="19.00" value="<?php echo $heure; ?>" />
						<?php echo message_erreur($errors, 'heure'); ?>
					</div>

					<div class="form-group col-sm-3">
						<label for="nbre" class="control-label">Nombre de joueurs</label>
						<input class="form-control" type="text" name="nbre" id="nbre" placeholder="4" value="<?php echo $nbre; ?>" />
						<?php echo message_erreur($errors, 'nbre'); ?>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6">
						<label for="regles" class="control-label">Règles</label>
						<textarea class="form-control area" name="regles" placeholder="Résumé des règles que vous employez en jouant au Monopoly" id="regles"><?php echo $regles; ?></textarea>
						<?php echo message_erreur($errors, 'regles'); ?>
					</div>	

					<div class="form-group col-sm-6">
						<label for="infos" class="control-label">Informations</label>
						<textarea class="form-control area" name="infos" placeholder="Nourriture à apporter, idées d'autres jeux à essayer, ..." id="infos"><?php echo $infos; ?></textarea>
						<?php echo message_erreur($errors, 'infos'); ?>
					</div>	
				</div>

				<input type="hidden" name="membre_id" value="<?php echo $membre['id']; ?>" />
				<input type="hidden" name="pseudo" value="<?php echo $membre['pseudo']; ?>" />

				<div class="row">
					<div class="col-sm-12 text-center submitTop">
						<button type="submit" name="creer" id="creer" class="btn btn-primary">
							<span class="ajoutV"></span> Créer l'événement
						</button>
					</div>
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