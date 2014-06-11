<?php
session_start();
$noError = false;
error_reporting(E_ALL ^ E_NOTICE);

require("php/config.php");
include("php/fonctions.php");

if (!isset($_SESSION['pseudo'])) {
	header("Location: index.php");
}

$id = $_GET['id'];

include("php/try-jeux.php");
include("php/try-membres.php");

$nom = $jeu['nom'];
$name = $jeu['visuel'];

$posted = false;

if (count($_POST)>0) {
	$errors = array();

	$duree = trim(strip_tags($_POST['duree']));
	$nombre = trim(strip_tags($_POST['nombre']));
	$type = trim(strip_tags($_POST['type']));
	$age = trim(strip_tags($_POST['age']));
	$auteur = trim(strip_tags($_POST['auteur']));
	$editeur = trim(strip_tags($_POST['editeur']));
	$illustrateur = trim(strip_tags($_POST['illustrateur']));
	$auteur_url = trim(strip_tags($_POST['auteur_url']));
	$editeur_url = trim(strip_tags($_POST['editeur_url']));
	$illustrateur_url = trim(strip_tags($_POST['illustrateur_url']));
	$sortie = trim(strip_tags($_POST['sortie']));
	$description = trim(strip_tags($_POST['description']));
	$regles = trim(strip_tags($_POST['regles']));
	$invention = trim(strip_tags($_POST['invention']));
	$validation = trim(strip_tags($_POST['validation']));

	if(empty($auteur)){
		$errors['auteur'][] = 'Si vous ne le connaissez pas, indiquez "Non renseigné"';
	}

	if(empty($editeur)){
		$errors['editeur'][] = 'Si vous ne le connaissez pas, indiquez "Non renseigné"';
	}

	if(empty($illustrateur)){
		$errors['illustrateur'][] = 'Si vous ne le connaissez pas, indiquez "Non renseigné"';
	}

	if(empty($sortie)){
		$errors['sortie'][] = "Quelle est son année de sortie ?";
	}

	if(empty($description)){
		$errors['description'][] = "Quelle est la description rapide ?";
	}

	if(empty($regles)){
		$errors['regles'][] = "Quelles sont les règles principales ?";
	}

	if(empty($invention)){
		$errors['invention'][] = "Une idée d'une règle inventée ?";
	}

	if(count($errors)<1) {

		$posted = true;
		$noError = true;

		if($membre['role'] == "utilisateur") {
			$validation = "non";
			$auteur_url = $jeu['auteur_url'];
			$illustrateur_url = $jeu['illustrateur_url'];
			$editeur_url = $jeu['editeur_url'];
		}

		$requete = '';

		if (isset($_GET['verif']) && $_GET['verif'] == true && $validation == 'oui') {
			$requete = 'UPDATE jeux SET nom = :nom, visuel = :visuel,  duree = :duree, nombre = :nombre, type = :type, age = :age, auteur = :auteur, editeur = :editeur, illustrateur = :illustrateur, auteur_url = :auteur_url, editeur_url = :editeur_url, illustrateur_url = :illustrateur_url, sortie = :sortie, description = :description, regles = :regles, invention = :invention, validation = :validation WHERE id_jeu = :id_jeu';
			$stmt = $conn->prepare('DELETE from jeux_attente WHERE id_jeu = :id_jeu');
			$stmt->execute(array(
				':id_jeu'=>$id
			));
		} else {
			$requete = 'INSERT INTO jeux_attente (id_jeu, nom, visuel, duree, nombre, type, age, auteur, editeur, illustrateur, auteur_url, editeur_url, illustrateur_url, sortie, description, regles, invention, validation) VALUES (:id_jeu, :nom, :visuel, :duree, :nombre, :type, :age, :auteur, :editeur, :illustrateur, :auteur_url, :editeur_url, :illustrateur_url, :sortie, :description, :regles, :invention, :validation)';
		}

		try {

			$stmt = $conn->prepare($requete);
			$stmt->execute(array(
				':nom' => $nom,
				':visuel' => $name,
				':duree' => $duree,
				':nombre' => $nombre,
				':type' => $type,
				':age' => $age,			
				':auteur' => $auteur,
				':editeur' => $editeur,
				':illustrateur' => $illustrateur,
				':auteur_url' => $auteur_url,
				':editeur_url' => $editeur_url,
				':illustrateur_url' => $illustrateur_url,
				':sortie' => $sortie,
				':description' => $description,
				':regles' => $regles,
				':invention' => $invention,
				':validation' => $validation,
				':id_jeu' => $id,
			));

		} catch(PDOException $e) {
				echo 'ERROR: ' . $e->getMessage();
		}

		if($membre['role'] == "administrateur") {
			header("Location: liste.php");
		}
	}

}
?>

