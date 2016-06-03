<?php

$socket = @stream_socket_client(
    'tcp://127.0.0.1:6379',
    $errorNumber,
    $errorDescription,
    ini_get("default_socket_timeout")
);
// $command = "*3\r\n$3\r\nSET\r\n$5\r\nmykey\r\n$7\r\nmyvalue\r\n";
var_dump($command);die;
fwrite($socket, $command);

if (($line = fgets($socket)) === false) {
    throw new Exception("Failed to read from socket.\nRedis command was: " . $command);
}
var_dump($line);
