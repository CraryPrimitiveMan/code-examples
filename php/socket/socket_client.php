<?php
function debug($msg)
{
    echo $msg;
    // error_log($msg, 3, '/tmp/socket.log');
}

if (isset($argv[1])) {
    // stream_socket_client — Open Internet or Unix domain socket connection
    $socket_client = stream_socket_client('tcp://0.0.0.0:2000', $errno, $errstr, 30);

    // 如果 mode 为0，资源流将会被转换为非阻塞模式；如果是1，资源流将会被转换为阻塞模式。
    // 该参数的设置将会影响到像 fgets() 和 fread() 这样的函数从资源流里读取数据。 在非阻塞模式下，调用 fgets() 总是会立即返回；而在阻塞模式下，将会一直等到从资源流里面获取到数据才能返回。
    stream_set_blocking($socket_client, 0);
    // stream_set_timeout($socket_client, 0, 100000);

    if (!$socket_client) {
        die("$errstr ($errno)");
    } else {
        $msg = trim($argv[1]);
        for ($i = 0; $i < 10; $i ++) {
            $res = fwrite($socket_client, "$msg($i)");
            usleep(100000);
            echo 'W';
            debug(fread($socket_client, 1024));
        }

        fwrite($socket_client, "/r/n");
        // debug(fread($socket_client, 1024));
        fclose($socket_client);
    }
} else {
    for ($i = 0; $i < 10; $i++) {
        system("php " . __FILE__ . " '{$i}:test'");
    }
}
