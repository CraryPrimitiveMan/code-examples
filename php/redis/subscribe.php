<?php
$redis = new Redis();
$redis->connect('127.0.0.1',6379);
$channel = $argv[1];  // channel
$redis->subscribe(array('channel'.$channel), 'callback');
function callback($instance, $channelName, $message) {
  echo $channelName, "==>", $message,PHP_EOL;
}
