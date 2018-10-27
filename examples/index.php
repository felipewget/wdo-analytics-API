<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	include('../src/WDOAPI/autoload.php');

	$WDOAPI = new WDOAPI\WDOAPI( true );

	// Exemple
	$WDOAPI->updateData( '36' );

?>