<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Editer - <?php echo $jeu['nom'] ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/bootstrap-select.css" />
		<link rel="stylesheet" href="css/styles.min.css" />

		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>
	</head>

<body id="editionJeu">

	<?php
		if($posted) {
			if($membre['role'] == "utilisateur") {
				echo '<div class="popup">Merci d\'avoir corrigé la fiche de ce jeu.<br />Vos modifications apparaîtront dès qu\'un adminisatreur les aura validées. <form method="post" action="jeux.php"><button id="tks" type="submit" name="tks">Ok</button></form></div>';
				echo '<div class="overlay"></div>';
			}
		}
	?>

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

			<h2 class="text-center">Edition du jeu : <?php echo $jeu['nom']; ?></h2>

			<form method="post" action="#" class="connexion form-horizontal" role="form" enctype="multipart/form-data">

				<div class="row resumeSelect">

					<div class="resume">

						<div class="form-group col-sm-3">
							<select class="selectpicker col-sm-12 col-xs-12" name="duree" id="duree">
								<option><?php echo $jeu['duree']; ?></option>
								<option value="Moins de 30 min">Moins de 30 min</option>
								<option value="De 30 à 60 min">De 30 à 60 min</option>
								<option value="Plus de 60 min">Plus de 60 min</option>
							</select>
							
						</div>
						<?php //echo message_erreur($errors, 'duree'); ?>

						<div class="form-group col-sm-3">
							<select class="selectpicker col-sm-12 col-xs-12" name="nombre" id="nombre">
								<option><?php echo $jeu['nombre']; ?></option>
								<option value="Minimum 2">Minimum 2</option>
								<option value="Minimum 4">Minimum 4</option>
								<option value="Plus de 4">Plus de 4</option>
							</select>
							<?php //echo message_erreur($errors, 'nombre'); ?>
						</div>

						<div class="form-group col-sm-3">
							<select class="selectpicker col-sm-12 col-xs-12" name="age" id="age">
								<option><?php echo $jeu['age']; ?></option>
								<option value="A partir de 2 ans">A partir de 2 ans</option>
								<option value="A partir de 4 ans">A partir de 4 ans</option>
								<option value="A partir de 6 ans">A partir de 6 ans</option>
								<option value="A partir de 8 ans">A partir de 8 ans</option>
								<option value="A partir de 10 ans">A partir de 10 ans</option>
							</select>
							<?php //echo message_erreur($errors, 'age'); ?>
						</div>

						<div class="form-group col-sm-3">
							<select class="selectpicker col-sm-12 col-xs-12" name="type" id="type">
								<option><?php echo $jeu['type']; ?></option>
								<option value="Adresse">Adresse</option>
								<option value="Coopération">Coopération</option>
								<option value="Culture">Culture</option>
								<option value="Hasard">Hasard</option>
								<option value="Réflexion">Réflexion</option>
								<option value="Stratégie">Stratégie</option>
							</select>
							<?php //echo message_erreur($errors, 'type'); ?>
						</div>
					</div>

				</div>

				<div class="row">

					<div class="form-group col-sm-3 col-xs-12">
						<label for="auteur" class="control-label">Auteur</label>
						<input class="form-control" type="text" name="auteur" id="auteur" value="<?php echo $jeu['auteur']; ?>" />
						<?php echo message_erreur($errors, 'auteur'); ?>
					</div>

					<div class="form-group col-sm-3 col-xs-12">
						<label for="illustrateur" class="control-label">Illustrateur</label>
						<input class="form-control" type="text" name="illustrateur" id="illustrateur" value="<?php echo $jeu['illustrateur']; ?>" />
						<?php echo message_erreur($errors, 'illustrateur'); ?>
					</div>

					<div class="form-group col-sm-3 col-xs-12">
						<label for="editeur" class="control-label">Editeur</label>
						<input class="form-control" type="text" name="editeur" id="editeur" value="<?php echo $jeu['editeur']; ?>" />
						<?php echo message_erreur($errors, 'editeur'); ?>
					</div>

					<div class="form-group col-sm-3 col-xs-12">
						<label for="sortie" class="control-label">Date de sortie</label>
						<input class="form-control" type="text" name="sortie" id="sortie" placeholder="2010" value="<?php echo $jeu['sortie']; ?>" />
						<?php echo message_erreur($errors, 'sortie'); ?>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-12">
						<label for="description" class="control-label">Description</label>
						<textarea class="form-control" name="description" id="description"><?php echo $jeu['description']; ?></textarea>
						<?php echo message_erreur($errors, 'description'); ?>
					</div>	
				</div>

				<div class="row">
					<div class="form-group col-sm-6">
						<label for="regles" class="control-label">Règles</label>
						<textarea class="form-control area" name="regles" id="regles"><?php echo $jeu['regles']; ?></textarea>
						<?php echo message_erreur($errors, 'regles'); ?>
					</div>	

					<div class="form-group col-sm-6">
						<label for="invention" class="control-label">Règles inventées</label>
						<textarea class="form-control area" name="invention" id="invention"><?php echo $jeu['invention']; ?></textarea>
						<?php echo message_erreur($errors, 'invention'); ?>
					</div>	
				</div>

				

				<?php
					if( $membre['role'] == "administrateur" ){
				?>
					<div class="row">

						<div class="form-group col-sm-3 col-xs-12">
							<label for="auteur" class="control-label">Auteur</label>
							<input class="form-control" type="text" name="auteur_url" id="auteur_url" value="<?php echo $jeu['auteur_url']; ?>" />
							<?php echo message_erreur($errors, 'auteur_url'); ?>
						</div>

						<div class="form-group col-sm-3 col-xs-12">
							<label for="illustrateur" class="control-label">Illustrateur</label>
							<input class="form-control" type="text" name="illustrateur_url" id="illustrateur_url" value="<?php echo $jeu['illustrateur_url']; ?>" />
							<?php echo message_erreur($errors, 'illustrateur_url'); ?>
						</div>

						<div class="form-group col-sm-3 col-xs-12">
							<label for="editeur" class="control-label">Editeur</label>
							<input class="form-control" type="text" name="editeur_url" id="editeur_url" value="<?php echo $jeu['editeur_url']; ?>" />
							<?php echo message_erreur($errors, 'editeur_url'); ?>
						</div>

						<div class="col-sm-3 valid">
							<label for="validation">Validation du jeu</label>
							<select class="selectpicker col-sm-12 col-xs-12" name="validation" id="validation">
								<option><?php echo $jeu['validation']; ?></option>
								<option value="oui">oui</option>
								<option value="non">non</option>
							</select>
						</div>
					</div>
				<?php
					}
				?>

				<div class="row">
					<div class="col-sm-12 text-center subTop">
						<button type="submit" name="editer" id="editer" class="btn btn-primary">
							<span class="editP"></span> Editer le jeu
						</button>
					</div>
				</div>
			</form>


		</div>

	</div>

	<?php include("footer.php"); ?>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/scripts.min.js"></script>
	<?php
		if($noError){
			echo "<script> positionPopup();</script>";
		}
	?>

</body>

</html>