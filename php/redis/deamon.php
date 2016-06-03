<?php
/*
Homepage: http://netkiller.github.io
Author: neo chan <netkiller@msn.com>
*/

class Example {
	/* config */
	const HOST = '192.168.2.1';
	const PORT = 6379;
	const MAXCONN = 2048;

	const pidfile = __CLASS__;
	const uid	= 80;
	const gid	= 80;

	protected $pool = NULL;
	protected $redis = NULL;

	public function __construct() {
		$this->pidfile = '/var/run/'.self::pidfile.'.pid';
		$this->redis = new Redis();
	}
	private function daemon(){
		if (file_exists($this->pidfile)) {
			echo "The file $this->pidfile exists.\n";
			exit();
		}

		$pid = pcntl_fork();
		if ($pid == -1) {
			 die('could not fork');
		} else if ($pid) {
			 // we are the parent
			 //pcntl_wait($status); //Protect against Zombie children
			exit($pid);
		} else {
			// we are the child
			file_put_contents($this->pidfile, getmypid());
			posix_setuid(self::uid);
			posix_setgid(self::gid);
			return(getmypid());
		}
	}
	private function run(){
		$this->pool = new Pool(self::MAXCONN, \ExampleWorker::class, []);

		$this->redis->connect(self::HOST, self::PORT);
		$channel = array('news', 'login', 'logout');
		$this->redis->subscribe($channel, 'callback');
		function callback($instance, $channelName, $message) {
  			echo $channelName, "==>", $message,PHP_EOL;
			//print_r($message);
			$this->pool->submit(new Fee($message));
		}

		$pool->shutdown();
	}
	private function start(){
		$pid = $this->daemon();
		$this->run();
	}
	private function onestart(){
		$this->run();
	}

	private function stop(){

		if (file_exists($this->pidfile)) {
			$pid = file_get_contents($this->pidfile);
			posix_kill($pid, 9);
			unlink($this->pidfile);
		}
	}
	private function help($proc){
		printf("%s start | stop | onestart | help \n", $proc);
	}
	public function main($argv){
		if(count($argv) < 2){
			printf("please input help parameter\n");
			exit();
		}
		if($argv[1] === 'stop'){
			$this->stop();
		} else if($argv[1] === 'start'){
			$this->start();
		} else if ($argv[1] === 'onestart') {
			$this->onestart();
		} else{
			$this->help($argv[0]);
		}
	}
}

$example = new Example();
$example->main($argv);
