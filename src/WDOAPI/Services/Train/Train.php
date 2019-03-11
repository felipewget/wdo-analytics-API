<?php

	namespace WDOAPI\Services\Train;

	use WDOAPI\Services\GraphicAnalysisNeurons\CandleOsc;
	use WDOAPI\Services\GraphicAnalysisNeurons\NivelOsc;
	use WDOAPI\Services\GraphicAnalysisNeurons\TiposDeCandlesRepetidos;
	use WDOAPI\Services\GraphicAnalysisNeurons\TiposDeTendenciaRepetidas;
	use WDOAPI\Services\GraphicAnalysisNeurons\GapAberturaOsc;

	use WDOAPI\Services\BackTest\BackTestOperations;

	use \Exception;

	Class Train {

		public $arrRank = [];

		public function train( $candles, $neuronsConfig, $officeHour, $registersnumberInRank=10 )
		{

			$operations = $this->listOperationsPossibilities();
			$neuronsPossibilities = $this->listAllNeuronsPossibilities( $neuronsConfig );
			$countSecurity = 0 ;

			foreach( $operations as $operation ){

				foreach( $neuronsPossibilities as $neuron ){

					$backtest = new BackTestOperations();
					$resume = $backtest->checkCenario( $candles, $neuron, $officeHour, $operation );
					
					$this->manageRank( $resume, $registersnumberInRank );

					$countSecurity++;

					if( $countSecurity > 50000000 ){ // Aumentar pelo numero de registros, que hoje e no maximo 620.000
						
						echo 'Looping infinito, resultado atual ';
						echo '<hr />';
						var_dump( $this->arrRank );

					}

				}

			}

			// Organiza do melhor resultado para o menor
			$this->organizeRank();

			return $this->arrRank;

		}

		public function listOperationsPossibilities()
		{

			$typeStop = [];

			$stops = [
				8, 10, 15, 20, 25,
				'0.3%', '0.5%', '0.6%', '0.7%', '0.8%', '0.9%', '1.0%'
			];

			foreach( $stops as $stopGain ){

				foreach( $stops as $stopLoss ){

					$typeStop[] = [
						'stop' => [
							'gain'	=> $stopGain,
							'loss'	=> $stopLoss,
						],
						'range_candle' => [
							'min'	=> 0,
							'max'	=> 100000,
						],
						'pointsInEmoluments' => '0.5'
					];

				}

			}

			return $typeStop;

		}

		// Opecoes de gain e loss sao estaticas, o que muda sao as configuracoes dos neuronios apenas
		public function trainNeurons( $candles, $neuronsConfig, $officeHour, $operations, $registersnumberInRank=10 )
		{

			$neuronsPossibilities = $this->listAllNeuronsPossibilities( $neuronsConfig );
			$countSecurity = 0 ;

			foreach( $neuronsPossibilities as $neuron ){

				$backtest = new BackTestOperations();
				$resume = $backtest->checkCenario( $candles, $neuron, $officeHour, $operations );
				
				$this->manageRank( $resume, $registersnumberInRank );

				$countSecurity++;

				if( $countSecurity > 5000000 ){ // Aumentar pelo numero de registros, que hoje e no maximo 620.000
					
					echo 'Looping infinito, resultado atual ';
					echo '<hr />';
					var_dump( $this->arrRank );

				}

			}

			// Organiza do melhor resultado para o menor
			$this->organizeRank();

			return $this->arrRank;

		}

		public function manageRank( $resume, $registersnumberInRank )
		{

			if( count( $this->arrRank ) >= $registersnumberInRank ){

				$menorValorIndice = null;
				$menorValor = null;

				// Pego o menor valor da lista de resumo
				foreach( $this->arrRank as $indice => $unRankRegister ){

					if( $menorValor === null ||
						$unRankRegister['resumo']['resultado_pontos'] < (int)$menorValor ){

						$menorValorIndice = $indice;
						$menorValor = $unRankRegister['resumo']['resultado_pontos'];

					}

				}

				if( $menorValor < $resume['resumo']['resultado_pontos'] ){
					$this->arrRank[ $menorValorIndice ] = $resume;
				}


			} else {

				$this->arrRank[] = $resume;

			}


		}

		public function organizeRank()
		{

			$resume 	= $this->arrRank;
			$nRegister 	= count( $this->arrRank );

			for( $i = 0; $i < $nRegister; $i++ ){

				foreach( $this->arrRank as $indice => $unRankRegister ){

					$nextIndice = $indice + 1;

					if( isset( $this->arrRank[ $nextIndice ] ) ){
						$nextPointsResults = $this->arrRank[ $nextIndice ]['resumo']['resultado_pontos'];

						// Se o proximo resultado for maior que este, inverte a posicao,
						// pois os melhores resultados devem vir em primeiro
						if( $nextPointsResults > $unRankRegister['resumo']['resultado_pontos'] ){

							// Colola no indice atual o proximo valor
							$resume[ $indice ] 		= $this->arrRank[ $nextIndice ];

							// Colola no proximo indice o valor atual
							$resume[ $nextIndice ] 	= $unRankRegister;

						}

					}

				}

				$this->arrRank = $resume;

			}

		}

		public function listAllNeuronsPossibilities( $neuronsConfig )
		{

			$arrPossibilites = [];

			$serviceCandleOsc 					= new CandleOsc();
			$serviceNivelOsc 					= new NivelOsc();
			$serviceTiposDeCandlesRepetidos 	= new TiposDeCandlesRepetidos();
			$serviceTiposDeTendenciaRepetidas 	= new TiposDeTendenciaRepetidas();
			$serviceGapAberturaOsc			 	= new GapAberturaOsc();

			// Candle OSC ---------------
			if( $neuronsConfig['gap_abertura']['active'] ){

				$possibilitiesGapAberturaOsc = $serviceGapAberturaOsc->loadPossibilities( 	$loadPossibilities 		= true, 
														  							$minOsc 				= -0.1, 
														  							$maxOsc 				= 1.60, 
														  							$arrType 				= [ 'max', 'min' ] 	);

			} else {

				$possibilitiesGapAberturaOsc = $serviceGapAberturaOsc->loadPossibilities( 	$loadPossibilities 		= false 	);

			}


			// Candle OSC ---------------
			if( $neuronsConfig['candle_osc']['active'] ){

				$possibilitiesCandleOsc = $serviceCandleOsc->loadPossibilities( 	$loadPossibilities 		= true, 
														  							$minOsc 				= -0.1, 
														  							$maxOsc 				= 1.60, 
														  							$arrType 				= [ 'max', 'min' ] 	);

			} else {

				$possibilitiesCandleOsc = $serviceCandleOsc->loadPossibilities( 	$loadPossibilities 		= false 	);

			}


			// Nivel OSC ---------------
			if( $neuronsConfig['nivel_osc']['active'] ){

				$possibilitiesNivelOsc 	= $serviceNivelOsc->loadPossibilities( 	$loadPossibilities 	= true, 
																				$minOsc 			= -0.1, 
																				$maxOsc 			= 1.60 		);

			} else {

				$possibilitiesNivelOsc 	= $serviceNivelOsc->loadPossibilities( 	$loadPossibilities 	= false 	);

			}

			
			// Tipos Candle Repetidos ---------------
			if( $neuronsConfig['candles_repetidos']['active'] ){

				$possibilitiesTiposCandlesRepetidos	= $serviceTiposDeCandlesRepetidos->loadPossibilities(	$loadPossibilities 	= true, 
																											$minCandle 			= 0, 
																											$maxCandle 			= 15 		);

			} else {

				$possibilitiesTiposCandlesRepetidos	= $serviceTiposDeCandlesRepetidos->loadPossibilities(	$loadPossibilities 	= false 	);

			}


			// Tipos Tendencia Repetidas ---------------
			if( $neuronsConfig['tendencias_repetidas']['active'] ){

				$possibilitiesTendenciasRepetidas 	= $serviceTiposDeTendenciaRepetidas->loadPossibilities(	$loadPossibilities 	= true, 
																											$minTendencia 		= 0, 
																											$maxTendencia 		= 15 		);

			} else {

				$possibilitiesTendenciasRepetidas 	= $serviceTiposDeTendenciaRepetidas->loadPossibilities(	$loadPossibilities 	= false 	);

			}

			$arrPossibilites['nivel_osc'] = $possibilitiesNivelOsc;
			// echo '<br />' . count( $possibilitiesNivelOsc );

			$arrPossibilites['tipos_candle_repetidos'] = $possibilitiesTiposCandlesRepetidos;
			// echo '<br />' . count( $possibilitiesTiposCandlesRepetidos );

			$arrPossibilites['tendencia_repetida'] = $possibilitiesTendenciasRepetidas;
			// echo '<br />' . count( $possibilitiesTendenciasRepetidas );

			$arrPossibilites['candle_osc'] = $possibilitiesCandleOsc;
			// echo '<br />' . count( $possibilitiesCandleOsc );

			$arrPossibilites['gap_abertura'] = $possibilitiesGapAberturaOsc;

			return $this->mergeNeuronsPossibilities( $arrPossibilites );

		}

		public function mergeNeuronsPossibilities( $arrPossibilites )
		{

			try {

				$possibilitesConfig = [];

				$nNeurons = count( $arrPossibilites );

				if( $nNeurons != 5 ){ // Diferente do numero de neuronios
					throw new Exception("Numero de neuronios errada, ajuste para adaptar os novos neuronios, n: " . $nNeurons );
				}

				foreach( $arrPossibilites['candle_osc'] as $possibilitesCandleOsc ){ // Neurorio CandleOsc

					foreach( $arrPossibilites['nivel_osc'] as $possibilitesNivelOsc ){ // Neurorio NivelOsc

						foreach( $arrPossibilites['tipos_candle_repetidos'] as $possibilitesTipoCandleRepetidos ){ // Neurorio TipoCandleRepetidos

							foreach( $arrPossibilites['tendencia_repetida'] as $possibilitesTendenciaRepetida ){ // Neurorio TendenciaRepetidas

								foreach( $arrPossibilites['gap_abertura'] as $possibilitesGepAbertura ){

									$possibilitesConfig[] = [
										'candle_osc'			=> $possibilitesCandleOsc,
									 	'nivel_osc'				=> $possibilitesNivelOsc,
										'candles_repetidos'		=> $possibilitesTipoCandleRepetidos,
										'tendencias_repetidas'	=> $possibilitesTendenciaRepetida,
										'gap_abertura'			=> $possibilitesGepAbertura,
									];

								}

							}
					
						}

					}

				}

				return $possibilitesConfig;

			} catch( Exception $e ){
				throw new Exception( $e->getMessage() );
			}

		}

	}

?>