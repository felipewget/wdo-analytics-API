<?php 

	namespace WDOAPI\Services\GraphicAnalysisNeurons;

	use \WDOAPI\Bootstrap\BaseGraphic;
	use \Exception;

	/**
	 *	@todo Abertura de um GAP, presumindo que quando ano tem gap, o mercado vai ficar lateralizado
	 */
	
	/**
	 *	Melhores % de GAP de abertura para entrar em uma operacao
	 *	@package 	WDOAPI\Services\GraphicAnalysisNeurons
	 *	@author 	Fe Oliveira<felipe.wget@gmail.com>
	 *	@version 	1.0.0
	 *	@copyright 	Felipe Rodrigues Oliveira | 2019
	 */
	Class GapAberturaOsc extends BaseGraphic {

		const HORARIO_ABERTURA 	 = '08:00:00'; // Abre as 09 mas deixei 08:00, de qualquer forma ira pegar a primeiro candle
		const HORARIO_FECHAMENTO = '19:30:00'; // Fecha as 18 mas deixei 19:30, de qualquer forma ira pegar a ultimo candle

		public $osc;
		public $type;

		public function check( $sgdbArrCandles, $osc, $type )
		{

			$this->setOsc( $osc );
			$this->setType( $type );
			$arrCandles = $this->groupCandlesByDay( $sgdbArrCandles, GapAberturaOsc::HORARIO_ABERTURA, GapAberturaOsc::HORARIO_FECHAMENTO );
			$dataOperations = $this->getOperations( $arrCandles );
			return $dataOperations;

		}

		private function getOperations( $arrCandles )
		{			

			$osc 	= $this->osc;
			$type 	= $this->type;

			$lockCandles = false;
			$arrDays = [];

			try {

				$aberturaPeriodo 		= null;
				$fechamentoPeriodoOntem	= null;

				// Percorre os dias
				foreach( $arrCandles as $day => $candles ){

					// Pega o primeiro candle do dia, o candle de abertura
					list( $aberturaPeriodo ) = $candles;

					if( $fechamentoPeriodoOntem !== null ){

						switch ( $type ) {
							case 'min': // Se for no minimo uma osc, true

								$dialyGapOsc = $this->getOscBetweenTwoTaxes( $aberturaPeriodo->open, $fechamentoPeriodoOntem->close );
							 	
								if( $dialyGapOsc >= $osc ){

									$arrDays[] = $day;

								}

								break;

							case 'max': // Se for no maximo uma osc, true
								
								$dialyGapOsc = $this->getOscBetweenTwoTaxes( $aberturaPeriodo->open, $fechamentoPeriodoOntem->close );
							 	
								if( $dialyGapOsc <= $osc ){

									$arrDays[] = $day;

								}

								break;
							
							default:

								throw new Exception( "Tipo de verificao sobre osc de GAP de abertura invalido" );

								break;
						}

					}

					// Ao final do loop, pega o ultimo candle do dia para verificar o chegamento de ontem
					// com o gap de abertura de hoje
					list( $fechamentoPeriodoOntem ) = array_reverse( $candles );


				}

				// die('aspodkasod');

				return [
					'operations_count'	=> count( $arrDays ),
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
			$arrOsc 	= [ 0.05, 0.10, 0.15, 0.20, 0.25, 0.30, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1, 1.1 ];
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

		/**
		 *	Check osc por gap de abertura
		 */
		public function setOsc( $osc )
		{

			$this->osc = $osc;

		}

		/**
		 *	Check type
		 */
		public function setType( $type )
		{

			$this->type = $type;

		}

	}

?>