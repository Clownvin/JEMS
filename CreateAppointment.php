<?php
session_start();

require ("./MySQLConnection.php");

if (isset($_REQUEST['year']) && isset($_REQUEST['month']) && isset($_REQUEST['day']) && isset($_REQUEST['time']) && isset($_REQUEST['details']) && isset($_SESSION['auth'])) {
	$db = createDatabaseConnection('127.0.0.1', 'employeedb', 'root', '');
	$query =
	'INSERT INTO employee_appointments (username, year, month, day, time, details)
	 VALUES (\''.$_SESSION['auth'].'\',\''.$_REQUEST['year'].'\',\''.$_REQUEST['month'].'\',\''.$_REQUEST['day'].'\',\''.$_REQUEST['time'].'\',\''.$_REQUEST['details'].'\')';
	var_dump($query);
	$db->query($query);
}
?>
