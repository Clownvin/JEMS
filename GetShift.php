<?php
	session_start();
	require ('./JemsAPI.php');
	$connection = new JEMSConnection("localhost", 6667);
 	echo $connection->query("GET_SHIFT ".$_REQUEST['year']." ".$_REQUEST['month']." ".$_REQUEST['day']." ".$_SESSION['auth']."\n");
 ?>
