<?php
	session_start();
	require ('./JemsAPI.php');
	if (isset($_SESSION['auth']) && isset($_REQUEST['jems_request'])) {
		$response = new JEMSConnection("localhost", 6667)->query($_REQUEST);
		if ($response !== false) {
			echo $response;
		}
	}
?>
