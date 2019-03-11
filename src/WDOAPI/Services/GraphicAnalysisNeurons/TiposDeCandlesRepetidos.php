<?php

	namespace WDOAPI\Services\GraphicAnalysisNeurons;

	use \WDOAPI\Bootstrap\BaseGraphic;
	use \Exception;

	/**
	 *	Apos um numero X repetidos de candles do mesmo tipo
	 *	@package 	WDOAPI\Services\GraphicAnalysisNeurons
	 *	@author 	Fe Oliveira<felipe.wget@gmail.com>
	 *	@version 	1.0.0
	 *	@copyright 	Felipe Rodrigues Oliveira | 2019
	 */
	Class TiposDeCandlesRepetidos extends BaseGraphic {

		public $nCandlesRepetidos;

		// Arr auxiliar, armazena os candles anteriores
		public $arrCountCandles;
		

		/**
		 *	Processa os candles e verifica possiveis operacoes 
		 *	@param array $sgdbArrCandles 	Candles da listagem do banco de dados
		 *	@param float $osc 				Oscilacao minima em relacao a abertura para entrar numa operacao
		 */
		public function check( $sgdbArrCandles, $nCandlesRepetidos, $startHour, $endHour )
		{

			$this->setNCandlesRepetidos( $nCandlesRepetidos );
			$arrCandles = $this->groupCandlesByDay( $sgdbArrCandles, $startHour, $endHour );
			$dataOperations = $this->getOperations( $arrCandles );
			return $dataOperations;

		}

		public function resetArrCountCandles()
		{
			$this->arrCountCandles = [];
		}

		/**
		 *	Check osc por candle unico
		 * 	@todo Nao esquecer de usar OSC
		 */
		public function checkCandle( $candle )
		{
			
			// Adiciono ao array o candle atual e o numero necessario de candles antigos
			$nCandlesRepetidos = $this->nCandlesRepetidos;
			
			// Percorre os indices do array
			$iFor = $nCandlesRepetidos;
			for( $i = 1; $i <= $nCandlesRepetidos; $i++ ){
				
				if( $i > 0 ){

					if( isset( $this->arrCountCandles[ $i ] ) && is_object( $this->arrCountCandles[ $i ] ) ){

						if( $i > 1 ){
							$previousIndex = $i - 1;
							$this->arrCountCandles[ $previousIndex ] = $this->arrCountCandles[ $i ];
						}

					}

				}

			}

			$this->arrCountCandles[ $nCandlesRepetidos ] = $candle;

			// Percorre os candles e ve se o tipo deles sao todos high ou low
			$typeCandlesEquals = ( $nCandlesRepetidos == count( $this->arrCountCandles ) ) ? true : false;
			$auxType = null;

			if( $typeCandlesEquals && $nCandlesRepetidos == count( $this->arrCountCandles ) ){

				foreach( $this->arrCountCandles as $candle ){

					if( is_object( $candle ) && isset($candle->type) && $candle->type !== null && $candle->type !== 'null'  ){

						if( $auxType == null ){
							$auxType = $candle->type;
						}

						if( $auxType != $candle->type ){
							$typeCandlesEquals = false;
						}

					}

				}

			}

			return $typeCandlesEquals;

		}


		/**
		 *	Check osc por candle unico
		 */
		public function setNCandlesRepetidos( $nCandlesRepetidos )
		{

			$this->nCandlesRepetidos = $nCandlesRepetidos;

		}


		/**
		 *	Retorna os candles que ira entrar em operacao
		 *
		 */
		private function getOperations( $arrCandles )
		{

			$arrDays = [];
			$nCandlesRepetidos = $this->nCandlesRepetidos;
			$lockedTypeCandlesRepetidos = false;

			try {

				$arrOperations = [];

				// Percorre os dias
				foreach( $arrCandles as $day => $candles ){

					$operacaoInDay = 0;
					$this->resetArrCountCandles();

					// Percorre os candles de um dia
					foreach( $candles as $index => $candle ){

						// Apos ter acha um numero X de candles, ele bloqueia ate
						// ter um candle com type oposto, para dai comecar a recontar
						// Exemplo: 3 candles... low,low,low... bloqueia ate um candle high
						if( $lockedTypeCandlesRepetidos != $candle->type ){
							$lockedTypeCandlesRepetidos = false;
						}

						if( $operacaoInDay == 0 && !$lockedTypeCandlesRepetidos ){

							if( $this->checkCandle( $candle ) ){
								$arrOperations[] = $this->arrCountCandles[ $nCandlesRepetidos ];
								$arrDays[] = $day;
								$lockedTypeCandlesRepetidos = $candle->type;
							}

						}

					}

				}

				return [
					'operations_count'				=> count( $arrOperations ),
					'operations'					=> $arrOperations,
					'days'							=> array_unique( $arrDays ),
					'metadata_operations'			=> $arrOperations,
				];

			} catch( Exception $e ) {

				throw new Exception( $e->getMessage() );

			}

		}


		/**
		 * Carrega um leke de possibilidades
		 * aki
		 */
		public function loadPossibilities( $loadPossibilities = false, $minCandle = 0, $maxCandle = 15 )
		{

			$arrPossibilites = [];
			$arrCandles		 = [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25 ];

			$arrPossibilites[] = [
				'active'	=> false,
				'n_candles'	=> 0,
			];

			if( $loadPossibilities ){

				foreach( $arrCandles as $nCandle ){

					if( $minCandle <= $nCandle && 
						$maxCandle >= $nCandle ){

						$arrPossibilites[] = [
							'active'	=> true,
							'n_candles' => $nCandle,
						];

					}

				}

			}

			return $arrPossibilites;

		}

		
	}

?>