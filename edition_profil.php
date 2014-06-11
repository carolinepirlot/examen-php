<?php 
session_start();

error_reporting(E_ALL ^ E_NOTICE);

require("php/config.php");
include("php/fonctions.php");

if (!isset($_SESSION['pseudo'])) {
	header("Location: index.php");
}

include("php/try-membres.php");

$id_user = $membre['id'];

include("php/try-evenements.php");

try {
	$stmt = $conn->prepare('SELECT * FROM evenements WHERE id_event IN(SELECT id_event FROM evenements_inscrits WHERE id_user = :id_user AND active = 1)');
	$stmt->execute(array(
		':id_user' => $id_user
	));
	$inscrits = $stmt->fetchAll(PDO::FETCH_ASSOC);


} catch(PDOException $e) {
	echo 'ERROR: ' . $e->getMessage();
}

if(count($_POST)>0) {

	$errors = array();

	$pseudo = trim(strip_tags($_POST['pseudo']));
	$email = trim(strip_tags($_POST['email']));
	$mdp = trim(strip_tags($_POST['mdp']));
	$prefereUn = trim(strip_tags($_POST['prefereUn']));
	$prefereDeux = trim(strip_tags($_POST['prefereDeux']));
	$prefereTrois = trim(strip_tags($_POST['prefereTrois']));
	$id = $_SESSION['id'];

	// var_dump($_FILES['avatar']);

	if(empty($pseudo)){
		$errors['pseudo'][] = "Vous ne pouvez pas rester sans pseudo";
	}

	if(empty($mdp)){
		$errors['mdp'][] = "Le mot de passe est obligatoire";
	}

	if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {

        if ($_FILES['avatar']['size'] <= 100000000){
            $infosfichier = pathinfo($_FILES['avatar']['name']);
            $extension_upload = $infosfichier['extension'];
            $extensions_autorisees = array('jpg', 'jpeg', 'png');

        	$name = preg_replace("/[^A-Z0-9._-]/i", "_", $_FILES['avatar']["name"]);
            $i = 0;
            $parts = pathinfo($name);

                while (file_exists("images/avatars/" . $name)) {
                    $i++;
                    $name = $parts['filename'] . '(' . $i .').' . $parts['extension'];
                }

                if (in_array($extension_upload, $extensions_autorisees)){
                	$avatar = 'images/avatars/' . $name;
                    
                    move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar);
                    
                    if (!copy($avatar, 'images/miniavatars/'.$name)) {
					    //echo "La copie $file du fichier a échoué...\n";
					}
                    redimPicture($avatar, 0, 2900, 70);
                    redimPicture('images/miniavatars/'.$name, 0, 400, 70);
                }
        }
        
	} else {
		$avatar = $membre['avatar'];
	}

	// if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {

		
	// 	if ($_FILES['avatar']['size'] <= 1000000){
	// 	    $infosfichier = pathinfo($_FILES['avatar']['name']);
	// 	    $extension_upload = $infosfichier['extension'];
	// 	    $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');

	// 	    $name = preg_replace("/[^A-Z0-9._-]/i", "_", $_FILES['avatar']["name"]);
 //            $i = 0;
 //            $parts = pathinfo($name);

 //            while (file_exists("images/avatars/" . $name)) {
 //                $i++;
 //                $name = $parts['filename'] . '(' . $i .').' . $parts['extension'];
 //            }

 //            if (in_array($extension_upload, $extensions_autorisees)){
 //            	$avatar = 'images/avatars/' . $name;
 //                move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar);
 //            }
	// 	}
	// } else {
	// 	$avatar = $membre['avatar'];
	// }
			
	if(is_valid_email($email)) {
			
		try {
			$stmt = $conn->prepare('UPDATE membres SET pseudo = :pseudo, email = :email, mdp = :mdp, avatar = :avatar, prefereUn = :prefereUn, prefereDeux = :prefereDeux, prefereTrois = :prefereTrois WHERE id=:id');
			$stmt->execute(array(
				'id' => $id,
				':pseudo' => $pseudo,
				':email' => $email,
				':mdp' => $mdp,
				':avatar' => $name,
				':prefereUn' => $prefereUn,
				':prefereDeux' => $prefereDeux,
				':prefereTrois' => $prefereTrois,

		));

		} catch(PDOException $e) {
				echo 'ERROR: ' . $e->getMessage();
		}
			// }
			

	} else {
		$errors['email'][] = "Votre email est nécéssaire";
	}

	if(count($errors)<1){

		$_SESSION['pseudo'] = $pseudo;
		
		header("Location: accueil.php");
			
	}
			
}



 ?>

