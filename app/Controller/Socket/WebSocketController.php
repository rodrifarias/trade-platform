<?php

namespace App\Controller\Socket;

use Hyperf\SocketIOServer\{BaseNamespace, Socket};
use Hyperf\SocketIOServer\Annotation\{Event, SocketIONamespace};
use Hyperf\Codec\Json;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Di\Annotation\Inject;

#[SocketIONamespace]
class WebSocketController extends BaseNamespace
{
    #[Inject]
    private StdoutLoggerInterface $logger;

    #[Event('event')]
    public function onEvent(Socket $socket, string $data): string
    {
        return'Event Received: '. $data;
    }

    #[Event('join-room')]
    public function onJoinRoom(Socket $socket, $data): void
    {
        $socket->join($data);
        $socket->to($data)->emit('event', "{$socket->getSid()} has joined {$data}");
        $clients = $socket->getAdapter()->clients($data);
        $this->emit('event', "There are " . count($clients) . " players in {$data}");
    }

    #[Event('say')]
    public function onSay(Socket $socket, $data): void
    {
        $data = Json::decode($data);

        if (!isset($data['room'], $data['message'])) {
            return;
        }

        $socket->to($data['room'])->emit('event', "{$socket->getSid()} say: {$data['message']}");
    }

    #[Event('disconnect')]
    public function onDisconnect(Socket $socket): void
    {
        $sid = $socket->getSid();
        $adapter = $socket->getAdapter();

        foreach ($adapter->clientRooms($sid) as $room) {
            $socket->leave($room);
        }

        $this->logger->info('Socket disconnected: ' . $socket->getSid());
    }
}
