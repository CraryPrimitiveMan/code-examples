<?php
$base_fd = event_base_new();
$times = 0;
$limit = 10;
$index = array();

function httpGet($host, $base_fd) {
    global $index;

    $fd = stream_socket_client("$host", $errno, $errstr, 3, STREAM_CLIENT_ASYNC_CONNECT | STREAM_CLIENT_CONNECT); 
    $index[$fd] = 0;
    $event_fd = event_new();
    event_set($event_fd, $fd, EV_WRITE | EV_PERSIST, function($fd, $events, $arg) use($host) {
        global $times, $limit, $index;

        if(!$index[$fd]) {
            $index[$fd] = 1;
            $out = "GET / HTTP/1.1\r\n";
            $out .= "Host: $host\r\n";
            $out .= "Connection: Close\r\n\r\n";
            fwrite($fd, $out);
        } else {
            $str = fread($fd, 4096);
            echo $str, PHP_EOL;
            if(feof($fd)) {
                fclose($fd);
                $times++;
                echo "done\n";

                if($times == $limit - 1) {
                    event_base_loopexit($arg[1]);
                }
            }
        }
    }, array($event_fd, $base_fd));

    event_base_set($event_fd, $base_fd);
    event_add($event_fd);
}

for($i = 0; $i < $limit; $i++) {
    echo "$i\n";
    httpGet($argv[1], $base_fd);
        //echo file_get_contents("http://$argv[1]");
}

event_base_loop($base_fd);
