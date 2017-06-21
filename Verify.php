<?php
	require('./MySQLConnection.php');
	session_start();
	if (isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
		$db = createDatabaseConnection('127.0.0.1', 'employeedb', 'root', '');
		$ret = $db->query('SELECT password, type FROM employee_info WHERE username=\''.$_REQUEST['username'].'\'')->fetchAll();
		if (sizeof($ret) == 0) {
			echo 0;
		}else if ($ret[0]['password'] === $_REQUEST['password']) {
			$_SESSION['auth'] = $_REQUEST['username'];
			$_SESSION['type'] = $ret[0]['type'];
			echo 1;
		} else {
			echo 0;
		}
	}
?>
