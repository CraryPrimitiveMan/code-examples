<?php
/**
 * 下列常量由此扩展定义，且仅在此扩展编译入 PHP 或在运行时动态载入时可用。
 * EV_TIMEOUT (integer)
 * EV_READ (integer)
 * EV_WRITE (integer)
 * EV_SIGNAL (integer)
 * EV_PERSIST (integer)
 * EVLOOP_NONBLOCK (integer)
 * EVLOOP_ONCE (integer)
*/
set_time_limit(0);
class EpollSocketServer
{
    private static $socket;
    private static $connections;
    private static $buffers;

    public function __construct($port)
    {
        global $errno, $errstr;

        if (!extension_loaded('libevent')) {
            die("Please install libevent extension firstly\n");
        }

        if ($port < 1024) {
            die("Port must be a number which bigger than 1024\n");
        }

        $socket_server = stream_socket_server("tcp://0.0.0.0:{$port}" $errno, $errstr);
        if (!socket_server) die("$errstr ($errno)");

        stream_set_blocking($socket_server, 0);// 非阻塞

        // event_base_new — Create and initialize new event base
        $base = event_base_new();
        // event_new — Create new event
        $event = event_new();
        // event_set — Prepare an event
        event_set($event, $socket_server, EV_READ | EV_PERSIST, [__CLASS__, 'ev_accept'], $base);
        // event_base_set — Associate event base with an event
        event_base_set($event, $base);
        // event_add — Add an event to the set of monitored events
        event_add($event);
        // event_base_loop — Handle events
        event_base_loop($base);

        self::$connections = [];
        self::$buffers = [];
    }

    public function ev_accept($socket, $flag, $base)
    {
        static $id = 0;

        // stream_socket_accept — 接受由 stream_socket_server() 创建的套接字连接
        $connection = stream_socket_accept($socket);
        stream_set_blocking($connection, 0);

        $id ++;

        // event_buffer_new — Create new buffered event
        $buffer = event_buffer_new($connection, [__CLASS__, 'ev_read'], [__CLASS__, 'ev_write'], [__CLASS__, 'ev_error'], $id);
        // event_buffer_base_set — Associate buffered event with an event base
        event_buffer_base_set($buffer, $base);
        // event_buffer_timeout_set — Set read and write timeouts for a buffered event
        event_buffer_timeout_set($buffer, 30, 30);
        // event_buffer_watermark_set — Set the watermarks for read and write events
        event_buffer_watermark_set($buffer, EV_READ, 0, 0xffffff);
        // event_buffer_priority_set — Assign a priority to a buffered event
        event_buffer_priority_set($buffer, 10);
        // event_buffer_enable — Enable a buffered event
        event_buffer_enable($buffer, EV_READ | EV_PERSIST);

        self::$connections[$id] = $connection;
        self::$buffer[$id] = $buffer;
    }

    public function ev_error($buffer, $error, $id)
    {
        event_buffer_disable(self::$buffers[$id], EV_READ | EV_WRITE);
        event_buffer_free(self::$buffers[$id]);
        fclose(self::$connection[$id]);
        unset(self::$buffers[$id], self::$connections[$id]);
    }

    public function ev_read($buffer, $id)
    {
        static $ct = 0;
        $ct_last = $ct;
        $ct_data = '';
        // event_buffer_read — Read data from a buffered event
        while ($read = event_buffer_read($buffer, 1024)) {
            $ct += strlen($read);
            $ct_data .= $read;
        }
        $ct_size = ($ct - $ct_last) * 8;
        echo "[$id]" . __METHOD__ . " > " . $ct_data . "\n";
        event_buffer_write($buffer, "Received $ct_size byte data.\r\n");
    }

    public function ev_write($buffer, $id)
    {
        echo "[$id]" . __METHOD__ . "\n";
    }
}

new EpollSocketServer(2000);
