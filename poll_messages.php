<?php

require 'db.php';
//EVENT LISTENER ENDPOINT
header('Content-Type: application/json');

$last_message_id = isset($_GET['last_message_id']) ? (int)$_GET['last_message_id'] : 0;

while (true) {
    $sql = "SELECT * FROM messages WHERE id > :last_message_id ORDER BY id ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['last_message_id' => $last_message_id]);
    $messages = $stmt->fetchAll();

    if (!empty($messages)) {
        echo json_encode(['status' => 'success', 'messages' => $messages]);
        exit;
    }

    // Sleep for 1 second before checking again
    sleep(1);
}

