<?php
// Database Connection
$host = "localhost"; // Replace with your database host
$dbname = "society_db"; // Replace with your database name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Function to Save a Message
function saveMessage($senderId, $receiverId, $message, $senderRole, $receiverRole, $societyReg, $attachmentUrl = null)
{
    global $conn;

    try {
        // Prepare the SQL query
        $sql = "INSERT INTO messages (sender_id, receiver_id, message, sender_role, receiver_role, society_reg, attachment_url)
                VALUES (:sender_id, :receiver_id, :message, :sender_role, :receiver_role, :society_reg, :attachment_url)";

        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':sender_id', $senderId);
        $stmt->bindParam(':receiver_id', $receiverId);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':sender_role', $senderRole);
        $stmt->bindParam(':receiver_role', $receiverRole);
        $stmt->bindParam(':society_reg', $societyReg);
        $stmt->bindParam(':attachment_url', $attachmentUrl);

        // Execute the query
        $stmt->execute();

        return "Message saved successfully!";
    } catch (PDOException $e) {
        return "Error saving message: " . $e->getMessage();
    }
}

// Handle Request Data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get Input Data
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate Input
    $senderId = $data['sender_id'] ?? null;
    $receiverId = $data['receiver_id'] ?? null;
    $message = $data['message'] ?? null;
    $senderRole = $data['sender_role'] ?? null;
    $receiverRole = $data['receiver_role'] ?? null;
    $societyReg = $data['society_reg'] ?? null;
    $attachmentUrl = $data['attachment_url'] ?? null;

    // Check Required Fields
    if ($senderId && $receiverId && $message && $senderRole && $receiverRole && $societyReg) {
        echo saveMessage($senderId, $receiverId, $message, $senderRole, $receiverRole, $societyReg, $attachmentUrl);
    } else {
        echo "Error: All required fields (sender_id, receiver_id, message, sender_role, receiver_role, society_reg) must be provided.";
    }
} else {
    echo "Invalid request method. Use POST.";
}
?>