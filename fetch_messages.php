<?php
// Include database connection
include("society_dbE.php");

// Set content type to JSON
header('Content-Type: application/json');

// Start session to check user authentication
session_start();
if (!isset($_SESSION['m_logged_in'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit;
}

// Retrieve POST data
$data = json_decode(file_get_contents('php://input'), true);
$sender_name = $data['sender_name'] ?? null;
$recipient_name = $data['recipient_name'] ?? null;

// Validate input
if (!$sender_name || !$recipient_name) {
    echo json_encode(['status' => 'error', 'message' => 'Sender or recipient name is missing']);
    exit;
}

try {
    // Prepare SQL query
    $sql = "SELECT * FROM messages 
            WHERE (sender_name = ? AND recipient_name = ?) 
               OR (sender_name = ? AND recipient_name = ?) 
            ORDER BY timestamp ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $sender_name, $recipient_name, $recipient_name, $sender_name);

    // Execute query and fetch results
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $messages = [];
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
        // Return success response with messages
        echo json_encode(['status' => 'success', 'data' => $messages]);
    } else {
        // Handle query execution error
        echo json_encode(['status' => 'error', 'message' => 'Failed to fetch messages']);
    }

    // Close statement
    $stmt->close();
} catch (Exception $e) {
    // Handle exceptions
    echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
}

// Close database connection
$conn->close();
?>