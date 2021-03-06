<?php
session_start();

error_reporting(E_ALL ^ E_NOTICE);

require("php/config.php");
include("php/fonctions.php");

if (!isset($_SESSION['pseudo'])) {
	header("Location: index.php");
}

$id_event = $_GET['id'];

include("php/try-evenements.php");

include("php/try-membres.php");

if (count($_POST)>0) {
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

	if(empty($titre)){
		$errors['titre'][] = "C'est quoi le petit titre de ton événement ?";
	}

	if(empty($jeux)){
		$errors['jeux'][] = "Et tu veux jouer à quoi ?";
	}

	if(empty($ville)){
		$errors['ville'][] = "Où est-ce qu'on jouerait ?";
	}

	if(empty($date)){
		$errors['date'][] = "Quand ça ?";
	}

	if(empty($heure)){
		$errors['heure'][] = "A quelle heure ?";
	}

	if(empty($nbre)){
		$errors['nbre'][] = "Tu as besoin de combien de joueurs ?";
	}

	if(empty($regles)){
		$errors['regles'][] = "Et les règles avec lesquelles tu joues toi, c'est quoi ?";
	}

	if(empty($infos)){
		$errors['infos'][] = "Besoin d'apporter quelque chose ou autre ?";
	}

	if(count($errors)<1) {

		try {
			$stmt = $conn->prepare('UPDATE evenements SET titre = :titre, jeux = :jeux, ville = :ville, date = :date, heure = :heure, nbre = :nbre, regles = :regles, infos = :infos, membre_id = :membre_id WHERE id_event = :id_event');
			$stmt->execute(array(
				':id_event' => $id_event,
				':titre' => $titre,
				':jeux' => $jeux,
				':ville' => $ville,
				':date' => $date,
				':heure' => $heure,
				':nbre' => $nbre,
				':regles' => $regles,
				':infos' => $infos,
				':membre_id' => $membre_id,

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
		<title>Edition d'un événement</title>
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

			<h2 class="text-center">Edition de votre événement</h2>

			<form method="post" action="#" class="connexion form-horizontal" role="form">

				<div class="row">	

					<div class="form-group col-sm-6">
						<label for="titre" class="control-label">Nom de l'événement</label>
						<input class="form-control" type="text" name="titre" id="titre" value="<?php echo $event['titre']; ?>" />
						<?php echo message_erreur($errors, 'titre'); ?>
					</div>	

					<div class="form-group col-sm-6">
						<label for="jeux" class="control-label">Jeu(x)</label>
						<input class="form-control" type="text" name="jeux" id="jeux" value="<?php echo $event['jeux']; ?>" />
						<?php echo message_erreur($errors, 'jeux'); ?>
					</div>	
				</div>


				<div class="row">

					<div class="form-group col-sm-3">
						<label for="ville" class="control-label">Ville</label>
						<input class="form-control" type="text" name="ville" id="ville" value="<?php echo $event['ville']; ?>" />
						<?php echo message_erreur($errors, 'ville'); ?>
					</div>

					<div class="form-group col-sm-3">
						<label for="date" class="control-label">Date</label>
						<input class="form-control" type="text" name="date" id="date" value="<?php echo $event['date']; ?>" />
						<?php echo message_erreur($errors, 'date'); ?>
					</div>

					<div class="form-group col-sm-3">
						<label for="heure" class="control-label">Heure</label>
						<input class="form-control" type="text" name="heure" id="heure" value="<?php echo $event['heure']; ?>" />
						<?php echo message_erreur($errors, 'heure'); ?>
					</div>

					<div class="form-group col-sm-3">
						<label for="nbre" class="control-label">Nombre de joueurs</label>
						<input class="form-control" type="text" name="nbre" id="nbre" placeholder="exemple : 4" value="<?php echo $event['nbre']; ?>" />
						<?php echo message_erreur($errors, 'nbre'); ?>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-6">
						<label for="regles" class="control-label">Règles</label>
						<textarea class="form-control area" name="regles" id="regles"><?php echo $event['regles']; ?></textarea>
						<?php echo message_erreur($errors, 'regles'); ?>
					</div>	

					<div class="form-group col-sm-6">
						<label for="infos" class="control-label">Informations</label>
						<textarea class="form-control area" name="infos" id="infos"><?php echo $event['infos']; ?></textarea>
						<?php echo message_erreur($errors, 'infos'); ?>
					</div>	
				</div>

				<input type="hidden" name="membre_id" value="<?php echo $membre['id']; ?>" />

				<div class="row">
					<div class="col-sm-12 text-center submitTop">
						<button type="submit" name="creer" id="creer" class="btn btn-primary">
							<span class="editP"></span> Editer l'événement
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