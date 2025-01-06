<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require dirname(__DIR__) . '/vendor/autoload.php'; // Include the Composer autoloader

class ChatServer implements MessageComponentInterface
{
    protected $clients;
    protected $users;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->users = [];
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Store connection and associate with user role
        $this->clients->attach($conn);
        $conn->send("Welcome to the chat!");

        // Store role and user information if sent in the connection request
        $data = json_decode($conn->receive(), true);
        if (isset($data['role'])) {
            $this->users[$conn->resourceId] = $data['role'];
        }
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);
        $senderRole = $this->users[$from->resourceId] ?? 'guest';

        // Broadcast message to all clients
        foreach ($this->clients as $client) {
            if ($from !== $client) { // Don't send the message to the sender
                $client->send(json_encode([
                    'role' => $senderRole,
                    'message' => $data['message'],
                    'sender_id' => $data['sender_id'],
                    'sender_role' => $senderRole,
                    'timestamp' => date("Y-m-d H:i:s")
                ]));
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // Remove the user from clients and users arrays
        $this->clients->detach($conn);
        unset($this->users[$conn->resourceId]);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Error: " . $e->getMessage();
        $conn->close();
    }
}

// Create WebSocket server
$server = new Ratchet\App("localhost", 8080);
$server->route('/chat', new ChatServer, ['*']);
$server->run();
