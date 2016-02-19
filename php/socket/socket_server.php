<?php
// set_time_limit — 设置脚本最大执行时间
// 如果设置为0（零），没有时间方面的限制。
set_time_limit(0);

class SocketServer
{
    private static $socket;

    public function __construct($port)
    {
        global $errno, $errstr;
        if ($port < 1024) {
            die("Port must be a number which bigger than 1024\n");
        }

        // stream_socket_server — Create an Internet or Unix domain server socket
        $socket = stream_socket_server("tcp://0.0.0.0:{$port}", $errcode, $errstr);
        if (!$socket) {
            die("$errstr ($errno)");
        }

        // stream_set_timeout — Set timeout period on a stream
        // stream_set_timeout($socket, -1);

        while ($conn = stream_socket_accept($socket, -1)) {
            static $id = 0;
            static $ct = 0;
            $ct_last = $ct;
            $ct_data = '';
            $buffer = '';
            $id ++;
            echo "Client $id come.\n";
            while (!preg_match('/\/r?\/n/', $buffer)) {
                // if (feof($conn)) {
                //     break;
                // }

                $buffer = fread($conn, 1024);
                echo 'R';
                $ct += strlen($buffer);
                $ct_data .= preg_replace('/\/r?\/n/', '', $buffer);
            }

            $ct_size = ($ct - $ct_last) * 8;
            echo "[$id] " . __METHOD__ . " > " . $ct_data . PHP_EOL;
            fwrite($conn, "Received $ct_size byte data./r/n");
            fclose($conn);
        }

        fclose($socket);
    }
}

new SocketServer(2000);
