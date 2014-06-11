<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

require("php/config.php");
include("php/fonctions.php");

include("php/try-membres.php");

if ($membre['role'] !== "administrateur") {
	header("Location: index.php");
}

include("php/try-jeux.php");

?>

<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Liste des jeux</title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/styles.min.css" />

		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>
	</head>

<body id="evenements">

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

			<h2 class="text-center">Liste des jeux de société</h2>

			<div class="row">

				<div class="col-xs-12">

					<table class="table table-hover">
						<thead>
							<tr>
								<td class="tabNbre">ID</td>
								<td>Titres des jeux</td>
								<td>Affiché</td>
								<td>Edition</td>
								<td>Suppression</td>
							</tr>	
						</thead>
						<tbody>
							<?php 
								if($jeux){
									foreach ($jeux as $key) {
										echo '<tr>';
											echo '<td class="tabNbre">'.$key['id_jeu'].'</td>';
											echo '<td><a class="titreEvent" href="fiche.php?id='.$key['id_jeu'].'">'.$key['nom'].'</a></td>';
											echo '<td>'.$key['validation'].'</td>';
											echo '<td><a class="titreEvent" href="edition_jeu.php?id='.$key['id_jeu'].'">Editer</a></td>';
											echo '<td><a class="securite" class="titreEvent" href="php/suppression_jeu.php?id='.$key['id_jeu'].'">Supprimer</a></td>';
										echo '</tr>';
									}
								}
								else {
									echo 'Il y a une erreur';
								}
							?>
						</tbody>

					</table>

				</div>

			</div>

			<hr>

			<div class="row">

				<div class="col-xs-12">

					<table class="table table-hover">
						<thead>
							<tr>
								<td class="tabNbre">ID</td>
								<td>Titres des jeux</td>
								<td>Valider les changements</td>
								<td>Suppression</td>
							</tr>	
						</thead>
						<tbody>
							<?php 
								if($jeuxAtt){
									foreach ($jeuxAtt as $key) {
										echo '<tr>';
											echo '<td class="tabNbre">'.$key['id_jeu'].'</td>';
											echo '<td><a class="titreEvent" href="fiche.php?id='.$key['id_jeu'].'">'.$key['nom'].'</a></td>';
											echo '<td><a class="titreEvent" href="edition_jeu.php?verif=true&id='.$key['id_jeu'].'">Valider les changements</a></td>';
											echo '<td><a class="securite" class="titreEvent" href="php/suppression_jeu.php?verif=true&id='.$key['id_jeu'].'">Supprimer</a></td>';
										echo '</tr>';
									}
								}
								else {
									echo 'Il y a une erreur';
								}
							?>
						</tbody>

					</table>

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