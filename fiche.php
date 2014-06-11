<?php
session_start();

error_reporting(E_ALL ^ E_NOTICE);

require("php/config.php");
include("php/fonctions.php");

$id = $_GET['id'];

include("php/try-jeux.php");

include("php/try-membres.php");

include("php/try-evenements.php");

// Partie commentaires

if(count($_POST)>0) {

	$contenu = trim(strip_tags($_POST['contenu']));
	$jeu_id = trim(strip_tags($_POST['jeu_id']));
	$membre_id = trim(strip_tags($_POST['membre_id']));

	try {       
		$stmt = $conn->prepare('INSERT INTO commentaires_jeux (pseudo, contenu, jeu_id, membre_id) VALUES (:pseudo, :contenu, :jeu_id, :membre_id)');
		$stmt->execute(array(
			':pseudo' => $membre['pseudo'],
			':contenu' => $contenu,
			':jeu_id' => $jeu_id,
			':membre_id' => $membre_id,
		));

	} catch(PDOException $e) {
		echo 'ERROR: ' . $e->getMessage();
	}

}

include("php/try-commentaires.php");

?>

<!DOCTYPE html>
<html lang="fr">

	<head>
		<title><?php echo $jeu['nom'] ?></title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/styles.min.css" />

		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>
	</head>

