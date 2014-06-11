<?php

try { 
    $stmt = $conn->prepare('SELECT * FROM evenements ORDER BY id_event DESC');
    $stmt->execute();

    $events = $stmt->fetchAll();
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

try {       
    $stmt = $conn->prepare('SELECT * FROM evenements WHERE id_event = :id_event');
    $stmt->execute(array(':id_event' => $id_event));

    $event = $stmt->fetch();
    
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

try { 
    $stmt = $conn->prepare('SELECT * FROM evenements WHERE membre_id = :id_user ORDER BY id_event DESC LIMIT 0,3');
	$stmt->execute(array(
		':id_user' => $id_user
	));
   
   	$evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

?>