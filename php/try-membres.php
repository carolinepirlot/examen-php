<?php

try {
	$stmt = $conn->prepare('SELECT * FROM membres WHERE pseudo = :pseudo');
	$stmt->execute(array(
		':pseudo' => $_SESSION['pseudo']
	));

	$membre = $stmt->fetch();

} catch(PDOException $e) {
	echo 'ERROR: ' . $e->getMessage();
}

try {
	$stmt = $conn->prepare('SELECT * FROM membres WHERE id = :id');
	$stmt->execute(array(
		':id' => $id,
	));

	$mbre = $stmt->fetch();
} catch(PDOException $e) {
	echo 'ERROR: ' . $e->getMessage();
}

?>