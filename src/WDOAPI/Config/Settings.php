<?php

	namespace WDOAPI\Config;


	/**
	 *	Contem dados de acesso ao SGBD MySQL
	 *	@package 	WDOAPI\Config
	 *	@author 	Fe Oliveira<felipe.wget@gmail.com>
	 *	@version 	1.0.0
	 *	@copyright 	Felipe Rodrigues Oliveira | 2019
	 */
	Class Settings {


		/**
		 *	@var string $mysqlUsername	Usuario de acesso ao mysql
		 *	@var string $mysqlPassword	Password do usuario de acesso ao mysql
		 *	@var string $mysqlHostname	Host do banco mysql
		 *	@var string $mysqlDb		Nome do banco de dados
		 */

		public $mysqlUsername 	= "user";
		public $mysqlPassword 	= "password";
		public $mysqlHostname 	= "localhost";
		public $mysqlDb 		= "historical_data";

	}

?>