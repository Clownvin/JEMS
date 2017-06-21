<?php
	require ('./JemsAPI.php');
	require ('./MySQLConnection.php');

	function scheduleEmployees() {
 		$mySQL = createDatabaseConnection("localhost", "employeedb", "root", "");
 		$ret = $mySQL->query('SELECT username FROM employee_info')->fetchAll();
 		$connection = new JEMSConnection("localhost", 6667);
 		$employees = "";
 		$first = true;
 		foreach ($ret as $employee) {
	 		if (!$first) {
		 		$employees .= ",";
	 		}
	 		$first = false;
	 		$employees .= $employee['username'];
 		}
 		$connection->query("SCHEDULE ".$employees."\n");
 	}
 ?>
