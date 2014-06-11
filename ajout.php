<?php
$noError = false;
session_start();

error_reporting(E_ALL ^ E_NOTICE);

require("php/config.php");
include("php/fonctions.php");

if (!isset($_SESSION['pseudo'])) {
	header("Location: index.php");
}

include ("php/try-membres.php");

$posted = false;

if(count($_POST)>0) {

	$errors = array();

	$nom = trim(strip_tags($_POST['nom']));
	$duree = trim(strip_tags($_POST['duree']));
	$nombre = trim(strip_tags($_POST['nombre']));
	$type = trim(strip_tags($_POST['type']));
	$age = trim(strip_tags($_POST['age']));
	$auteur = trim(strip_tags($_POST['auteur']));
	$editeur = trim(strip_tags($_POST['editeur']));
	$illustrateur = trim(strip_tags($_POST['illustrateur']));
	$auteur_url = "#";
	$editeur_url = "#";
	$illustrateur_url = "#";
	$sortie = trim(strip_tags($_POST['sortie']));
	$description = trim(strip_tags($_POST['description']));
	$regles = trim(strip_tags($_POST['regles']));
	$invention = trim(strip_tags($_POST['invention']));
	$validation = "non";

	if(empty($nom)) {
		$errors['nom'][] = "Quel est le nom de ce jeu ?";
	}

	// if($duree == 0) {
	//  	$errors['duree'][] = "Quelle est la durée jeu ?";
	// }
	// if($nombre == 0){
	// 	$errors['nombre'][] = "Combien de personnes faut-il ?";
	// }
	// if($type == 0){
	// 	$errors['type'][] = "Quel type de jeu est-ce ?";
	// }
	// if($age == 0){
	// 	$errors['age'][] = "A partir de quel âge est-il conseillé ?";
	// }

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

	if (isset($_FILES['visuel']) && $_FILES['visuel']['error'] == 0) {

        if ($_FILES['visuel']['size'] <= 100000000){
            $infosfichier = pathinfo($_FILES['visuel']['name']);
            $extension_upload = $infosfichier['extension'];
            $extensions_autorisees = array('jpg', 'jpeg', 'png');

        	$name = preg_replace("/[^A-Z0-9._-]/i", "_", $_FILES['visuel']["name"]);
            $i = 0;
            $parts = pathinfo($name);

                while (file_exists("images/visuels/" . $name)) {
                    $i++;
                    $name = $parts['filename'] . '(' . $i .').' . $parts['extension'];
                }

                if (in_array($extension_upload, $extensions_autorisees)){
                	$visuel = 'images/visuels/' . $name;
                    
                    move_uploaded_file($_FILES['visuel']['tmp_name'], $visuel);
                    
                    if (!copy($visuel, 'images/miniatures/'.$name)) {
					    //echo "La copie $file du fichier a échoué...\n";
					}
                    redimPicture($visuel, 0, 2900, 70);
                    redimPicture('images/miniatures/'.$name, 0, 400, 70);
                }
        }
        
	} else {
		$errors['visuel'][] = "Et la photo ?";
	}

	$posted = true;

	if(count($errors)<1) {
		$noError = true;
		try {       
			$stmt = $conn->prepare('INSERT INTO jeux (nom, visuel, duree, nombre, type, age, auteur, editeur, illustrateur, auteur_url, editeur_url, illustrateur_url, sortie, description, regles, invention, validation) VALUES (:nom, :visuel, :duree, :nombre, :type, :age, :auteur, :editeur, :illustrateur, :auteur_url, :editeur_url, :illustrateur_url, :sortie, :description, :regles, :invention, :validation)');
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
			));

			$lastId = $conn->lastInsertId();

			$stmt = $conn->prepare('INSERT INTO jeux_attente (id_jeu, nom, visuel, duree, nombre, type, age, auteur, editeur, illustrateur, auteur_url, editeur_url, illustrateur_url, sortie, description, regles, invention, validation) VALUES (:id_jeu, :nom, :visuel, :duree, :nombre, :type, :age, :auteur, :editeur, :illustrateur, :auteur_url, :editeur_url, :illustrateur_url, :sortie, :description, :regles, :invention, :validation)');
			$stmt->execute(array(
				':id_jeu' => $lastId,
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
			));

		} catch(PDOException $e) {
			echo 'ERROR: ' . $e->getMessage();
		}

	}

}



?>

<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Ajouter un jeu</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/bootstrap-select.css" />
		<link rel="stylesheet" href="css/styles.min.css" />
		
		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>
	</head>