<body id="fiche">

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
		<div class="visuelFiche" style="background-image: url('images/visuels/<?php echo $jeu['visuel'] ?>');">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<h2 class="centerH2"><?php echo $jeu['nom']; ?></h2>
					</div>
				</div>
			</div>
		</div>

		<div class="container">

			<div class="row">

				<div class="col-sm-8">	

					<div class="responsiveInfos">
						<ul class="text-center www col-sm-12">
							<li><span class="personnes"></span><?php echo $jeu['nombre']; ?></li>
							<li><span class="sablier"></span><?php echo $jeu['duree']; ?></li>
							<li><span class="identite"></span><?php echo $jeu['age']; ?></li>
							<li><span class="coupe"></span><?php echo $jeu['type']; ?></li>
						</ul>
					</div>		

					<ul class="nav nav-tabs" id="myTab">
					  	<li class="active"><a href="#infos" data-toggle="tab">Descriptif</a></li>
					  	<li><a href="#rules" data-toggle="tab">Règles</a></li>
					  	<li><a href="#comm" data-toggle="tab">Commentaires</a></li>
					  	<li><a href="#events" data-toggle="tab">Evénements</a></li>

					</ul>


					<div class="tab-content">
					  	<div class="tab-pane fade in active" id="infos">

							<p class="droits">Auteur : <a class="lien" href="<?php echo $jeu['auteur_url']; ?>" target="<?php if($jeu['auteur_url'] !== "#") { echo "_blank"; } ?>">
								<?php echo $jeu['auteur']; ?></a> &nbsp; &nbsp; &nbsp; &nbsp; Illustrateur : <a class="lien" href="<?php echo $jeu['illustrateur_url']; ?>" target="<?php if($jeu['illustrateur_url'] !== "#") { echo "_blank"; } ?>">
								<?php echo $jeu['illustrateur']; ?></a> &nbsp; &nbsp; &nbsp; &nbsp; Editeur : <a class="lien" href="<?php echo $jeu['editeur_url']; ?>" target="<?php if($jeu['editeur_url'] !== "#") { echo "_blank"; } ?>">
								<?php echo $jeu['editeur']; ?></a>&nbsp; &nbsp; &nbsp; &nbsp;<span class="">( <?php echo $jeu['sortie']; ?> )</span></p>					  		

							<h4 class="descriptif">Description</h4>
							<?php 
							$sanitized = htmlspecialchars($jeu['description'], ENT_QUOTES);				
							?>
							<p><?php echo str_replace(array("\r\n", "\n"), array("<br />", "<br />"), $sanitized); ?></p>

						</div>

						<div class="tab-pane fade" id="rules">

							<h4>Règles</h4>
							<?php 
								$sanitized = htmlspecialchars($jeu['regles'], ENT_QUOTES);	
							?>
							<p><?php echo str_replace(array("\r\n", "\n"), array("<br />", "<br />"), $sanitized); ?></p>

							<h4>Règle(s) inventée(s)</h4>
							<?php 
								$sanitized = htmlspecialchars($jeu['invention'], ENT_QUOTES);
							?>
							<p><?php echo str_replace(array("\r\n", "\n"), array("<br />", "<br />"), $sanitized); ?></p>


					  	</div>

					  	<div class="tab-pane fade" id="comm">

					  		<h4>Commentaires</h4>

							<?php 

								foreach ($comms as $key => $value) {	
									$li = '<li class="col-sm-12 com"><span class="citation"></span><div class="hope"><a class="auteurCom" href="profil.php?id='.$value['membre_id'].'"><h5>'.$value['pseudo'].'</h5></a><p>'.$value['contenu'].'</p></div></li>';
									echo $li;
											
								}

							?>

							<?php
								if(isset($_SESSION['pseudo'])){
							?>

							<form class="form-group" role="form" method="post">
								<textarea class="form-control areaCom" name="contenu" id="contenu"></textarea>
								<input type="hidden" name="jeu_id" value="<?php echo $jeu['id_jeu']; ?>" />
								<input type="hidden" name="membre_id" value="<?php echo $membre['id']; ?>" />
								<div class="text-center">
									<input class="btn btn-default pull-right" type="submit" name="avis" value="Donner mon avis" id="avis" />
								</div>
							</form>

							<?php
								}
							?>

					  	</div>

					  	<div class="tab-pane fade" id="events">

					  		<table class="table table-hover">
								<thead>
									<tr>
										<td>Nom de l'événement</td>
										<td>Date</td>
										<td>Lieu</td>
										<td class="tabNbre">Personnes recherchées</td>
									</tr>	
								</thead>
								<tbody>
									<?php 
										if($events){

											foreach ($events as $key => $value) {
												if($value['jeux'] == $jeu['nom']) {

													$query = $conn->prepare("SELECT * FROM evenements_inscrits WHERE id_event = :id_event AND active = 1");
													$query->execute(array(
														':id_event' => $value['id_event']
													));
													$results = $query->fetchAll();

													$participant = array();
													foreach ($results as $result) {
														$participant[] = $result['id_user'];
													}
													if($query->rowCount() < $value['nbre'] || in_array($_SESSION['id'], $participant)){
															
														echo '<tr>';
															echo '<td><a class="titreEvent" href="fiche_evenement.php?id='.$value['id_event'].'">'.$value['titre'].'</a></td>';
															echo '<td>'.$value['date'].'</td>';
															echo '<td>'.$value['ville'].'</td>';
															echo '<td class="tabNbre">'.$value['nbre'].'</td>';
														echo '</tr>';

													}
												}

											}
										}
										else {
											echo "Il n'y a actuellement aucun événement";
										}
									?>
								</tbody>
							</table>
					  	</div>
					</div>

				</div>	

				<div class="col-sm-3 col-sm-offset-1 pictos sidebar">

					<ul>
						<li><span class="personnes"></span><p><?php echo $jeu['nombre']; ?></p></li>

						<li><span class="sablier"></span><p><?php echo $jeu['duree']; ?></p></li>

						<li><span class="identite"></span><p><?php echo $jeu['age']; ?></p></li>

						<li><span class="coupe"></span><p><?php echo $jeu['type']; ?></p></li>

						<?php
							if(isset($_SESSION['pseudo'])){					
								if($jeu){								
									echo '<li class="largeur"><a type="button" class="btn btn-primary long" href="edition_jeu.php?id='.$jeu['id_jeu'].'"><span class="plume"></span>Editer la fiche</a></li>';

									if( $membre['role'] == "administrateur" ) {
										echo '<li class="largeur"><a type="button" class="btn btn-primary long" href="php/suppression_jeu.php?id='.$jeu['id_jeu'].'"><span class="poubelle"></span>Supprimer la fiche</a></li>';
									}
								}					
							}
						?>
					</ul>

					
				</div>
			</div>
			<div class="row">

				<div class="col-sm-12 retour">
					<a href="jeux.php"><span class="back"></span>Retourner à la liste des jeux</a>
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