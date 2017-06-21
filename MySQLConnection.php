<?php
	function createDatabaseConnection($host, $databaseName, $username, $password) {
		return new PDO("mysql:host=".$host.";dbname=".$databaseName, $username, $password);
	}
?>
