<?php
set_time_limit(0);

class SelectSocketServer
{
    private static $socket;

    private static $timeout;

    private static $maxconns;

    private static $connections = [];

    public function __construct($port)
    {
        global $errno, $errstr;
        if ($port < 1024) {
            die("Port must be a number which bigger than 1024\n");
        }

        // socket_create_listen — Opens a socket on port to accept connections
        $socket = socket_create_listen($port);
        if (!$socket) {
            die("Listen $port failed");
        }

        // socket_set_nonblock — Sets nonblocking mode for file descriptor fd
        socket_set_nonblock($socket);

        while (true) {
            $readfds = array_merge(self::$connections, [$socket]);
            $writefds = [];

            // socket_select — Runs the select() system call on the given arrays of sockets with a specified timeout
            if (socket_select($readfds, $writefds, $e = null, $t = self::$timeout)) {
                if (in_array($socket, $readfds)) {
                    $newconn = socket_accept($socket);
                    $i = (int) $newconn;
                    $reject = '';
                    if (count(self::$connections) > self::$maxconns) {
                        $reject = "Server full, try again later.\n";
                    }

                    self::$connections[$i] = $newconn;

                    if ($reject) {
                        socket_write($writefds[$i], $reject);
                        unset($writefds[$i]);
                        self::close($i);
                    } else {
                        echo "Client $i come.\n";
                    }

                    $key = array_search($socket, $readfds);
                    unset($readfds[$key]);
                }

                foreach ($readfds as $rfd) {
                    $i = (int) $rfd;
                    // socket_read — Reads a maximum of length bytes from a socket
                    $line = @socket_read($rfd, 2048, PHP_NORMAL_READ);
                    if ($line === false) {
                        echo "Connection closed on socket $i.\n";
                        self::close($i);
                        continue;
                    }

                    $tmp = substr($line, -1);
                    if ($tmp != "/r" && $tmp != "/n") {
                        continue;
                    }

                    $line = trim($line);
                    if ($line == "quit") {
                        echo "Client $i quit.\n";
                        self::close($i);
                        break;
                    }
                    if ($line) {
                        echo "Client $i >>" . $line . "\n";
                    }
                }

                foreach ($writefds as $wfd) {
                    $i = (int) $wfd;
                    $w = socket_write($wfd, "Welcome Client $i\n");
                }
            }
        }
    }

    public static function close($i)
    {
        socket_shutdown(self::$connections[$i]);
        socket_close(self::$connections[$i]);
        unset(self::$connections[$i]);
    }
}

new SelectSocketServer(2001);
