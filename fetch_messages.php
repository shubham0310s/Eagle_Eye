<?php
// fetch_messages.php
include 'society_dbE.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $sender_name = $data['sender_name'];
    $recipient_name = $data['recipient_name'];

    $stmt = $conn->prepare("SELECT * FROM messages WHERE (sender_name = ? AND recipient_name = ?) OR (sender_name = ? AND recipient_name = ?) ORDER BY timestamp ASC");
    $stmt->bind_param("ssss", $sender_name, $recipient_name, $recipient_name, $sender_name);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    echo json_encode(['status' => 'success', 'data' => $messages]);
    $stmt->close();
    $conn->close();
}
?>