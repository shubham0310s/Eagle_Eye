<?php
require __DIR__ . '/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class ChatServer implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = [];
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Parse the query string to get the user ID
        parse_str($conn->httpRequest->getUri()->getQuery(), $query);
        $userId = $query['user_id'] ?? null;

        if ($userId) {
            // Store the connection with the associated user ID
            $this->clients[$userId] = $conn;
            echo "New connection from User ID: {$userId} ({$conn->resourceId})\n";
        } else {
            // Close connection if no user ID is provided
            $conn->close();
        }
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);

        if (isset($data['to'], $data['message'])) {
            $recipientId = $data['to'];
            $message = $data['message'];

            if (isset($this->clients[$recipientId])) {
                // Send the message to the specific recipient
                $this->clients[$recipientId]->send(json_encode([
                    'from' => array_search($from, $this->clients),
                    'message' => $message,
                ]));
                echo "Message sent from User ID: " . array_search($from, $this->clients) . " to User ID: {$recipientId}\n";
            } else {
                echo "User ID: {$recipientId} is not connected.\n";
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // Remove the connection
        $userId = array_search($conn, $this->clients);
        if ($userId !== false) {
            unset($this->clients[$userId]);
            echo "Connection from User ID: {$userId} has disconnected\n";
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

use Ratchet\App;

// Start the server
$app = new App('localhost', 8080, '0.0.0.0');
$app->route('/chat', new ChatServer, ['*']);
$app->run();
