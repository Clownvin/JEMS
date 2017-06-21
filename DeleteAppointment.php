<?php
	session_start();

	require ("./MySQLConnection.php");

	if (isset($_REQUEST['id']) && isset($_SESSION['auth'])) {
		$db = createDatabaseConnection('127.0.0.1', 'employeedb', 'root', '');
		$query = 'DELETE FROM employee_appointments WHERE id=\''.$_REQUEST['id'].'\' AND username=\''.$_SESSION['auth'].'\'';
		var_dump($db->query($query));
	}
 ?>
