<?php

$redis = new Redis();
$redis->connect('127.0.0.1',6379);
$channel = $argv[1];  // channel
$msg = $argv[2]; // msg
$redis->publish('channel'.$channel, $msg);
