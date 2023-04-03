<?php
namespace App\WS;
use App\Http\Controllers\OperationsController;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Websocket implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo $msg;
        //msg type { msg_type: 'operations-all', receiverId: 1234 }
        $msg = json_decode($msg);
        if($msg && property_exists($msg, 'msg_type') && $msg->msg_type == 'operations-all'){
            $test = new OperationsController();
            $history = $test->getOperationsHistory($msg->receiverId);
            foreach ($this->clients as $client) {
                $client->send(json_encode($history));
            }
        }

        foreach ($this->clients as $client) {
            $client->send($msg);
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
