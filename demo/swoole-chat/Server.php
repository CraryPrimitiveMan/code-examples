<?php
$map = [];
$server = new swoole_websocket_server("0.0.0.0", 9501);

$server->on('open', function (swoole_websocket_server $server, $request) use(&$map) {
    var_dump($request);
    echo "server: handshake success with fd{$request->fd}\n";
    $map[$request->fd] = $request->fd;
});

$server->on('message', function (swoole_websocket_server $server, $frame) use(&$map) {
    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    // var_dump($map);
    foreach ($map as $id => $value) {
        $server->push($id, "this is server, " . $frame->data);
    }
});

$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});

$server->start();
