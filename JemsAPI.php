<?php
	class JEMSConnection {
		private $socket;

		public function __construct($ip, $port) {
			$this->socket = socket_create(AF_INET, SOCK_STREAM, getprotobyname("tcp"));
			socket_connect($this->socket, $ip, $port);
		}

		public function query($poll) {
			socket_send($this->socket, $poll, strlen($poll), 0);
			//10000 bytes should be enough for almost anything I can imagine this being used for.
			$response = socket_read($this->socket, 10000, PHP_NORMAL_READ);
			return $response;
		}
	}
 ?>
