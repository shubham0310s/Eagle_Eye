<?php
require 'vendor/autoload.php';
include("society_dbE.php"); // Include the database connection

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class ChatServer implements MessageComponentInterface
{
    protected $clients;
    private $db;

    public function __construct()
    {
        global $conn; // Use the database connection from society_dbE.php
        $this->clients = new \SplObjectStorage;
        $this->db = $conn;

        if (!$this->db) {
            error_log("Database connection failed: " . mysqli_connect_error());
            die("Database connection failed: " . mysqli_connect_error());
        }
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);

        if (!isset($data['sender_id'], $data['receiver_id'], $data['message'])) {
            error_log("Invalid message format: " . $msg);
            return;
        }

        // Save message to the database
        if ($stmt = $this->db->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)")) {
            $stmt->bind_param("iis", $data['sender_id'], $data['receiver_id'], $data['message']);
            if (!$stmt->execute()) {
                error_log("Failed to execute statement: " . $stmt->error);
            }
            $stmt->close();
        } else {
            error_log("Failed to prepare statement: " . $this->db->error);
        }

        // Broadcast the message to other clients
        foreach ($this->clients as $client) {
            if ($client !== $from) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

$server = new Ratchet\App('localhost', 8080);
$server->route('/chat', new ChatServer);
$server->run();
