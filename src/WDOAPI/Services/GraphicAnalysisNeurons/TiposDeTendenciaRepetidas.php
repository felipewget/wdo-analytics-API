<?php
	
	namespace WDOAPI\Services\GraphicAnalysisNeurons;

	use \WDOAPI\Bootstrap\BaseGraphic;
	use \Exception;

	/**
	 *	Verifica o tipo de tendencia repetida em dias consecutivos
	 *	@package 	WDOAPI\Services\GraphicAnalysisNeurons
	 *	@author 	Fe Oliveira<felipe.wget@gmail.com>
	 *	@version 	1.0.0
	 *	@copyright 	Felipe Rodrigues Oliveira | 2019
	 */
	
	Class TiposDeTendenciaRepetidas extends BaseGraphic {

		public $nDayDendenciasRepetidas;

		/**
		 *	Processa os candles e verifica possiveis operacoes 
		 *	@param array $sgdbArrCandles 	Candles da listagem do banco de dados
		 *	@param float $osc 				Oscilacao minima em relacao a abertura para entrar numa operacao
		 */
		public function check( $sgdbArrCandles, $nDayDendenciasRepetidas, $startHour, $endHour )
		{

			$this->nDayDendenciasRepetidas = $nDayDendenciasRepetidas;
			$arrCandles = $this->groupCandlesByDay( $sgdbArrCandles, $startHour, $endHour );
			$dataOperations = $this->getOperations( $arrCandles );
			return $dataOperations;

		}


		/**
		 *	Retorna os candles que ira entrar em operacao
		 *
		 */
		private function getOperations( $arrCandles )
		{

			$arrOperations = [];
			$arrDays = [];

			$nDayDendenciasRepetidas = $this->nDayDendenciasRepetidas;
			$locked = false;

			try {

				$countDayInTendence = 0;
				$lastTendence = false;

				// Percorre os dias
				foreach( $arrCandles as $day => $candles ){

					$aberturaPeriodo = null;
					$fechamentoPeriodo = null;

					// Percorre os candles de um dia
					foreach( $candles as $index => $candle ){

						if( $aberturaPeriodo == null ){
							$aberturaPeriodo = $candle;
						}

						$fechamentoPeriodo = $candle;

					}

					$type = $this->getRatesDifference( $aberturaPeriodo->open, $fechamentoPeriodo->close );

					if( $lastTendence != $type['type'] ){
						
						$countDayInTendence = 1;
						$lastTendence = $type['type'];

					} else {
						$countDayInTendence++;
					}

					if( $countDayInTendence == $nDayDendenciasRepetidas ) {

						$date = explode( ' ', $fechamentoPeriodo->date )[0];
						$arrOperations[] = $date;
						$arrDays[] = $day;

					}

				}

				return [
					'operations_count'				=> count( $arrOperations ),
					'operations'					=> $arrOperations,
					'days'							=> array_unique( $arrDays )
				];

			} catch( Exception $e ) {

				throw new Exception( $e->getMessage() );

			}

		}

		////////

		/**
		 * Carrega um leke de possibilidades
		 * aki
		 */
		public function loadPossibilities( $loadPossibilities = false, $minTendencia = 0, $maxTendencia = 15 )
		{

			$arrPossibilites = [];
			$arrTendencias	 = [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25 ];

			$arrPossibilites[] = [
				'active'	=> false,
				'n_days'	=> 0,
			];

			if( $loadPossibilities ){

				foreach( $arrTendencias as $nTendencia ){

					if( $minTendencia <= $nTendencia && 
						$maxTendencia >= $nTendencia ){

						$arrPossibilites[] = [
							'active'	=> true,
							'n_days' 	=> $nTendencia,
						];

					}

				}

			}

			return $arrPossibilites;

		}
		
	}

?>