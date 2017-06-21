<?php
	session_start();

	require ('./MySQLConnection.php');

	if (isset($_SESSION['auth'])) {
		$db = createDatabaseConnection('127.0.0.1', 'employeedb', 'root', '');
		$query = 'INSERT INTO punch_card (username) VALUES (\''.$_SESSION['auth'].'\')';
		var_dump($query);
		var_dump($db->query($query));
	}
	echo "";
?>
