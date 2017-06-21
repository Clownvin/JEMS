<?php
	session_start();
	require("./MySQLConnection.php");

	if (isset($_REQUEST['username']) && isset($_REQUEST['password']) && isset($_REQUEST['firstName']) && isset($_REQUEST['middleName']) && isset($_REQUEST['lastName']) && isset($_REQUEST['address']) && isset($_REQUEST['phone']) && isset($_REQUEST['email'])
	 && isset($_REQUEST['dob']) && isset($_REQUEST['sex']) && isset($_REQUEST['city']) && isset($_REQUEST['state']) && isset($_REQUEST['zip']) && isset($_REQUEST['type'])) {
		 $db = createDatabaseConnection('127.0.0.1', 'employeedb', 'root', '');
		 $query = "INSERT INTO employee_info (username, password, first_name, middle_name, last_name, address, phone, email, dob, sex, city, state, zip, type) VALUES ('".$_REQUEST['username']."','".$_REQUEST['password']."','".$_REQUEST['firstName']."','".$_REQUEST['middleName']."','".$_REQUEST['lastName']."','".$_REQUEST['address']."','".$_REQUEST['phone']."','".$_REQUEST['email']."','".$_REQUEST['dob']."','".$_REQUEST['sex']."','".$_REQUEST['city']."','".$_REQUEST['state']."','".$_REQUEST['zip']."','".$_REQUEST['type']."');";
		 var_dump($query);
		 var_dump($db->query($query));
	 } else {
		 echo "ISSSUEEEEEE";
	 }
?>
