<?php

	namespace WDOAPI\Services\GraphicAnalysisNeurons;

	use \WDOAPI\Bootstrap\BaseGraphic;
	use \Exception;

	/**
	 *	Melhores % em relacao a abertura para entrar em uma operacao
	 *	@package 	WDOAPI\Services\GraphicAnalysisNeurons
	 *	@author 	Fe Oliveira<felipe.wget@gmail.com>
	 *	@version 	1.0.0
	 *	@copyright 	Felipe Rodrigues Oliveira | 2019
	 */
	Class NivelOsc extends BaseGraphic {

		public $osc;
		

		/**
		 *	Processa os candles e verifica possiveis operacoes 
		 *	@param array $sgdbArrCandles 	Candles da listagem do banco de dados
		 *	@param float $osc 				Oscilacao minima em relacao a abertura para entrar numa operacao
		 */
		public function check( $sgdbArrCandles, $osc, $startHour, $endHour )
		{

			$this->setOsc( $osc );
			$arrCandles = $this->groupCandlesByDay( $sgdbArrCandles, $startHour, $endHour );
			$dataOperations = $this->getOperations( $arrCandles );
			return $dataOperations;

		}


		/**
		 *	Check osc por candle unico
		 * 	@todo Nao esquecer de usar OSC
		 */
		public function checkCandle( $candle )
		{
			
			$osc = $this->osc;

			$response = false;

			if( $candle->var_opened_day >= $osc ){
				$response = true;
			}

			return $response;

		}


		/**
		 *	Check osc por candle unico
		 */
		public function setOsc( $osc )
		{

			$this->osc = $osc;

		}


		/**
		 *	Retorna os candles que ira entrar em operacao
		 *
		 */
		private function getOperations( $arrCandles )
		{

			$osc = $this->osc;
			$lockCandles = false;
			$arrDays = [];

			try {

				$arrOperations = [];

				// Percorre os dias
				foreach( $arrCandles as $day => $candles ){

					$operacaoInDay = 0;

					// Percorre os candles de um dia
					foreach( $candles as $index => $candle ){

						if( $this->checkCandle( $candle ) ){
							
							if( !$lockCandles ){

								$lockCandles = true;
								$operacaoInDay = 1;
								$arrOperations[] = $candle;
								$arrDays[] = $day;

							}

						} else {

							$lockCandles = false;

						}

					}

				}

				return [
					'operations_count'	=> count( $arrOperations ),
					'operations'		=> $arrOperations,
					'days'				=> array_unique( $arrDays )
				];

			} catch( Exception $e ) {

				throw new Exception( $e->getMessage() );

			}

		}


		/**
		 * Carrega um leke de possibilidades
		 * aki
		 */
		public function loadPossibilities( $loadPossibilities = false, $minOsc = -0.1, $maxOsc = 1.60 )
		{

			$arrPossibilites = [];
			$arrOsc 	= [ 0.01, 0.02, 0.03, 0.04, 0.05, 0.06, 0.07, 0.08, 0.09, 0.10, 0.15, 0.20, 0.25, 0.50, 0.55, 0.60, 0.65, 0.70, 0.75, 0.80, 0.85, 0.90, 0.95, 1.00, 1.05, 1.10, 1.15, 1.20, 1.30, 1.40, 1.45, 1.50 ];

			$arrPossibilites[] = [
				'active'	=> false,
				'osc'		=> '0.00',
			];

			if( $loadPossibilities ){

				foreach( $arrOsc as $osc ){

					if( $osc >= $minOsc && $osc <= $maxOsc ){

						$arrPossibilites[] = [
							'active'	=> true,
							'osc'		=> $osc,
						];

					}

				}

			}

			return $arrPossibilites;

		}

	}

?>