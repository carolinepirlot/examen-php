<?php
session_start();

error_reporting(E_ALL ^ E_NOTICE);

require("php/config.php");
include("php/fonctions.php");

if (!isset($_SESSION['pseudo'])) {
	header("Location: index.php");
}

$id = $_GET['id'];

include("php/try-membres.php");

$id_user = $mbre['id'];

include("php/try-evenements.php");

include("php/try-inscription.php");


?>

<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Profil de <?php echo $mbre['pseudo']; ?></title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/styles.min.css" />

		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>
	</head>

<body id="profil">

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

			<h2 class="text-center"><?php echo $mbre['pseudo']; ?></h2>			

				<div class="row">
					<div class="col-xs-12"><h4 class="story">Qui suis-je ?</h4></div>
				</div>
				<div class="row">

					<section class="col-sm-7">

						<p>Bonjour !</p>

						<p>Commençons par le début. Mon petit nom ici, comme vous pouvez le voir, c'est <span class="profilInfos"><?php echo $mbre['pseudo']; ?></span>.</p>

						<?php
							if ($mbre['prefereUn'] == '' && $mbre['prefereDeux']=='' && $mbre['prefereTrois']== '') {
								echo "<p>Actuellement, je n'ai pas encore de jeux préférés à partager avec vous.</p>";
							} else {
								echo '<p>Je ne vais pas déballer ma vie sur la place publique. A la place, je vais vous donner le nom d\'un ou plusieurs jeux qui me plaisent 
								comme par exemple : <span class="profilInfos">'.$mbre['prefereUn'].'</span>';
									if ($mbre['prefereDeux'] !== '') {
										echo ", ";
										echo '<span class="profilInfos">'.$mbre['prefereDeux'].'</span>';
									}

									if ($mbre['prefereTrois'] !== '') {
										echo " et ";
										echo '<span class="profilInfos">'.$mbre['prefereTrois'].'</span>';
									}
								echo ".</p>";
							}
						?>

						<p>Dans tous les cas, ça me ferait plaisir de rencontrer de nouvelles personnes avec qui jouer.
							Alors n'hésite pas à t'inscrire aux événements auxquels je participe.</p>

						<p>A bientot qui sait !</p>	
					</section>

					<section class="col-sm-5">
						<img src="images/miniavatars/<?php echo $mbre['avatar']; ?>" alt="" id="apercu" class="img-circle avatarProfil">
					</section>

				</div>


			<div class="row">
				<div class="col-xs-12"><h4>Les événements que <?php echo $mbre['pseudo']; ?> a créés</h4></div>
			</div>

			<table class="table table-hover">
				<thead>
					<tr>
						<td>Nom de l'événement</td>
						<td>Jeu</td>
						<td>Date</td>
						<td class="tabNbre">Lieu</td>
						<td class="tabNbre">Personnes recherchées</td>
					</tr>	
				</thead>
				<tbody>
					<?php 
						if($events){

							foreach ($events as $event) {

								if($event['membre_id'] == $mbre['id']) {
										
									echo '<tr>';
										echo '<td><a class="titreEvent" href="fiche_evenement.php?id='.$event['id_event'].'">'.$event['titre'].'</a></td>';
										echo '<td>'.$event['jeux'].'</td>';
										echo '<td>'.$event['date'].'</td>';
										echo '<td class="tabNbre">'.$event['ville'].'</td>';
										echo '<td class="tabNbre">'.$event['nbre'].'</td>';
									echo '</tr>';
								}
							}
						}
						else {
							echo ''.$mbre['pseudo'].' n\'a actuellement créé aucun événement';
						}
					?>
				</tbody>
			</table>

			<div class="row">
				<div class="col-xs-12"><h4>Les événements auxquels <?php echo $mbre['pseudo']; ?> participe</h4></div>
			</div>

			<table class="table table-hover">
				<thead>
					<tr>
						<td>Nom de l'événement</td>
						<td>Jeu</td>
						<td>Date</td>
						<td class="tabNbre">Lieu</td>
						<td class="tabNbre">Personnes recherchées</td>
					</tr>	
				</thead>
				<tbody>
					<?php
						if($inscritsEvent){

							foreach ($inscritsEvent as $inscrit) {
										
								echo '<tr>';
									echo '<td><a class="titreEvent" href="fiche_evenement.php?id='.$inscrit['id_event'].'">'.$inscrit['titre'].'</a></td>';
									echo '<td>'.$inscrit['jeux'].'</td>';
									echo '<td>'.$inscrit['date'].'</td>';
									echo '<td class="tabNbre">'.$inscrit['ville'].'</td>';
									echo '<td class="tabNbre">'.$inscrit['nbre'].'</td>';
								echo '</tr>';
							}
						}
						else {
							echo ''.$mbre['pseudo'].' ne participe actuellement à aucun événement';
						}

					?>
				</tbody>
			</table>

		</div>

	</div>

	<?php include("footer.php"); ?>


	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/scripts.min.js"></script>

</body>

</html>