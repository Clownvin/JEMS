<?php
	session_start();

	require("./MySQLConnection.php");

	if (isset($_REQUEST['employee'])) {
		$db = createDatabaseConnection('127.0.0.1', 'employeedb', 'root', '');
		$query = "SELECT address, phone, email, city, state, zip, type FROM employee_info WHERE username='".$_REQUEST['employee']."'";
		$ret = $db->query($query);
		if ($ret == false) {
			echo "Employee does not exist.";
		} else {
			echo json_encode($ret->fetchAll());
		}
	}
 ?>
