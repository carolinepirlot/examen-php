<?php
try {
	$requete = 'SELECT * FROM jeux WHERE id_jeu = :id_jeu';

	if (isset($_GET['verif']) && $_GET['verif'] == true) {
		$requete = 'SELECT * FROM jeux_attente WHERE id_jeu = :id_jeu';
	}

    $stmt = $conn->prepare($requete);
    $stmt->execute(array(':id_jeu' => $id));

    $jeu = $stmt->fetch();
    
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

try {       
    $stmt = $conn->prepare('SELECT * FROM jeux');
    $stmt->execute();

    $jeux = $stmt->fetchAll();
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

try {       
    $stmt = $conn->prepare('SELECT * FROM jeux_attente');
    $stmt->execute();

    $jeuxAtt = $stmt->fetchAll();
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>