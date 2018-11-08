<?php

	namespace WDOAPI\Operations;

	Class Operations {

		public $openOperations = [];
		public $historicalOperations = [];
		public $resumeOfOperations = [];

		public function __construct(){

		}

		// Verifico se tem operacoes abertas
		public function existOpenPerations(){

			if( count($this->openOperations) > 0 ){
				return true;
			} else {
				return false;
			}

		}

		public function openOperation( $stopGain, $stopLoss ){



		}

		public function closeOperation(){

			

		}

		// Checo o status e se fecho ou abro operacoes
		public function checkOpenOperarions(){



		}

		public function groupDataByDate( $data ){

			$arrResponse = [];

			foreach( $data as $intraDay ){

				$arrDate = explode( ' ', $intraDay['date'] );
				$date = $arrDate[0];
				$arrResponse[$date][] = $intraDay;

			}

			return $arrResponse;

		}

	}

?>