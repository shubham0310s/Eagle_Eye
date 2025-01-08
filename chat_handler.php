<?php
include("society_dbE.php");
session_start();

class ChatHandler
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function sendMessage($sender_id, $receiver_id, $message, $sender_role, $receiver_role, $society_reg)
    {
        $message = mysqli_real_escape_string($this->conn, $message);
        $query = "INSERT INTO messages (sender_id, receiver_id, message, sender_role, receiver_role, society_reg) 
                 VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssss", $sender_id, $receiver_id, $message, $sender_role, $receiver_role, $society_reg);

        $response = array();
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Message sent successfully';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to send message';
        }

        return json_encode($response);
    }

    public function getMessages($user_id, $other_id, $society_reg)
    {
        $query = "SELECT * FROM messages 
                 WHERE ((sender_id = ? AND receiver_id = ?) 
                 OR (sender_id = ? AND receiver_id = ?))
                 AND society_reg = ? 
                 AND deleted_at IS NULL 
                 ORDER BY created_at ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $user_id, $other_id, $other_id, $user_id, $society_reg);
        $stmt->execute();

        $result = $stmt->get_result();
        $messages = array();

        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }

        return $messages;
    }

    public function markAsRead($msg_id, $receiver_id)
    {
        $query = "UPDATE messages SET is_read = TRUE 
                 WHERE msg_id = ? AND receiver_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("is", $msg_id, $receiver_id);
        return $stmt->execute();
    }
}

// API Endpoints
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chat = new ChatHandler($conn);

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'send':
                echo $chat->sendMessage(
                    $_POST['sender_id'],
                    $_POST['receiver_id'],
                    $_POST['message'],
                    $_POST['sender_role'],
                    $_POST['receiver_role'],
                    $_POST['society_reg']
                );
                break;

            case 'get':
                echo json_encode($chat->getMessages(
                    $_POST['user_id'],
                    $_POST['other_id'],
                    $_POST['society_reg']
                ));
                break;

            case 'read':
                echo json_encode([
                    'success' => $chat->markAsRead(
                        $_POST['msg_id'],
                        $_POST['receiver_id']
                    )
                ]);
                break;
        }
    }
}
?>