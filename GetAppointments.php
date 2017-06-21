<?php
	session_start();
	require ("./MySQLConnection.php");

	function formatAppointment($appt) {
		return "<p>".$appt."</p>";
	}

	if (isset($_REQUEST['year']) && isset($_REQUEST['month']) && isset($_REQUEST['day']) && isset($_SESSION['auth'])) {
		$db = createDatabaseConnection('127.0.0.1', 'employeedb', 'root', '');
		$query = 'SELECT details, time, id FROM employee_appointments WHERE username=\''.$_SESSION['auth'].'\' AND year=\''.$_REQUEST['year'].'\' AND month=\''.$_REQUEST['month'].'\' AND day=\''.$_REQUEST['day'].'\'';
		$ret = $db->query($query)->fetchAll();
		$return = "";
		for ($i = 0; $i < count($ret); $i++) {
			$return .= formatAppointment("At ".$ret[$i]['time']."<br>".$ret[$i]['details']."<br><input type='button' value='Delete Appointment' onclick=\"deleteAppointment('".$ret[$i]['id']."');\" />");
		}
		echo $return;
	}
	echo "";

 ?>
