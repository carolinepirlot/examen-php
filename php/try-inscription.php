<?php

try {
	$stmt = $conn->prepare('SELECT * FROM evenements WHERE id_event IN(SELECT id_event FROM evenements_inscrits WHERE id_user = :id_user AND active = 1 ORDER BY id_event DESC) LIMIT 0,3');
	$stmt->execute(array(
		':id_user' => $id_user
	));
	$inscrits = $stmt->fetchAll(PDO::FETCH_ASSOC);


} catch(PDOException $e) {
	echo 'ERROR: ' . $e->getMessage();
}

try {
	$stmt = $conn->prepare('SELECT * FROM evenements WHERE id_event IN(SELECT id_event FROM evenements_inscrits WHERE id_user = :id_user AND active = 1)');
	$stmt->execute(array(
		':id_user' => $id_user
	));
	$inscritsEvent = $stmt->fetchAll(PDO::FETCH_ASSOC);


} catch(PDOException $e) {
	echo 'ERROR: ' . $e->getMessage();
}

?>