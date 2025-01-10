<?php

session_start();
include("society_dbE.php");

$user_id = $_SESSION['user_id']; // Logged-in user's ID
$input = json_decode(file_get_contents('php://input'), true);
$recipient_id = $input['recipient_id'];
$message = $input['message'];

$sql = "INSERT INTO messages (sender_id, recipient_id, message) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $user_id, $recipient_id, $message);
if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to send message"]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender = $_SESSION['m_flat'];
    $recipient = $_POST['recipient'];
    $message = $_POST['message'];

    if (!empty($sender) && !empty($recipient) && !empty($message)) {
        $query = "INSERT INTO chat_messages (sender, recipient, message) VALUES ('$sender', '$recipient', '$message')";
        if (mysqli_query($conn, $query)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>