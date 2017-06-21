<?php
	session_start();
	require ('./MySQLConnection.php');
	if (isset($_SESSION['auth'])) {
		$db = createDatabaseConnection('127.0.0.1', 'employeedb', 'root', '');
		$query = 'SELECT time FROM punch_card WHERE username=\''.$_SESSION['auth'].'\'';
		$ret = $db->query($query)->fetchAll();
		if (count($ret) % 2 == 0) {
			echo "false";
		} else {
			echo "true";
		}
	} else {
		echo "false";
	}
 ?>