<body id="ajout">

	<?php
		if($posted) {
			echo '<div class="popup">Merci pour votre contribution !<br/>La fiche que vous avez ajoutée apparaîtra dès qu\'un administrateur l\'aura validée. <form method="post" action="jeux.php"><button id="tks" type="submit" name="tks">Ok</button></form></div>';
			echo '<div class="overlay"></div>';
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

			<h2 class="text-center">Ajout d'un jeu</h2>

			<form method="post" action="#" class="connexion form-horizontal" role="form" enctype="multipart/form-data">

				<div class="row">

					<div class="form-group col-sm-9">
						<label for="nom" class="control-label">Nom du jeu</label>
						<input class="form-control" type="text" name="nom" id="nom" placeholder="Monopoly" value="<?php echo $nom; ?>" />
						<?php echo message_erreur($errors, 'nom'); ?>
					</div>	

					<div class="form-group col-sm-9 col-xs-12">
						<label for="visuel" class="control-label">Visuel du jeu</label>
						<input type="file" id="visuel" class="avatar" name="visuel">

						<div class="visuel col-sm-12"><img src="#" id="apercu" class="visuel" alt=""></div>
						<?php echo message_erreur($errors, 'visuel'); ?>
					</div>

					<div class="col-sm-3 col-xs-12 resume">

						<div class="form-group">
							<select class="selectpicker col-sm-12 col-xs-12" name="duree" id="duree">
								<option value="0">Durée</option>
								<option value="Moins de 30 min">Moins de 30 min</option>
								<option value="De 30 à 60 min">De 30 à 60 min</option>
								<option value="Plus de 60 min">Plus de 60 min</option>
							</select>
							<?php echo message_erreur($errors, 'duree'); ?>
						</div>

						<div class="form-group">
							<select class="selectpicker col-sm-12 col-xs-12" name="nombre" id="nombre">
								<option value="0">Nombre de joueurs</option>
								<option value="Minimum 2">Minimum 2</option>
								<option value="Minimum 4">Minimum 4</option>
								<option value="Plus de 4">Plus de 4</option>
							</select>
							<?php echo message_erreur($errors, 'nombre'); ?>
						</div>

						<div class="form-group">
							<select class="selectpicker col-sm-12 col-xs-12" name="age" id="age">
								<option value="0">Age minimum</option>
								<option value="A partir de 2 ans">A partir de 2 ans</option>
								<option value="A partir de 4 ans">A partir de 4 ans</option>
								<option value="A partir de 6 ans">A partir de 6 ans</option>
								<option value="A partir de 8 ans">A partir de 8 ans</option>
								<option value="A partir de 10 ans">A partir de 10 ans</option>
							</select>
							<?php echo message_erreur($errors, 'age'); ?>
						</div>

						<div class="form-group">
							<select class="selectpicker col-sm-12 col-xs-12" name="type" id="type">
								<option value="0">Type de jeu</option>
								<option value="Adresse">Adresse</option>
								<option value="Coopération">Coopération</option>
								<option value="Culture">Culture</option>
								<option value="Hasard">Hasard</option>
								<option value="Réflexion">Réflexion</option>
								<option value="Stratégie">Stratégie</option>
							</select>
							<?php echo message_erreur($errors, 'type'); ?>
						</div>
					</div>

				</div>

				<div class="row auteurs">

					<div class="form-group col-sm-3">
						<label for="auteur" class="control-label">Auteur</label>
						<input class="form-control" type="text" name="auteur" placeholder="Emmanuel Silva" id="auteur" value="<?php echo $auteur; ?>" />
						<?php echo message_erreur($errors, 'auteur'); ?>
					</div>

					<div class="form-group col-sm-3">
						<label for="illustrateur" class="control-label">Illustrateur</label>
						<input class="form-control" type="text" name="illustrateur" placeholder="Laurence Gilson" id="illustrateur" value="<?php echo $illustrateur; ?>" />
						<?php echo message_erreur($errors, 'illustrateur'); ?>
					</div>

					<div class="form-group col-sm-3">
						<label for="editeur" class="control-label">Editeur</label>
						<input class="form-control" type="text" name="editeur" id="editeur" placeholder="John Doe" value="<?php echo $editeur; ?>" />
						<?php echo message_erreur($errors, 'editeur'); ?>
					</div>

					<div class="form-group col-sm-3">
						<label for="sortie" class="control-label">Date de sortie</label>
						<input class="form-control" type="text" name="sortie" id="sortie" placeholder="2010" value="<?php echo $sortie; ?>" />
						<?php echo message_erreur($errors, 'sortie'); ?>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-12">
						<label for="description" class="control-label">Description</label>
						<textarea class="form-control" name="description" placeholder="Description présente sur la boîte du jeu" id="description"><?php echo $description; ?></textarea>
						<?php echo message_erreur($errors, 'description'); ?>
					</div>	
				</div>

				<div class="row">
					<div class="form-group col-sm-6">
						<label for="regles" class="control-label">Règles</label>
						<textarea class="form-control" name="regles" placeholder="Résumé des règles principales du jeu" id="regles"><?php echo $regles; ?></textarea>
						<?php echo message_erreur($errors, 'regles'); ?>
					</div>	

					<div class="form-group col-sm-6">
						<label for="invention" class="control-label">Règles inventées</label>
						<textarea class="form-control" name="invention" placeholder="Règles que vous avez inventé pour agrémenter le jeu" id="invention"><?php echo $invention; ?></textarea>
						<?php echo message_erreur($errors, 'invention'); ?>
					</div>	
				</div>

				<div class="row">
					<div class="col-sm-12 text-center">
						<button type="submit" name="soumettre" id="soumettre" class="btn btn-primary">
							<span class="ajoutV"></span> Ajouter le jeu
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