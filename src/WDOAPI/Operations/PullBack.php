<?php

	namespace WDOAPI\Operations;

	Class PullBack extends Operations {

		public function __construct(){

		}

		public function testRetractionByOsc( $data, $minimunOfNumberOfCandles, $maximunOfNumberOfCandles, $minimumPoint = 0, $validarPelaSombra = 0 )
		{

			$countDay = 0;

			$lookupData = [
				'pullback' => [],
				'without_pullback' => [],
			];

			$osc = [];
			for( $i=1; $i<42;$i++){
				
				$index = $i * 0.10;
				$index = (String)$index;
				$osc[$index] = 0;

				$lookupData['pullback'][$index] = [];
				$lookupData['without_pullback'][$index] = [];

			}


			$data = $this->groupDataByDate( $data );
			$arrDaysIndex = [];

			foreach( $data as $date => $candles ){
				// 1 Dia
				$openedDay = null;
				$oscCompare = [];
				$candlesForComparate = $candles; // Pego o mesmo array, mas agora pra comparar com os candles

				for( $i=1; $i<42;$i++){

					$index = $i * 0.10;
					$index = (String)$index;
					$oscCompare[$index] = 0;

				}

				foreach( $candles as $nCandle => $candle ){ // Candles no array de candle de um dia

					$hour = explode( ' ' , $candle['date'] )[1];
					if( $openedDay == null ){
						$openedDay = $candle['open'];
					}

					if( $openedDay != null ){

						foreach( $candlesForComparate as $nCandleForComparate => $candleForComparate ){

							if( $nCandleForComparate > $nCandle ){

								if( ( $nCandleForComparate - $nCandle ) >= $minimunOfNumberOfCandles && ( $nCandleForComparate - $nCandle ) <= $maximunOfNumberOfCandles ){

									if( $openedDay < $candle['close'] ){ // Acima da abertura

										if( $validarPelaSombra == 0 ){
											$precoFechamentoCandle = $candle['close'];
											$precoFechamentoCandleComparativo = $candleForComparate['close'];
										} else {
											$precoFechamentoCandle = $candle['max'];
											$precoFechamentoCandleComparativo = $candleForComparate['min'];
										}

										if( ( $precoFechamentoCandleComparativo + $minimumPoint ) < $precoFechamentoCandle ){

											for( $i=1; $i<42;$i++){
					
												$index = $i * 0.10;
												$nIndex = $index;
												$index = (String)$index;
												if( $oscCompare[$index] == 0 ){

													$rate = $openedDay + number_format( ( $openedDay / 100 * $nIndex ) , 2 );
													if( $candle['open'] <= $rate && $precoFechamentoCandle >= $rate ){

														// echo 'Abertura: ' . ($openedDay).' ( ' . $nIndex . '% ) <br />';
														// echo 'Tipo: PUT <br />';
														// echo ($candle['date'] . ' -- > ' . $candle['close'] );
														// echo '<br />';
														// print_r($candleForComparate['close']);
														// echo '<hr />';

														$arrPulback = [
															'type' => 'PUT',
															'percent' => $nIndex,
															'start_candle' => $candle,
															'end_candle' => $candleForComparate,
														];

														$lookupData['pullback'][$index][] = $arrPulback;


														$oscCompare[$index] = 1;

													}

												}

											}

										}

									} else { // Abaixo da abertura

										if( $validarPelaSombra == 0 ){
											$precoFechamentoCandle = $candle['close'];
											$precoFechamentoCandleComparativo = $candleForComparate['close'];
										} else {
											$precoFechamentoCandle = $candle['min'];
											$precoFechamentoCandleComparativo = $candleForComparate['max'];
										}

										/////
										if( ( $precoFechamentoCandleComparativo - $minimumPoint ) > $precoFechamentoCandle ){

											for( $i=1; $i<42;$i++){
					
												$index = $i * 0.10;
												$nIndex = $index;
												$index = (String)$index;
												if( $oscCompare[$index] == 0 ){

													$rate = $openedDay - number_format( ( $openedDay / 100 * $nIndex ) , 2 );
													if( $candle['open'] >= $rate && $precoFechamentoCandle <= $rate ){

														// echo 'Abertura: ' . ($openedDay).' ( ' . $nIndex . '% ) <br />';
														// echo 'Tipo: CALL <br />';
														// echo ($candle['date'] . ' -- > ' . $candle['close'] );
														// echo '<br />';
														// print_r($candleForComparate['close']);
														// echo '<hr />';

														$arrPulback = [
															'type' => 'CALL',
															'percent' => $nIndex,
															'start_candle' => $candle,
															'end_candle' => $candleForComparate,
														];

														$lookupData['pullback'][$index][] = $arrPulback;


														$oscCompare[$index] = 1;

													}

												}

											}

										}
										///////

									}
									// var_dump($candleForComparate);

								}

								// die();
							}

							
						}

						////////
						// AKI, significa que ele tem os parametros X porem nao atingiu os pontos
						for( $i=1; $i<42;$i++){

							$index = $i * 0.10;
							$nIndex = $index;
							$index = (String)$index;
							if( $oscCompare[$index] == 0 ){

								$rate = $openedDay - number_format( ( $openedDay / 100 * $nIndex ) , 2 );
								if( $candle['open'] >= $rate && $candle['close'] <= $rate ){

									// echo 'NAO CHEGOU AO QUE PRECISA<br />';
									// echo 'Abertura: ' . ($openedDay).' ( ' . $nIndex . '% ) <br />';
									// echo 'Tipo: CALL <br />';
									// echo ($candle['date'] . ' -- > ' . $candle['close'] );
									// echo '<hr />';

									$lookupData['without_pullback'][$index][] = [
										'candle' => $candle
									];

									$oscCompare[$index] = 1;

								}

							}

						}
						////////


					}

				}

			}

			return [
				'lookup' => $lookupData,
			];
			
			die();



			set_time_limit(30);

			error_reporting(0);

			$countDay = 0;

			$lookupData = [
				'pullback' => [],
				'without_pullback' => [],
			];

			$osc = [];
			for( $i=1; $i<42;$i++){
				
				$index = $i * 0.10;
				$index = (String)$index;
				$osc[$index] = 0;

				$lookupData['pullback'][$index] = [];
				$lookupData['without_pullback'][$index] = [];

			}


			$data = $this->groupDataByDate( $data );
			$arrDaysIndex = [];
			$travaDia = [];

			foreach( $data as $day => $value ){
				$countDay++;
				$arrDaysIndex[] = $day;
			}

			foreach( $arrDaysIndex as $day ){

				/// Um dia

				$openedDay = null;
						
				$dayComparative = $data[$day];
				foreach( $data[$day] as $key => $candle ){

					$searched = 0;
					$oscCandle = 0;

					$hour = explode( ' ' , $candle['date'] )[1];

					if( $openedDay == null ){

						foreach ( $osc as $keyOsc => $value ) {
							$travaDia['trava_osc'][(string)$keyOsc] = 0;
						}

						$openedDay = $candle['open'];
					}

					if( $candle['close'] > $openedDay ){ // se fechou a cima da abertura

						foreach ( $osc as $keyOsc => $value ) {
						
							$rate = $openedDay + number_format( ( $openedDay / 100 * $keyOsc ) , 2 );
							if( $candle['open'] <= $rate && $candle['close'] >= $rate ){
								
								$osc[(string)$keyOsc] = $value + 1;

								$hasPullback = 0;

								foreach( $dayComparative as $keyIntraOp => $valueCandleIntraOp ){

									if( $key < $keyIntraOp ){
										
										if( ( $keyIntraOp - $key ) >= $minimunOfNumberOfCandles  ){

											if( ( (double)$candle['close'] - $minimumPoint ) >= ( (double)$valueCandleIntraOp['close'] ) ){

												if( $travaDia['trava_osc'][(string)$keyOsc] != 1 ){

													if( $hasPullback == 0 ){

														$travaDia['trava_osc'][(string)$keyOsc] = 1;

														// ADICIONA QUE TEM PULLBACK
														$arrPulback = [
															'type' => 'PUT',
															'start_candle' => $candle,
															'end_candle' => $valueCandleIntraOp,
														];

														// echo '<pre>';
														// print_r($arrPulback);
														// echo '<hr />';

														$lookupData['pullback'][(string)$keyOsc][] = $arrPulback;
														$hasPullback = 1;

													}

												}



											}

										}

									}


								}

								// NAO TEM PULLBACK
								if( $hasPullback != 1 ){

									$lookupData['without_pullback'][(string)$keyOsc][] = [
													'type' => 'PUT',
													'start_candle' => $candle,
													];

								}

							}
							// var_dump($rate);

						}
					
					} else if( $candle['close'] < $openedDay ){ // se fechou abaixo da abertura

						foreach ( $osc as $keyOsc => $value ) {

							$rate = $openedDay - number_format( ( $openedDay / 100 * $keyOsc ) , 2 );

							if( $candle['open'] >= $rate && $candle['close'] <= $rate ){

								$osc[(string)$keyOsc] = $value + 1;

								$hasPullback = 0;

								foreach( $dayComparative as $keyIntraOp => $valueCandleIntraOp ){

									if( $key < $keyIntraOp ){
										
										if( ( $keyIntraOp - $key ) >= $minimunOfNumberOfCandles  ){

											if( ( (double)$candle['close'] + $minimumPoint ) >= ( (double)$valueCandleIntraOp['close'] ) ){

												if( $travaDia['trava_osc'][(string)$keyOsc] != 1 ){

													if( $hasPullback == 0 ){

														$travaDia['trava_osc'][(string)$keyOsc] = 1;

														// ADICIONA QUE TEM PULLBACK

														$arrPulback = [
															'type' => 'CALL',
															'start_candle' => $candle,
															'end_candle' => $valueCandleIntraOp,
														];

														$lookupData['pullback'][(string)$keyOsc][] = $arrPulback;
														$hasPullback = 1;

													}

												}

											}

										}

									}


								}

								// NAO TEM PULLBACK
								if( $hasPullback != 1 ){
									
									$lookupData['without_pullback'][(string)$keyOsc][] = [
													'type' => 'CALL',
													'start_candle' => $candle,
													];
								}





							}
							// var_dump($rate);

						}

					}

					// var_dump();

					// echo number_format( ( $openedDay / 100 * 0.25 ) , 2 );
					// die();
					// // $dailyVariationOfMaxRate = number_format( ( ( 100 / $openedDay ) * $clandeClosedIn ) - 100 , 2 );
					// // $dailyVariationOfMinRate = ( number_format( ( ( 100 / $openedDay ) * $clandeClosedIn ) - 100 , 2 ) ) * -1;

				}


				// Final de um dia

			}


			return [
				'lookup' => $lookupData,
			];

		}

		public function testRetraction( $data, $minimunOfNumberOfCandles, $maximunOfNumberOfCandles, $minOsc, $minimumPoint = 0 )
		{

			error_reporting(0);

			// numero maximo de cnadles tbm e importante

			$countDay = 0;
			$countDaysOfOperations = 0;
			$mainHours = [];
			$mainHoursWidwhoutPullback = [];

			$lookupData = [
				'pullback' => [],
				'without_pullback' => [],
			];

			////////

			
			for( $hr = 9; $hr < 18; $hr++ ){

				if( $hr < 10 ){
					$hrAux = '0'.$hr;
				} else {
					$hrAux = $hr;
				}
				

				foreach (range(0, 55, 5) as $minute) {
					if( $minute < 10 ){
						$minAux = '0'.$minute;
					} else {
						$minAux = $minute;
					}
				    $index = $hrAux.':'.$minAux.':00';
					
					$mainHours[$index] = 0;
					$mainHoursWidwhoutPullback[$index] = 0;

				}


			}

			////////

			$openedDay;
			$clandeClosedIn;
			$typeInRelationOfOpenedDay; // candle fechou a ciam ou a abaio da abertura

			$data = $this->groupDataByDate( $data );
			$arrDaysIndex = [];

			foreach( $data as $day => $value ){
				$countDay++;
				$arrDaysIndex[] = $day;
			}

			foreach( $arrDaysIndex as $day ){

				$openedDay = null;

				$dayComparative = $data[$day];
				foreach( $data[$day] as $key => $candle ){

					$searched = 0;
					$oscCandle = 0;

					$hour = explode( ' ' , $candle['date'] )[1];

					if( $openedDay == null ){
						$openedDay = $candle['open'];
					}

					$clandeClosedIn = $candle['close'];
					$dailyVariationOfMaxRate = number_format( ( ( 100 / $openedDay ) * $clandeClosedIn ) - 100 , 2 );
					$dailyVariationOfMinRate = ( number_format( ( ( 100 / $openedDay ) * $clandeClosedIn ) - 100 , 2 ) ) * -1;

					if( $openedDay < $clandeClosedIn ){
						$typeInRelationOfOpenedDay = 'high';
						$oscCandle = $dailyVariationOfMaxRate;
					} else if( $openedDay > $clandeClosedIn ){
						$typeInRelationOfOpenedDay = 'low';
						$oscCandle = $dailyVariationOfMinRate;
					} else {
						$typeInRelationOfOpenedDay = 'null';
					}
					

					// if( $day == '2018-10-03' && $hour == '09:55:00' ){

					// 	echo $openedDay;
					// 	echo '<hr />';
					// 	var_dump( $candle );
					// 	echo '<hr />';
					// 	echo 'Max Osc: '. $dailyVariationOfMaxRate;
					// 	echo '<br />';
					// 	echo 'Min Osc: '. $dailyVariationOfMinRate;

					// 	// echo $oscCandle;
					// 	die();
					// }

				if( $oscCandle >= $minOsc ){



					if( $typeInRelationOfOpenedDay != 'null'){
						foreach( $dayComparative as $keyAux => $candleAux ){

							if( $keyAux <= ($key + $maximunOfNumberOfCandles) ){

								if( $keyAux >= ($key + $minimunOfNumberOfCandles) ){

									if( $typeInRelationOfOpenedDay == 'high' ){

										if( ( $clandeClosedIn - $minimumPoint ) >= $candleAux['close'] ){
											if( $searched == 0 ){
												$mainHours[$hour]++;
												$searched = 1;

												$countDaysOfOperations++;

												$lookupData['pullback'][$hour][] = [
													'candle' => $candle,
													'candle_pullback' => $candleAux
												];

											}
										}

									} else if( $typeInRelationOfOpenedDay == 'low' ){

										if( ( $clandeClosedIn + $minimumPoint ) <= $candleAux['close'] ){
											if( $searched == 0 ){
												$mainHours[$hour]++;
												$searched = 1;

												$countDaysOfOperations++;

												$lookupData['pullback'][$hour][] = [
													'candle' => $candle,
													'candle_pullback' => $candleAux
												];

											}
										}

									}

								}

							}

						}

						if( $searched == 0 ){

							$mainHoursWidwhoutPullback[$hour]++;

							$countDaysOfOperations++;

							$lookupData['without_pullback'][$hour][] = [
								'candle' => $candle
							];

						}

					}

				}


				}

			}

			return $response = [
				'days' => $countDay,
				//'days_of_operations' => $countDaysOfOperations,
				'retraction_by_candles' => $mainHours,
				'without_retraction_by_candles' => $mainHoursWidwhoutPullback,
				'analytical_data' => $lookupData,
			];

		}

	}

?>