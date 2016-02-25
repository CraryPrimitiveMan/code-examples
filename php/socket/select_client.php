<?php

function debug($msg)
{
    // echo $msg;
    error_log($msg, 3, '/tmp/socket.log');
}

if (isset($argv[1])) {
    $socket_client = stream_socket_client('tcp://0.0.0.0:2000', $errno, $errstr, 30);

    if (!$socket_client) {
        die("$errstr ($errno)");
    } else {
        $msg = trim($argv[1]);
        for ($i = 0; $i < 10; $i++) {
            echo "$msg($i)\n";
            $res = fwrite($socket_client, "$msg($i)\n");
            // usleep(100000);
            // debug(fread($socket_client, 1024));
        }
        // echo "quit\n";
        fwrite($socket_client, "quit\n");
        // debug(fread($socket_client, 1024));
        fclose($socket_client);
    }
} else {
    $phArr = [];
    for ($i = 0; $i < 10; $i++) {
        $command = "php " . __FILE__ . " {$i}:test";
        echo $command, "\n";
        $phArr[$i] = popen($command, 'w');
        // usleep(100000);
    }
    foreach ($phArr as $ph) {
        pclose($ph);
    }
}