<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Mon espace</title>
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

			<h2 class="text-center">Mon profil</h2>


			<ul class="nav nav-tabs" id="myTab">
				<li class="active"><a href="#editionProf" data-toggle="tab">Edition de mon profil</a></li>
				<li><a href="#organiser" data-toggle="tab">Evénements que j'ai créés</a></li>
				<li><a href="#participer" data-toggle="tab">Evénéments auxquels je participe</a></li>
			</ul>


			<div class="tab-content">
			  	<div class="tab-pane fade in active" id="editionProf">

			  		<form method="post" action="#" class="form-horizontal espaceTab" role="form" enctype="multipart/form-data">

						<div class="row">

							<section class="col-sm-7">

								<div class="form-group ">
									<label for="pseudo" class="control-label">Pseudo</label>
									<input class="form-control" type="text" name="pseudo" id="pseudo" value="<?php echo $membre['pseudo']; ?>" />
									<?php echo message_erreur($errors, 'pseudo'); ?>
								</div>	

								<div class="form-group ">
									<label for="email" class="control-label">Email</label>
									<input class="form-control" type="email" name="email" id="email" value="<?php echo $membre['email']; ?>" />
									<?php echo message_erreur($errors, 'email'); ?>
								</div>

								<div class="form-group ">
									<label for="mdp" class="control-label">Mot de passe</label>
									<input class="form-control" type="password" name="mdp" id="mdp" value="<?php echo $membre['mdp']; ?>" />
									<?php echo message_erreur($errors, 'mdp'); ?>
								</div>	

							</section>

							<section class="col-sm-5 text-center prev">

								<img src="images/miniavatars/<?php echo $membre['avatar']; ?>" alt="" id="apercu" class="img-circle avatarProfil">

								<div class="form-group">
								    <input type="file" id="avatar" class="avatar" name="avatar" value="<?php echo $membre['avatar']; ?>">
								</div>

							</section>

						</div>

						<div class="row">

							<div class="col-sm-12">

								<label for="preferes" class="control-label">Mes 3 jeux préférés</label>

								<div class="row">

									<div class="form-group">
											
										<div class="col-sm-4 inputEspace">
											<input class="form-control col-sm-4" type="text" name="prefereUn" id="prefereUn" value="<?php echo $membre['prefereUn']; ?>" />
										</div>
										<div class="col-sm-4 inputEspace">
											<input class="form-control col-sm-4" type="text" name="prefereDeux" id="prefereDeux" value="<?php echo $membre['prefereDeux']; ?>" />
										</div>
										<div class="col-sm-4 inputEspace">
											<input class="form-control col-sm-4" type="text" name="prefereTrois" id="prefereTrois" value="<?php echo $membre['prefereTrois']; ?>" />
										</div>
									</div>

								</div>
								
							</div>

						</div>

						<div class="row">
							<div class="col-sm-12">
								<input class="btn btn-default pull-right supProfil" type="submit" name="editionProfil" value="Valider les changements" id="editionProfil" />
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12 text-right">
								<?php 
									if(isset($_SESSION['pseudo'])){								
										echo '<a href="php/suppression_membre.php?id='.$membre['id'].'">Supprimer mon compte</a>';	
									}
								 ?>
							</div>
						</div>
					</form>
					
				</div>

			  	<div class="tab-pane fade" id="organiser">

			  		<table class="table table-hover">
						<thead>
							<tr>
								<td>Nom de l'événement</td>
								<td>Jeu</td>
								<td>Date</td>
								<td >Lieu</td>
								<td class="tabNbre">Personnes recherchées</td>
							</tr>	
						</thead>
						<tbody>
							<?php 
								if($events){

									foreach ($events as $event) {

										if($event['membre_id'] == $membre['id']) {
												
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
									echo "Vous n'avez actuellement créé aucun événement";
								}
							?>
						</tbody>
					</table>

			  	</div>

			  	<div class="tab-pane fade" id="participer">

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

								if($inscrits){

									foreach ($inscrits as $inscrit) {
												
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
									echo "Vous n'êtes actuellement inscrit(e) à aucun événement";
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