<?php
	session_start();
	require ('./JemsAPI.php');
	$connection = new JEMSConnection("localhost", 6667);
	//Check and see if a different variable has a value, and if it does, use it instead (for manager viewing employees)
	// Like a global variable
	echo $connection->query("GET ".$_SESSION['auth']."\n");
 ?>
