<?php

	namespace WDOAPI\Services\BackTest;

	use Exception;
	use \WDOAPI\Bootstrap\Operations;
	use \WDOAPI\Services\GraphicAnalysisNeurons\NivelOsc;
	use \WDOAPI\Services\GraphicAnalysisNeurons\CandleOsc;
	use \WDOAPI\Services\GraphicAnalysisNeurons\TiposDeCandlesRepetidos;
	use \WDOAPI\Services\GraphicAnalysisNeurons\TiposDeTendenciaRepetidas;
	use WDOAPI\Services\GraphicAnalysisNeurons\GapAberturaOsc;

	Class BackTestOperations extends Operations {

		public function checkCenario( $sgbdCandles, $neurons, $officeHour, $operations )
		{

			$this->settingOperations = $operations;

			$cenario = [
				'between_data'	=> [
					'started_at'	=> ( explode( " " , $sgbdCandles[0]->date ) )[0] ,
					'finish_at'		=> ( explode( " " , array_reverse( $sgbdCandles )[0]->date ) )[0] ,
				],
				'between_hour' 	=> [
					'started_at'	=> $officeHour['startAt'],
					'finish_at'		=> $officeHour['finishAt'],
				],
				'neuronios'	   	=> [],
			];

			$tiposCandlesRepetidosService 	= new TiposDeCandlesRepetidos();
			$tendenciaRepetidasService		= new TiposDeTendenciaRepetidas();
			$nivelOscService 				= new NivelOsc();
			$candleOscService 				= new CandleOsc();
			$gapAbertura 					= new GapAberturaOsc();

			$arrAllowedDays = [];
			$arrDays 		= [];

			if( $neurons['gap_abertura']['active'] ){

				$typeEscrito = ( $neurons['gap_abertura']['type'] == 'max' ) ? 
									"no maximo " . $neurons['gap_abertura']['osc'] .'%':
									"no minimo " . $neurons['gap_abertura']['osc'] .'%';

			    $cenario['neuronios'][] = [
					'neuronio'		=> 'gap_abertura',
					'osc' 			=> $neurons['gap_abertura'],
					'description' 	=> "* Quando a variacao do GAP for de " . $typeEscrito ,
				];

				$response = $gapAbertura->check(	$sgbdCandles, 
											$neurons['gap_abertura']['osc'], 
											$neurons['gap_abertura']['type'] );

				$arrDays[] = $response['days'];

			}
			
			if( $neurons['candle_osc']['active'] ){


				$typeEscrito = ( $neurons['candle_osc']['type'] == 'max' ) ? 
									"no maximo de " . $neurons['candle_osc']['osc'] :
									"no minimo de " . $neurons['candle_osc']['osc'] ;

				$cenario['neuronios'][] = [
					'neuronio'		=> 'candle_osc',
					'osc' 			=> $neurons['candle_osc']['osc'],
					'description' 	=> "* Quando a variacao do proprio candle for " . $typeEscrito ,
				];

				$response = $candleOscService->check(	$sgbdCandles, 
											$neurons['candle_osc']['osc'], 
											$neurons['candle_osc']['type'],
											$officeHour['startAt'], 
											$officeHour['finishAt'] 	);

				$arrDays[] = $response['days'];
															 
			}

			if( $neurons['nivel_osc']['active'] ){

				$cenario['neuronios'][] = [
					'neuronio'		=> 'nivel_osc',
					'osc' 			=> $neurons['nivel_osc']['osc'],
					'description' 	=> "* Quando fechamento do candle esta com osc minima de " . $neurons['nivel_osc']['osc'],
				];

				$response = $nivelOscService->check( 	$sgbdCandles, 
														$neurons['nivel_osc']['osc'], 
														$officeHour['startAt'], 
														$officeHour['finishAt'] 	);

				$arrDays[] = $response['days'];

			}

			if( $neurons['candles_repetidos']['active'] ){

				$cenario['neuronios'][] = [
					'neuronio'			=> 'candles_repetidos',
					'candles_repetidos'	=> $neurons['candles_repetidos']['n_candles'],
					'description' 		=> "* Quando estiver no  " . $neurons['candles_repetidos']['n_candles'] . "º candle com o mesmo tipo ( high|low )",
				];

				$response = $tiposCandlesRepetidosService->check(	$sgbdCandles, 
																	$neurons['candles_repetidos']['n_candles'], 
																	$officeHour['startAt'], 
																	$officeHour['finishAt'] 	);

				$arrDays[] = $response['days'];

			}

			if( $neurons['tendencias_repetidas']['active'] ){

				$cenario['neuronios'][] = [
					'neuronio'			=> 'tendencias_repetidas',
					'candles_repetidos'	=> $neurons['tendencias_repetidas']['n_days'],
					'description' 		=> "* Apos " . $neurons['tendencias_repetidas']['n_days'] . " dia(s) de tendencia repetida",
				];

				$response = $tendenciaRepetidasService->check(	$sgbdCandles, 
																$neurons['tendencias_repetidas']['n_days'], 
																$officeHour['startAt'], 
																$officeHour['finishAt'] 	);

				$arrDays[] = $response['days'];

			}	

			// Dias que tem trade pois atinge todos os requisitos dos metodos ativos a cima
			$arrAllowedDays = $this->checkDaysOfOperations( $arrDays );

			// Agrupa por dias e percorre os dias
			$arrCandlesByDays = $this->groupCandlesByDay( $sgbdCandles, $officeHour['startAt'], $officeHour['finishAt'] );

			foreach( $arrCandlesByDays as $day => $arrCandles ){

				// echo '<pre>';
				// print_r( $arrCandles );
				// die;

				// Se tiver dias, processa os dados
				if ( in_array( $day, $arrAllowedDays ) ) {

					$lastCandle = null;
					$openedCandle = null;

					// Percorre candle por candle
					foreach( $arrCandles as $indice => $candle ){

						$lastCandle = $candle;

						// Toda data diferente rezeta o candle de abertura, se for nullo, preencha com o primeiro candle do dia
						if( $openedCandle == null ){
							$openedCandle = $candle;
						}

						// Verifico o status atual das operacoes em aberto
						$this->checkOperactions( $candle );

						// Verifica se esta dentro dos conformes e atende todos os neuronios ativos

						$openOperation = null;

						if( $neurons['candle_osc']['active'] ){

							if( $candleOscService->checkCandle( $candle	) && 
							 	( $openOperation === null || $openOperation === true ) ){
								$openOperation = true;
							} else {
								$openOperation = false;
							}

						}

						if( $neurons['candles_repetidos']['active'] ){

							if( $tiposCandlesRepetidosService->checkCandle( $candle ) && 
							 	( $openOperation === null || $openOperation === true ) ){
								$openOperation = true;
							} else {
								$openOperation = false;
							}

						}

						if( $neurons['nivel_osc']['active'] ){

							if( $nivelOscService->checkCandle( $candle ) && 
							 	( $openOperation === null || $openOperation === true ) ){
								$openOperation = true;
							} else {
								$openOperation = false;
							}

						}


						// Starta a operacao
						if( $openOperation === true ) {

							// Se nao houver operacoes abertas
							if( !$this->checkOpenedPerations() ){

								$taxStopGain;
								$taxStopLoss;

								// Verifico se vai ser compra ou venda baseado na taxa a cima ou abaixo da abertura
								$checkCandleEmRelaxaoAbertura = $this->checkTaxaMaiorOuMenor( $openedCandle->open, $candle->close );

								if( $checkCandleEmRelaxaoAbertura != null ){
								
									// Calculo a taxa de stop gain e o stop loss da operacao
									if( $checkCandleEmRelaxaoAbertura["op_retracao"] == "compra" ){

										$taxStopGain = $this->calculateTax( $candle->close, $operations["stop"]["gain"], "sum", $openedCandle->open );
										$taxStopLoss = $this->calculateTax( $candle->close, $operations["stop"]["loss"], "less", $openedCandle->open );

									} else if( $checkCandleEmRelaxaoAbertura["op_retracao"] == "venda" ){

										$taxStopGain = $this->calculateTax( $candle->close, $operations["stop"]["gain"], "less", $openedCandle->open );
										$taxStopLoss = $this->calculateTax( $candle->close, $operations["stop"]["loss"], "sum", $openedCandle->open );

									}

									
									// Prevensao se o preco voltar
									if( $operations['prevention_of_price_back']['active'] === true ){

										if( $checkCandleEmRelaxaoAbertura["op_retracao"] == "compra" ){

											$afterPoints = $this->calculateTax( $candle->close, $operations['prevention_of_price_back']['after_points'], "sum", $openedCandle->open );
											$getOutAt 	 = $this->calculateTax( $candle->close, $operations['prevention_of_price_back']['get_out_at'], "sum", $openedCandle->open );

											$operations['prevention_of_price_back']['points_after_points'] 	= $afterPoints;
											$operations['prevention_of_price_back']['points_get_out_at'] 	= $getOutAt;
											$operations['prevention_of_price_back']['leave_the_operations'] = false;

										} else if( $checkCandleEmRelaxaoAbertura["op_retracao"] == "venda" ){

											// Se for venda, pega os pontos de venda, pois esses valores e pra evitar que o preco volta
											$afterPoints = $this->calculateTax( $candle->close, $operations['prevention_of_price_back']['after_points'], "less", $openedCandle->open );
											$getOutAt 	 = $this->calculateTax( $candle->close, $operations['prevention_of_price_back']['get_out_at'], "less", $openedCandle->open );

											$operations['prevention_of_price_back']['points_after_points'] 	= $afterPoints;
											$operations['prevention_of_price_back']['points_get_out_at'] 	= $getOutAt;
											$operations['prevention_of_price_back']['leave_the_operations'] = false;

										}

									}

									$this->openOperation( 	$candle,
															$checkCandleEmRelaxaoAbertura["op_retracao"], 
															$candle->close,
															$taxStopLoss, 
															$taxStopGain, 
															$operations["range_candle"]["min"], 
															$operations["range_candle"]["max"],
															$operations['prevention_of_price_back'],
															$operations['pointsInEmoluments']	);

								}

							}

						}						

					}

					// Forca a fechar todas as operacoes em aberto pois a hora das operacoes acabou
					if( $lastCandle != null ){
						$this->checkOperactions( $lastCandle, 
												 $forceCloseAll = true, 
												 "Ao final do dia deve finalizar todas as operacoes" );
					}

				}

			}

			$resumo = $this->createResumeOperations();
			$operacoes = $resumo["operations"];
			unset( $resumo["operations"] );

			return [
				'resumo'	=> $resumo,
				'cenario'	=> $cenario,
				'operacoes'	=> $operacoes,
			];
			
		}

		public function checkDaysOfOperations( $arrDays )
		{

			$arrContainerAllDays 	= [];
			$arrAllowedDays 		= [];

			// Percorro arr de varias funcoes e adiciono dias na variavel $arrContainerAllDays
			foreach( $arrDays as $arrDaysMetod ) {

				foreach( $arrDaysMetod as $day ){
					$arrContainerAllDays[] = $day;
				}

			}

			$arrContainerAllDays = array_unique( $arrContainerAllDays );

			// Percorro os dias e vejo os que se enquadram na resposta de dias validos de todas as funcoes
			foreach( $arrContainerAllDays as $day ) {

				// echo $day;
				// echo '<hr />';
				
				$allowed = true;

				foreach( $arrDays as $arrDaysMetod ) {

					// Se nao houver o dia no array de retorno de uma funcao
					if ( !in_array( $day, $arrDaysMetod ) ) { 
						$allowed = false;
					}

				}

				if( $allowed ) {

					$arrAllowedDays[] = $day;

				}

			}

			return $arrAllowedDays;

		}

	}

?>