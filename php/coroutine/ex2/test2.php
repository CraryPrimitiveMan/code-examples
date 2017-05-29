<?php
/**
 * Created by PhpStorm.
 * User: jun
 * Date: 2017/4/12
 * Time: 19:18
 */
require "AsyncTask.php";
require "Async.php";

class AsyncSleep implements Async
{
    public function begin($cc)
    {
        echo 'test1', "\n";
        swoole_timer_after(1000, $cc);
        echo 'test2', "\n";
//        swoole_async_dns_lookup("www.google.com", function($host, $ip) use($cc) {
//            $cc($host . ':' .$ip);
//        });
    }
}

class AsyncDns implements Async
{
    public function begin($cc)
    {
        echo 'test3', "\n";
        swoole_async_dns_lookup("www.baidu.com", function($host, $ip) use($cc) {
            $cc($host . ':' .$ip);
        });
    }
}

function newSubGen() {
    yield 10;
    yield 11;
    yield 12;
    yield 13;
    
}

function newGen() {
    $r1 = (yield 1);
    $r2 = (yield newSubGen());
    $r3 = (yield 3);
    $start = time();
    yield new AsyncSleep();
    echo time() - $start, "\n";
    $ip = (yield new AsyncDns());
    yield "IP: $ip";
}

$task = new AsyncTask(newGen());
$trace = function($r) { echo $r; };
$task->begin($trace);