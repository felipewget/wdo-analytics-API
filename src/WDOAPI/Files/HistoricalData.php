<?php

	namespace WDOAPI\Files;

	Class HistoricalData extends Files {

		// Investing
		// https://br.investing.com/currencies/usd-brl-historical-data
		public function uploadFileCsv( $dirFile ){

			$data = $this->readFileCSV( $dirFile , '","' );
			return $this->_processFileCsv( $data );

		}

		private function _processFileCsv( $data ){

			$arrHistorical = [];

			unset( $data[0] );

			foreach( $data as $nLine => $line ){


				$line[0] = str_replace( '"', '', $line[0] ); // Data
				$line[1] = substr( str_replace( ['"', ','], ['', ''], $line[1] ), 0, 4 ); // Último
				$line[2] = substr( str_replace( ['"', ','], ['', ''], $line[2] ), 0, 4 ); // Abertura
				$line[3] = substr( str_replace( ['"', ','], ['', ''], $line[3] ), 0, 4 ); // Máxima
				$line[4] = substr( str_replace( ['"', ','], ['', ''], $line[4] ), 0, 4 ); // Mínima
				$line[5] = str_replace( ['"', ','], ['', '.'], $line[5] ); // Var%

				$data = implode( "-" , array_reverse( explode('.', $line[0] ) ) ) . ' 18:00:00';
				$type = str_replace( "%", "", $line[5] );
				if( $type > 0){
					$type = "high";
				} else if( $type < 0 ){
					$type = "low";
				} else {
					$type = "null";
				}

				if( $line[2] > $line[1] ){
					$difP = $line[2] - $line[1];
				} else if( $line[2] < $line[1] ){
					$difP = $line[1] - $line[2];
				} else {
					$difP = 0;
				}

				$dayWeek = date('w',strtotime( $data ));

				if( $dayWeek > 0 && $dayWeek < 6 ){

					$arr = [
						'date' => $data,
						'closed' => $line[1],
						'opened' => $line[2],
						'max' => $line[3],
						'min' => $line[4],
						'type' => $type,
						'var_dif_points' => $difP,
						'var' => str_replace( "%", "", $line[5] ),
						'var_in_max' => number_format( ( ( 100 / $line[2] ) * $line[3] ) - 100 , 2),
						'var_in_min' => number_format( ( ( 100 / $line[2] ) * $line[4] ) - 100 , 2),
						'day_week' => $dayWeek,
					];

					$arrHistorical[] = $arr;

				}

			}

			return $arrHistorical;

		}

	}

?>