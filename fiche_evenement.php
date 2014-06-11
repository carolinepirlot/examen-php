<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
ini_set("display_errors", 1);

require("php/config.php");
include("php/fonctions.php");

$id_event = $_GET['id'];


include("php/try-evenements.php");

include("php/try-membres.php");

if(isset($_POST['avis'])) {

	$contenu = trim(strip_tags($_POST['contenu']));
	$event_id = trim(strip_tags($_POST['event_id']));
	$membre_id = trim(strip_tags($_POST['membre_id']));

	try {       
		$stmt = $conn->prepare('INSERT INTO commentaires_events (pseudo, contenu, event_id, membre_id) VALUES (:pseudo, :contenu, :event_id, :membre_id)');
		$stmt->execute(array(
			':pseudo' => $membre['pseudo'],
			':contenu' => $contenu,
			':event_id' => $event_id,
			':membre_id' => $membre_id,
		));

	} catch(PDOException $e) {
		echo 'ERROR: ' . $e->getMessage();
	}

}

include("php/try-commentaires.php");

$id_user = $membre['id'];
$bla = $event['id_event'];

$query = $conn->prepare("SELECT * FROM evenements_inscrits WHERE id_event = :id_event AND id_user = :id_user");
$query->execute(array(
	':id_event' => $bla,
	':id_user' => $id_user
));

if($query->rowCount() > 0){
	$truc = $query->fetch();
	if($truc['active'] == 1){
		$dejaInscrit = 1;	
	}else{
		$dejaInscrit = 0;
	}

	if(isset($_POST['participation'])){
		$query = $conn->prepare("UPDATE evenements_inscrits SET active = NOT active WHERE id_event = :id_event AND id_user = :id_user");
		$query->execute(array(
			':id_event' => $bla,
			':id_user' => $id_user
		));
		if($dejaInscrit == 1){
			$dejaInscrit = 0;	
		}else{
			$dejaInscrit = 1;
		}
	}

}else{

	if(isset($_POST['participation'])){
		$query = $conn->prepare("INSERT INTO evenements_inscrits(id_event, id_user) VALUES(:id_event, :id_user)");
		$query->execute(array(
			':id_event' => $bla,
			':id_user' => $id_user
		));
		$dejaInscrit = 1;
	}else{
		$dejaInscrit = 0;
	}

}


?>

<!DOCTYPE html>
<html lang="fr">

	<head>
		<title><?php echo $event['titre'] ?></title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/styles.min.css" />

		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>
	</head>

<body id="evenement">

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

			<h2 class="text-center"><?php echo $event['titre']; ?></h2>
			<p class="text-center">Cet événement a été créé par <?php echo '<a class="lien" href="profil.php?id='.$event['membre_id'].'">'.$event['pseudo'].'</a>'; ?></p>
			<div class="row">
				<div class="col-xs-12 droits createur text-center">
					<?php

						if ( $event['membre_id'] == $membre['id'] OR $membre['role'] == "administrateur" ) {
							echo '<a type="button" class="btn btn-primary" href="edition_evenement.php?id='.$event['id_event'].'"><span class="plume"></span>Editer la fiche</a>';
							echo '<a type="button" class="btn btn-primary securite" href="php/suppression_evenement.php?id='.$event['id_event'].'"><span class="poubelle"></span>Supprimer la fiche</a>';
						}
					?>
				</div>
			</div>

			<h3 class="text-center jeu"><?php echo $event['jeux']; ?></h3>

			<div class="row">
				<ul class="text-center www col-sm-12">
					<li><span class="date"></span><?php echo $event['date']; ?></li>
					<li><span class="heure"></span><?php echo $event['heure']; ?></li>
					<li><span class="ville"></span><?php echo $event['ville']; ?></li>
					<li><span class="personnes"></span><?php echo $event['nbre']; ?> personne(s) recherchée(s) <p class="libre">2/5 libres</p></li>
				</ul>
			</div>

			<div class="row">

				<div class="col-sm-6 reglement">
					<h4>Règles du jeu</h4>
					<?php 
						$sanitized = htmlspecialchars($event['regles'], ENT_QUOTES);	
					?>
					<p><?php echo str_replace(array("\r\n", "\n"), array("<br />", "<br />"), $sanitized); ?></p>
				</div>

				<div class="col-sm-6">
					<h4>Informations</h4>
					<?php 
						$sanitized = htmlspecialchars($event['infos'], ENT_QUOTES);	
					?>
					<p><?php echo str_replace(array("\r\n", "\n"), array("<br />", "<br />"), $sanitized); ?></p>
				</div>

			</div>

			<div class="row">
				<div class="col-sm-12 text-center participation">
					<p>
						<?php
							$query = $conn->prepare("SELECT * FROM evenements_inscrits WHERE id_event = :id AND active = 1");
							$query->execute(array(
								'id' => $id_event
							));
							$results = $query->fetchAll();

							foreach ($results as $result) {
								$inscrits[] = $result['id_user'];
							}

							$query = $conn->prepare("SELECT * FROM membres");
							$query->execute();
							$membres = $query->fetchAll();

							if(isset($inscrits)){
								foreach ($inscrits as $inscrit) {
									foreach ($membres as $m) {
										if($m['id'] == $inscrit){
											$participants[] = $m;
										}
									}
								}
							}

							if(isset($participants)){
								$i = 0;
								foreach ($participants as $participant) {
									if($i > 0){
										echo ", ";
									}
									echo "<a href='profil.php?id=".$participant['id']."'>".$participant['pseudo']."</a>";
									$i++;
								}
								if($i == 1){
								echo " participe à l'événement.";
							} else {
								echo " participent à l'événement.";
							}
							}else{
								echo "Il n'y a pas encore d'inscrit pour cet événement";
							}
								
						?>
					</p>
				</div>
			</div>

			<div class="row">
				<form method="post" action="<?php if(isset($_SESSION['pseudo'])){ echo "#";}else{ echo "connexion.php"; } ?>" class="form-horizontal" role="form">

					<div class="col-sm-12 text-center submitTop">
						<button type="submit" name="participation" id="participation" class="btn btn-primary">
							<span class="particiP"></span> <?php if($dejaInscrit == 1){ echo "Je me désinscris"; }else{ echo "Moi aussi je veux participer !"; } ?>
						</button>
					</div>
				</form>
			</div>

			<h4>Commentaires</h4>
			<div class="row com">
				<?php 

					foreach ($coms as $key => $value) {	
						$li = '<li class="col-sm-12"><span class="citation"></span><div class="hope"><a class="auteurCom" href="profil.php?id='.$value['membre_id'].'"><h5>'.$value['pseudo'].'</h5></a><p>'.$value['contenu'].'</p></div></li>';
						echo $li;
										
					}

				?>

				<?php
					if(isset($_SESSION['pseudo'])){
				?>
						
					<form class="form-group col-sm-6 col-xs-12" role="form" method="post">
						<textarea class="form-control areaCom" name="contenu" id="contenu"></textarea>
						<input type="hidden" name="event_id" value="<?php echo $event['id_event']; ?>" />
						<input type="hidden" name="membre_id" value="<?php echo $membre['id']; ?>" />
						<div class="text-center">
							<input class="btn btn-default pull-right" type="submit" name="avis" value="Donner mon avis" id="avis" />
						</div>
					</form>

				<?php
					}
				?>
			</div>

		</div>

	</div>

	<?php include("footer.php"); ?>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/scripts.min.js"></script>

</body>

</html>