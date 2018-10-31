<?php

	namespace WDOAPI\Files;

	Class Files {

		public function __construct(){
			
		}

		public function readFileCSV( $dirFile, $separator = "," ){

			$file_lines = file( $dirFile );
			
			$lineData = [];

			foreach ($file_lines as $line) {

				$arrLine = explode( $separator , $line );
				$lineData[] = $arrLine;

			}

			return $lineData;

		}

	}

?>