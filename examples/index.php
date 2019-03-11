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

?>