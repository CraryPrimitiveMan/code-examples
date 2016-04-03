<?php
//Establish Connection
$connection = new AMQPConnection();
$connection->setHost('127.0.0.1');
$connection->setLogin('guest');
$connection->setPassword('guest');
$connection->connect();
//Listen on Channel
$channel = new AMQPChannel($connection);

$binding_keys = array_slice($argv,1);
if(empty($binding_keys)) {
	file_put_contents('php://stderr', "Usage: {$argv[0]} [binding_key]...\n");
	exit(1);
}
echo " [*] Waiting for logs. To exit press CTRL+C", PHP_EOL;
$callback_func = function(AMQPEnvelope $message, AMQPQueue $q) {
	echo sprintf(" [X] [%s] %s",$message->getRoutingKey(),$message->getBody()), PHP_EOL;
	$q->nack($message->getDeliveryTag());
	return true;
};
try {
	//Declare Exchange
	$exchange_name = 'topic_logs';
	$exchange = new AMQPExchange($channel);
	$exchange->setType(AMQP_EX_TYPE_TOPIC);
	$exchange->setName($exchange_name);
	$exchange->declareExchange();
	//Declare Queue
	$queue = new AMQPQueue($channel);
	$queue->setFlags(AMQP_EXCLUSIVE);
	$queue->declareQueue();
	foreach($binding_keys as $binding_key) {
		$queue->bind($exchange_name, $binding_key);
	}
	$queue->consume($callback_func);
} catch(AMQPQueueException $ex) {
	print_r($ex);
} catch(Exception $ex) {
	print_r($ex);
}
