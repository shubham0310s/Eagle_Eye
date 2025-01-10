<?php

include('society_dbE.php');

$society = $_SESSION['a_society'];
$query = "SELECT * FROM messages WHERE sender_role='Admin' AND society_reg = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $society);
$stmt->execute();
$result = $stmt->get_result();
$messages = $result->fetch_all(MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode(['status' => 'success', 'data' => $messages]);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender = $_SESSION['m_flat'];
    $recipient = $_POST['recipient'];

    $query = "SELECT * FROM chat_messages WHERE 
              (sender = '$sender' AND recipient = '$recipient') 
              OR (sender = '$recipient' AND recipient = '$sender') 
              ORDER BY timestamp ASC";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $messages = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $messages[] = $row;
        }
        echo json_encode(['status' => 'success', 'data' => $messages]);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}


$user_id = $_SESSION['user_id']; // Logged-in user's ID
$input = json_decode(file_get_contents('php://input'), true);
$recipient_id = $input['recipient_id'];

$sql = "SELECT * FROM messages 
        WHERE (sender_id = ? AND recipient_id = ?) 
        OR (sender_id = ? AND recipient_id = ?)
        ORDER BY timestamp ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $user_id, $recipient_id, $recipient_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode(["status" => "success", "data" => $messages]);
?>