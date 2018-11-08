<?php

	namespace WDOAPI\Files;

	Class HistoricalData extends Files {

		private $debug;

		public function __construct( $debug = false ){

			$this->debug = $debug;

		}

		public function uploadFileCsv( $dirFile ){

			$data = $this->readFileCSV( $dirFile );
			return $this->_processFileCsv( $data );

		}

		private function _processFileCsv( $data ){

			$arrHistorical = [];

			foreach( $data as $nLine => $line ){

				if( isset($line[1]) ){

					$date = $line[0]; // Data
					$opened = $line[1]; // Abertura
					$max = $line[2]; // Max
					$min = $line[3]; // Min
					$closed = $line[4]; // Fechamento
					$volTick = $line[5]; // Volume de Ticks
					$volume = $line[6]; // Volume
					$typeDay = "null";
					$dailyVariation;
					$differenceOfPoints;
					$dailyVariationOfMaxRate;
					$dailyVariationOfMinRate;
					$dayWeek;
					$numberOfWeek;

					// @TODO
					// Trabamento dos dados ( Pois tem caracteres ocultos e chineses no emio --` | FDP de quem colocou isso nos arquivos )
					// OBS: SE COLOCAR (DOUBLE) ou (FLOAT) ali em cima e so converter, o resultado sempre sera "0"
					$opened = (double)str_replace( "PONTO", ".", preg_replace('/\W+/u', '', str_replace(".", "PONTO", $opened ) ) );
					$max = (double)str_replace( "PONTO", ".", preg_replace('/\W+/u', '', str_replace(".", "PONTO", $max ) ) );
					$min = (double)str_replace( "PONTO", ".", preg_replace('/\W+/u', '', str_replace(".", "PONTO", $min ) ) );
					$closed = (double)str_replace( "PONTO", ".", preg_replace('/\W+/u', '', str_replace(".", "PONTO", $closed ) ) );
					$volume = (int)str_replace( "PONTO", ".", preg_replace('/\W+/u', '', str_replace(".", "PONTO", $volume ) ) );

					$date = str_replace('.', 'a', $date);
					$date = preg_replace('/[^A-Za-z0-9-]/', '', $date);
					$date = str_replace( 'a', '-', $date);

					if( $opened < $closed ){ // Abertura menor que o fechamento do dia
						$typeDay = "high";
						$differenceOfPoints = (int)($closed - $opened );
					} else if( $opened > $closed ){ // Abertura maior que o fechametno do dia
						$typeDay = "low";
						$differenceOfPoints = (int)($opened - $closed );
					}


					$dailyVariation = number_format( ( ( 100 / $opened ) * $closed ) - 100 , 2 );
					$dailyVariationOfMaxRate = number_format( ( ( 100 / $opened ) * $max ) - 100 , 2 );
					$dailyVariationOfMinRate = ( number_format( ( ( 100 / $opened ) * $min ) - 100 , 2 ) ) * -1;

					$dayWeek = date('w',strtotime( str_replace('.', '-', $date) ));

					if( $this->debug ){

						echo '<br />Variaveis do processamento de um';
						echo '$date = ' . $date . '<br />';
						echo '$opened = ' . $opened . '<br />';
						echo '$max = ' . $max . '<br />';
						echo '$min = ' . $min . '<br />';
						echo '$closed = ' . $closed . '<br />';
						echo '$volTick = ' . $volTick . '<br />';
						echo '$volume = ' . $volume . '<br />';
						echo '$typeDay = ' . $typeDay . '<br />';
						echo '$dailyVariation = ' . $dailyVariation . '<br />';
						echo '$dailyVariationOfMaxRate = ' . $dailyVariationOfMaxRate . '<br />';
						echo '$dailyVariationOfMinRate = ' . $dailyVariationOfMinRate . '<br />';
						echo '$dayWeek = ' . $dayWeek . '<br />';
						echo '$differenceOfPoints = ' . $differenceOfPoints . '<br />';
						echo '<hr />';

					}

					$date = $date . ' 18:00:00';

					if( $dayWeek > 0 && $dayWeek < 6 ){

						$arr = [
							'date' => $date,
							'opened' => $opened,
							'closed' => $closed,
							'max' => $max,
							'min' => $min,
							'type' => $typeDay,
							'var_dif_points' => $differenceOfPoints,
							'var' => $dailyVariation,
							'var_in_max' => $dailyVariationOfMaxRate,
							'var_in_min' => $dailyVariationOfMinRate,
							'day_week' => $dayWeek,
							'volume' => $volume,
						];

						$arrHistorical[] = $arr;

					}

				}

			}

			return $arrHistorical;

		}

	}

?>