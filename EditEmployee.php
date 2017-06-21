<?php
	session_start();
	require("./MySQLConnection.php");

	if (isset($_REQUEST['username']) && isset($_REQUEST['address']) && isset($_REQUEST['phone']) && isset($_REQUEST['email'])
	 && isset($_REQUEST['city']) && isset($_REQUEST['state']) && isset($_REQUEST['zip']) && isset($_REQUEST['type'])) {
		 $db = createDatabaseConnection('127.0.0.1', 'employeedb', 'root', '');
		 $query = "UPDATE employee_info SET address='".$_REQUEST['address']."', phone='".$_REQUEST['phone']."', email='".$_REQUEST['email']."', city='".$_REQUEST['city']."', state='".$_REQUEST['state']."', zip='".$_REQUEST['zip']."', type='"
		 .$_REQUEST['type']."' WHERE username='".$_REQUEST['username']."';";
		 echo "doing stuff";
		 var_dump($query);
		 $ret = $db->query($query);
		 var_dump($ret);
	 }
?>
