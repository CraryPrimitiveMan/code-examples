<?php

function debug($msg)
{
    // echo $msg;
    error_log($msg, 3, '/tmp/socket.log');
}

if (isset($argv[1])) {
    $socket_client = stream_socket_client('tcp://0.0.0.0:2001', $errno, $errstr, 30);

    if (!$socket_client) {
        die("$errstr ($errno)");
    } else {
        $msg = trim($argv[1]);
        for ($i = 0; $i < 10; $i++) {
            $res = fwrite($socket_client, "$msg($i)/n");
            usleep(100000);
            // debug(fread($socket_client, 1024));
        }
        fwrite($socket_client, "quit/n");
        debug(fread($socket_client, 1024));
        fclose($socket_client);
    }
} else {
    $phArr = [];
    for ($i = 0; $i < 10; $i++) {
        $phArr[$i] = popen("php " . __FILE__ . " '{$i}:test'", 'r');
    }
    foreach ($phArr as $ph) {
        pclose($ph);
    }
}
