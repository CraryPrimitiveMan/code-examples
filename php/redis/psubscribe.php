<?php
$redis = new Redis();
$redis->connect('127.0.0.1',6379);
$redis->psubscribe(array('channel*'), 'callback');
function callback($instance, $channelName, $message) {
  echo $channelName, "==>", $message,PHP_EOL;
}
