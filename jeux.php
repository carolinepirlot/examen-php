<?php
session_start();

error_reporting(E_ALL ^ E_NOTICE);

require("php/config.php");
include("php/fonctions.php");

$nbrcond = 0;
$nbrAnd = 0;
$echoWHEREOK = false;

include("php/try-membres.php");

$lastJeu = $conn->query('SELECT * FROM jeux WHERE validation = "oui" ORDER BY id_jeu DESC LIMIT 1');

try { 
    $query = "SELECT * FROM jeux ";
    
    if(isset($_POST['nom']) && strlen($_POST['nom']) > 0){
        if(!$echoWHEREOK){$query .= "WHERE ";$echoWHEREOK = true;}
        $query .= "nom LIKE '%".$_POST['nom']."%' ";
        $nbrcond++;
    }

    if(isset($_POST['age']) && strlen($_POST['age']) > 1){
        if(!$echoWHEREOK){$query .= "WHERE ";$echoWHEREOK = true;}
        if($nbrcond > $nbrAnd){
            $query .= "AND ";
            $nbrAnd++;
        }

    	$query .= "age LIKE '%".$_POST['age']."%' ";
    	$nbrcond++;

    }

    if(isset($_POST['duree']) && strlen($_POST['duree']) > 1){
        if(!$echoWHEREOK){$query .= "WHERE ";$echoWHEREOK = true;}
        if($nbrcond > $nbrAnd){
            $query .= "AND ";
            $nbrAnd++;
        }

    	$query .= "duree LIKE '%".$_POST['duree']."%' ";
    	$nbrcond++;

    }
    if(isset($_POST['nombre']) && strlen($_POST['nombre']) > 1){
        if(!$echoWHEREOK){$query .= "WHERE ";$echoWHEREOK = true;}
        if($nbrcond > $nbrAnd){
            $query .= "AND ";
            $nbrAnd++;
        }

    	$query .= "nombre LIKE '%".$_POST['nombre']."%' ";
    	$nbrcond++;

    }
    if(isset($_POST['auteur']) && strlen($_POST['auteur']) > 0){
        if(!$echoWHEREOK){$query .= "WHERE ";$echoWHEREOK = true;}
        if($nbrcond > $nbrAnd){
            $query .= "AND ";
            $nbrAnd++;
        }

        $query .= "auteur LIKE '%".$_POST['auteur']."%' ";
        $nbrcond++;
    }
    if(isset($_POST['editeur']) && strlen($_POST['editeur']) > 0){
        if(!$echoWHEREOK){$query .= "WHERE ";$echoWHEREOK = true;}
        if($nbrcond > $nbrAnd){
            $query .= "AND ";
            $nbrAnd++;
        }

        $query .= "editeur LIKE '%".$_POST['editeur']."%' ";
        $nbrcond++;
    }
    if(isset($_POST['illustrateur']) && strlen($_POST['illustrateur']) > 0){
        if(!$echoWHEREOK){$query .= "WHERE ";$echoWHEREOK = true;}
        if($nbrcond > $nbrAnd){
            $query .= "AND ";
            $nbrAnd++;
        }

        $query .= "illustrateur LIKE '%".$_POST['illustrateur']."%' ";
        $nbrcond++;
    }
    if(isset($_POST['date']) && strlen($_POST['date']) > 0){
        if(!$echoWHEREOK){$query .= "WHERE ";$echoWHEREOK = true;}
        if($nbrcond > $nbrAnd){
            $query .= "AND ";
            $nbrAnd++;
        }

        $query .= "sortie = '".$_POST['date']."' ";
        $nbrcond++;
    }
    
    $adresse = false;
    $cooperation = false;
    $culture = false;
    $hasard = false;
    $reflexion = false;
    $strategie = false;
    if(isset($_POST['type']) && count($_POST['type']) > 0){
        if(!$echoWHEREOK){$query .= "WHERE ";$echoWHEREOK = true;}
        if($nbrcond > $nbrAnd){
            $query .= "AND ";
            $nbrAnd++;
        }
        foreach ($_POST['type'] as $value) {
        	if($value == "Adresse"){$adresse =true;}
        	if($value == "Coopération"){$cooperation =true;}
        	if($value == "Culture"){$culture =true;}
            if($value == "Hasard"){$hasard =true;}
            if($value == "Réflexion"){$reflexion = true;}
            if($value == "Stratégie"){$strategie = true;}
            
        }
        
        $ids = join("','",$_POST['type']);  
        
        $query .= "type IN ('$ids') ";
        $nbrcond++;

    }   
    
    //Si aucun POST concernant la recherche on ajoute la condition 
    if(empty($_POST['nom']) && empty($_POST['age']) && empty($_POST['duree']) && empty($_POST['nombre']) && empty($_POST['auteur']) && empty($_POST['editeur']) && empty($_POST['illustrateur']) && empty($_POST['date']) && empty($_POST['type'])){
    	$query .= "WHERE id_jeu != (SELECT id_jeu FROM jeux WHERE validation = 'oui' ORDER BY id_jeu DESC LIMIT 1)";
    }
    
    $query .= "ORDER BY id_jeu DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $jeux = $stmt->fetchAll();
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Liste des jeux</title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/ihover.min.css" />
		<link rel="stylesheet" href="css/bootstrap-select.css" />
		<link rel="stylesheet" href="css/styles.min.css" />

		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>
	</head>

<body id="evenements">

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

							<li class="active"><a href="jeux.php">Découvrir des jeux</a></li>
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
		
		<?php

			while ($last = $lastJeu->fetch(PDO::FETCH_ASSOC)) {
				$image = '<div class="visuelFiche dernierJeu" style="background-image: url(\'images/visuels/'.$last['visuel'].'\');"><div class="container"><div class="row"><div class="col-sm-12"><h2 class="pull-right">'.$last['nom'].'</h2></div></div><a href="fiche.php?id='.$last['id_jeu'].'" type="button" class="btn btn-primary pull-right">Découvrir le jeu</a></div></div>';
				echo $image;
			}
				$lastJeu->closeCursor();

		?>

		<div class="container">

			<div class="row">

				<section class="col-md-3 col-sm-4 col-xs-12 research">

					<form method="post" action="jeux.php" class="form-horizontal researchForm" role="form">


							<div class="form-group">
								<label for="nom" class="control-label labelBold">Nom du jeu</label>
								<input class="form-control" type="text" name="nom" id="nom" value="<?php if(isset($_POST['age'])){echo $_POST['nom'];}?>"/>
							</div>	

							<div class="form-group">
								<select name="duree" class="selectpicker col-sm-12">
								    <option value="0">Durée</option>
								    <option <?php if(isset($_POST['duree']) && $_POST['duree'] == "Moins de 30 min"){echo " selected ";}?> value="Moins de 30 min">Moins de 30 min</option>
								    <option <?php if(isset($_POST['duree']) && $_POST['duree'] == "De 30 à 60 min"){echo " selected ";}?> value="De 30 à 60 min">De 30 à 60 min</option>
								    <option <?php if(isset($_POST['duree']) && $_POST['duree'] == "Plus de 60 min"){echo " selected ";}?> value="Plus de 60 min">Plus de 60 min</option>
								</select>
							</div>

							<div class="form-group">
								<select name="nombre" class="selectpicker col-sm-12">
								    <option value="0">Nombre de joueurs</option>
								    <option <?php if(isset($_POST['nombre']) && $_POST['nombre'] == "Minimum 2"){echo " selected ";}?> value="Minimum 2">Minimum 2</option>
								    <option <?php if(isset($_POST['nombre']) && $_POST['nombre'] == "Minimum 4"){echo " selected ";}?>value="Minimum 4">Minimum 4</option>
								    <option <?php if(isset($_POST['nombre']) && $_POST['nombre'] == "Plus de 4"){echo " selected ";}?>value="Plus de 4">Plus de 4</option>
								</select>
							</div>

							<div class="form-group">
								<select name="age" class="selectpicker col-sm-12">
								    <option value="0">Age minimum</option>
								    <option <?php if(isset($_POST['age']) && $_POST['age'] == "A partir de 2 ans"){echo " selected ";}?>value="A partir de 2 ans">A partir de 2 ans</option>
								    <option <?php if(isset($_POST['age']) && $_POST['age'] == "A partir de 4 ans"){echo " selected ";}?>value="A partir de 4 ans">A partir de 4 ans</option>
								    <option <?php if(isset($_POST['age']) && $_POST['age'] == "A partir de 6 ans"){echo " selected ";}?>value="A partir de 6 ans">A partir de 6 ans</option>
								    <option <?php if(isset($_POST['age']) && $_POST['age'] == "A partir de 8 ans"){echo " selected ";}?>value="A partir de 8 ans">A partir de 8 ans</option>
								    <option <?php if(isset($_POST['age']) && $_POST['age'] == "A partir de 10 ans"){echo " selected ";}?>value="A partir de 10 ans">A partir de 10 ans</option>
								</select>
							</div>

							<div class="form-group ">
								<label class="control-label labelBold">Type de jeux</label>
								<div class="row">
									<div class="col-sm-6">
										<label class="checkbox">
										    <input type="checkbox" id="inlineCheckbox1" name="type[]" class="checkbox" <?php if($adresse){echo " checked ";}?> value="Adresse" > Adresse
										</label>
										<label class="checkbox">
										    <input type="checkbox" id="inlineCheckbox2" name="type[]" class="checkbox" <?php if($cooperation){echo " checked ";}?> value="Coopération" > Coopération
										</label>
										<label class="checkbox">
										    <input type="checkbox" id="inlineCheckbox3" name="type[]" class="checkbox" <?php if($culture){echo " checked ";}?> value="Culture" > Culture
										</label>
										
									</div>
									<div class="col-sm-6">
										<label class="checkbox">
										    <input type="checkbox" id="inlineCheckbox4" name="type[]" class="checkbox" <?php if($hasard){echo " checked ";}?> value="Hasard" > Hasard
										</label>
										<label class="checkbox">
										    <input type="checkbox" id="inlineCheckbox5" name="type[]" class="checkbox" <?php if($reflexion){echo " checked ";}?> value="Réflexion" > Réflexion
										</label>
										<label class="checkbox">
										    <input type="checkbox" id="inlineCheckbox6" name="type[]" class="checkbox" <?php if($strategie){echo " checked ";}?> value="Stratégie" > Stratégie
										</label>
									</div>
								</div>
							</div>	

							<div class="form-group">
								<label for="auteur" class="control-label labelBold">Auteur</label>
								<input class="form-control" type="text" name="auteur" id="auteur" value="<?php if(isset($_POST['auteur'])){echo $_POST['auteur'];}?>"/>
							</div>

							<div class="form-group">
								<label for="editeur" class="control-label labelBold">Editeur</label>
								<input class="form-control" type="text" name="editeur" id="editeur" value="<?php if(isset($_POST['editeur'])){echo $_POST['editeur'];}?>" />
							</div>

							<div class="form-group">
								<label for="illustrateur" class="control-label labelBold">Illustrateur</label>
								<input class="form-control" type="text" name="illustrateur" id="illustrateur" value="<?php if(isset($_POST['illustrateur'])){echo $_POST['illustrateur'];}?>"/>
							</div>

							<div class="form-group">
								<label for="date" class="control-label labelBold">Date de sortie</label>
								<input class="form-control" type="text" name="date" id="date" placeholder="2010" value="<?php if(isset($_POST['date'])){echo $_POST['date'];}?>"/>
							</div>

					<div class="row text-center form-group">
							<input class="btn btn-default" type="submit" name="recherche" value="Rechercher" id="recherche" />
					</div>
				</form>

				</section>

				<section class="col-md-9 col-sm-8 col-xs-12">

					<div class="row">

						<ul class="blocs">

							<?php 

									foreach ($jeux as $key => $value) {

										if($value['validation'] == "oui") {
											$li = '<li class="col-md-4 col-sm-6 col-xs-12 ih-item square effect10 bottom_to_top listeJeux"><a href="fiche.php?id='.$value['id_jeu'].'"><div class="img"><img src="images/miniatures/'.$value['visuel'].'" alt="'.$value['nom'].'" /><h3>'.$value['nom'].'</h3></div><div class="info"><ul><li class="resum"><span class="personnes"></span><p>'.$value['nombre'].'</p></li><li class="resum"><span class="sablier"></span><p>'.$value['duree'].'</p></li><li class="resum"><span class="identite"></span><p>'.$value['age'].'</p></li><li class="resum"><span class="coupe"></span><p>'.$value['type'].'</p></li></ul></div></a></li>';
											echo $li;
										}
									}
					

					 		?>

						</ul>


					</div>

				</section>

			</div>

		</div>

	</div>

	<?php include("footer.php"); ?>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/scripts.min.js"></script>

</body>

</html>