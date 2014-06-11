<?php
try {
	$commentaires = $conn->prepare('SELECT * FROM commentaires_jeux WHERE jeu_id = :jeu_id');
	$commentaires->execute(array(':jeu_id' => $id));

	$comms = $commentaires->fetchAll();

} catch(PDOException $e) {
	echo 'ERROR: ' . $e->getMessage();
}

try {
	$commentaires = $conn->prepare('SELECT * FROM commentaires_events WHERE event_id = :event_id');
	$commentaires->execute(array(':event_id' => $id_event));

	$coms = $commentaires->fetchAll();

} catch(PDOException $e) {
	echo 'ERROR: ' . $e->getMessage();
}
?>