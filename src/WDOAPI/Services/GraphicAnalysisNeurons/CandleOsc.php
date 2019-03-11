<?php

	namespace WDOAPI\Services\GraphicAnalysisNeurons;

	use \WDOAPI\Bootstrap\BaseGraphic;
	use \Exception;

	/**
	 *	Melhores % em relacao a abertura e fechamento do proprio candle
	 *	@description 	Exemplo, candle com osc de 0.2% 
	 *	@package 		WDOAPI\Services\GraphicAnalysisNeurons
	 *	@author 		Fe Oliveira<felipe.wget@gmail.com>
	 *	@version 		1.0.0
	 *	@copyright	 	Felipe Rodrigues Oliveira | 2019
	 */
	Class CandleOsc extends BaseGraphic {

		public $osc;

		// max ou min -> minimo de 2.0 osc ou max de 2.0 de osc
		public $type;
		

		/**
		 *	Processa os candles e verifica possiveis operacoes 
		 *	@param array $sgdbArrCandles 	Candles da listagem do banco de dados
		 *	@param float $osc 				Oscilacao minima em relacao a abertura para entrar numa operacao
		 */
		public function check( $sgdbArrCandles, $osc, $type, $startHour, $endHour )
		{

			try {

				$this->setType( $type );
				$this->setOsc( $osc );

				$arrCandles = $this->groupCandlesByDay( $sgdbArrCandles, $startHour, $endHour );
				$dataOperations = $this->getOperations( $arrCandles );
				return $dataOperations;

			} catch( Exception $e ){

				throw new Exception( $e->getMessage() );
				
			}

		}

		public function setType( $type )
		{

			try {

				switch ( $type ) {
					case 'max':
						$this->type = $type;
						break;

					case 'min':
						$this->type = $type;
						break;
					
					default:
						
						throw new Exception( "Tipo de osc deve ser max ou min" );

						break;
				}

			} catch( Exception $e ){

				throw new Exception( $e->getMessage() );
				
			}

		}


		/**
		 *	Check osc por candle unico
		 * 	@todo Nao esquecer de usar OSC
		 */
		public function checkCandle( $candle )
		{
			
			$osc  = $this->osc;
			$type = $this->type;
			$response = false;

			$candle->var = $candle->var < 0 ? $candle->var * -1 : $candle->var;

			if( $type == 'max' ){

				// Se o candle for no maximo ate a OSC
				if( $candle->var <= $osc ){

					$response = true;

				}

			} else if( $type == 'min' ){

				// Se o candle for no minimo de a OSC
				if( $candle->var >= $osc ){

					$response = true;

				}


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

							$operacaoInDay = 1;
							$arrOperations[] = $candle;
							$arrDays[] = $day;

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
		 */
		public function loadPossibilities( $loadPossibilities = false, $minOsc = -0.1, $maxOsc = 1.60, $arrType = [ 'max', 'min' ] )
		{

			$arrPossibilites = [];
			$arrOsc 	= [ 0.01, 0.02, 0.03, 0.04, 0.05, 0.06, 0.07, 0.08, 0.09, 0.10, 0.15, 0.20, 0.25, 0.50, 0.55, 0.60, 0.65, 0.70, 0.75, 0.80, 0.85, 0.90, 0.95, 1.00, 1.05, 1.10, 1.15, 1.20, 1.30, 1.40, 1.45, 1.50 ];
			$arrType 	= [ 'max', 'min' ];

			$arrPossibilites[] = [
				'active'	=> false,
				'type'		=> 'min',
				'osc'		=> '0.00',
			];

			if( $loadPossibilities ){

				foreach( $arrOsc as $osc ){

					if( $osc >= $minOsc && $osc <= $maxOsc ){

						foreach( $arrType as  $type ){

							$arrPossibilites[] = [
								'active'	=> true,
								'type'		=> $type,
								'osc'		=> $osc,
							];

						}

					}

				}

			}

			return $arrPossibilites;

		}

	}

?>