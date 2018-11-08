<?php
	
	include('WDOAPI.php');

	include('DataInterface/IntraDayInterface.php');
	include('DataInterface/HistoricalDataInterface.php');

	include('SGBD/Settings.php');
	include('SGBD/MySQL.php');
	include('SGBD/HistoricalDataDAO.php');
	include('SGBD/IntraDayDAO.php');

	include('CURL/CURL.php');
	include('CURL/Advfn.php');

	include('Files/Files.php');
	include('Files/HistoricalData.php');
	include('Files/IntraDay.php');

	include('Operations/Operations.php');
	include('Operations/BackTest.php');
	include('Operations/PullBack.php');

	

?>