<?php
// save_message.php
include 'society_dbE.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $sender_role = $data['sender_role'];
    $sender_name = $data['sender_name'];
    $recipient_role = $data['recipient_role'];
    $recipient_name = $data['recipient_name'];
    $message = $data['message'];

    if (empty($sender_role) || empty($sender_name) || empty($recipient_role) || empty($recipient_name) || empty($message)) {
        echo json_encode(["status" => "error", "message" => "Missing required fields: sender_role, sender_name, recipient_role, recipient_name, or message."]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO messages (sender_role, sender_name, recipient_role, recipient_name, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $sender_role, $sender_name, $recipient_role, $recipient_name, $message);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Message saved']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save message']);
    }
    $stmt->close();
    $conn->close();
}
?>