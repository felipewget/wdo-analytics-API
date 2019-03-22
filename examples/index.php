<?php

	/**
	 * Index, basicamente mostra como instanciar a API
	 *
	 *	@var \WDOAPI\WDOAPI		$wdo 				Carrega a classe da API
	 *
	 *	File: index.php
	 */

	// Carrega autoload
	include('../src/WDOAPI/autoload.php');

	// Carrega API
	$wdo = new \WDOAPI\WDOAPI();

	// /**
	//  *	@TODO criar um arquivo
	//  */
	// $file = 'samples/WDOJ19M5.csv';
	// echo $wdo->updateIntraDayData( $file , $truncate = false );
	// echo '--';


?>