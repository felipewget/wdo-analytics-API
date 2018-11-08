<?php

	namespace WDOAPI\Operations;

	Class BackTest extends Operations {

		public function __construct(){

		}

		public function backTestRetraction( $data )
		{

			//@TODO - DEPOIS VAI PRA CLASSE Operations
			$openOprateions = [];

			$horaInicial = '13:30:00';
			$horaFinal = '13:40:00';
			$minOsc = 0.3;
			$medianIn = 10; // 10P
			$gainIn = 10; // 10P
			$loss = 10; // 10P
			$maxCandlesForExitInRate = 5;


			$horaInicial = str_replace(':', '', $horaInicial );
			$horaFinal = str_replace(':', '', $horaFinal );

			$data = $this->groupDataByDate( $data );
			$countDay = 0;

			foreach( $data as $day => $value ){
				$countDay++;
				$arrDaysIndex[] = $day;
			}

			foreach( $arrDaysIndex as $day ){

				$openedDay = null;
				$pointPercent = null;

				$dayComparative = $data[$day];
				foreach( $data[$day] as $key => $candle ){

					// Percorre o dia aki

					$hour = explode( ' ' , $candle['date'] )[1];

					if( $openedDay == null ){
						$openedDay = $candle['open'];
						$pointPercent = ( $openedDay / 100 ) * $minOsc;
					}

					
					if( str_replace(':', '', $hour ) >= $horaInicial && str_replace(':', '', $hour ) <= $horaFinal){

						if( $candle['close'] >= ( $openedDay + $pointPercent ) || $candle['close'] <= ( $openedDay + $pointPercent ) ){

							if( $candle['close'] >= ( $openedDay + $pointPercent ) ){
								
								// PUT
								if( count( $openOprateions ) == 0 ){

									$openOprateions[] = [
										'date' => $candle['date'],
										'start' => $candle['close'],
										'type' => 'PUT',
										'gain' => $candle['close'] - $gainIn,
										'median' => $candle['close'] + $gainIn,
										'loss' => $candle['close'] + 50
									];

								}

							} else {
								
								// CALL
								if( count( $openOprateions ) == 0 ){

									$openOprateions[] = [
										'date' => $candle['date'],
										'start' => $candle['close'],
										'type' => 'CALL',
										'gain' => $candle['close'] + $gainIn,
										'median' => $candle['close'] - $gainIn,
										'loss' => $candle['close'] - 50
									];

								}

							}


						}
					}

					if( count( $openOprateions ) > 0 ){

						if( $openOprateions[0]['type'] == 'CALL' ){

							if( $candle['max'] > $openOprateions[0]['gain'] ){
								
								echo 'GAIN | ' . $openOprateions[0]['date'];
								echo '<br />';
								var_dump($openOprateions);
								echo '<br />';
								echo $candle['max'];
								echo '<hr />';


							}

						} else {

							if( $candle['min'] < $openOprateions[0]['gain'] ){
								
								echo 'GAIN | ' . $openOprateions[0]['date'];
								echo '<br />';
								var_dump($openOprateions);
								echo '<br />';
								echo $candle['max'];
								echo '<hr />';


							}

						}

					}

					$openOprateions = [];
					// FINAL - percorreu um dia

				}

			}

			die('Dias: ' . $countDay);
		}

		public function backTestData( $historicalData, $intradayData, $options )
		{

			$dayTypeInSequence = 0;

			foreach( percorrer_dias as $candle ){



				if( $options['after_period_tendence_days'] > $dayTypeInSequence ){

					

				}

				$dayTypeInSequence++;

			}

		}

	}

?>