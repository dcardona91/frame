<?php
namespace ThisApp\Models;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use SplObjectStorage;
use Exception;
/**
 *
 */
class Chat implements MessageComponentInterface
{
  protected $clients;

  function __construct()
  {
    $this->clients = new SplObjectStorage;
  }

  public function onOpen(ConnectionInterface $conn)
  {
    $this->clients->attach($conn);
  }

  public function onMessage(ConnectionInterface $conn, $msg)
  {
    foreach ($this->clients as $client)
    {
      if ($client !== $conn)
      $client->send($msg);
    }
  }

  public function onClose(ConnectionInterface $conn)
  {
    $this->clients->detach($conn);
  }

  public function onError(ConnectionInterface $conn, Exception $e)
  {
    echo "The following error occured: ".$e->getMessage();
    $conn->close();
  }
}
