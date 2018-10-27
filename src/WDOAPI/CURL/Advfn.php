<?php

	namespace WDOAPI\CURL;

	Class Advfn extends CURL {

		public $month = [
			'Jan' => '01',
			'Fev' => '02',
			'Mar' => '03',
			'Apr' => '04',
			'Mai' => '05',
			'Jun' => '06',
			'Jul' => '07',
			'Aug' => '08',
			'Set' => '09',
			'Out' => '10',
			'Nov' => '11',
			'Dec' => '12',
		];

		public function __construct(){

		}

		public function getRates( $contrato, $dateInit, $dateEnd ){

			$link = "https://br.advfn.com/bolsa-de-valores/bmf/" . $contrato . "/historico/mais-dados-historicos";

			$fields = [
				'Date1' => implode( '/', array_reverse( explode('-', $dateInit) ) ), // '01/02/16',
				'Date2' => implode( '/', array_reverse( explode('-', $dateEnd) ) ), // '28/02/16',
			];

			$html = $this->postAccess( $link, $fields );
			$rates = $this->processRates( $html );			

			return ($rates);

		}

		private function processRates( $html ){

			$table = $this->cropHtml( $html, '<table class="histo-results">', '</table' );
			$arrRows = $this->cropHtmlAndScroll( $table, '<tr class="result">', '</tr>' );

			unset( $arrRows[0] );

			$arrRates = [];

			foreach( $arrRows as $row ){

				try {

					$row[0] = str_replace( ' class="Numeric"', '', $row[0] );

					$rate = $this->cropHtmlAndScroll( $row[0], '<td>', '</td>' );
					$rate[3][1] = str_replace( '<td class="Numeric PriceTextUp">', '', $rate[3][1] );
					$rate[3][1] = str_replace( '	', '', $rate[3][1] );
					$rate[3][1] = str_replace( array("\n", "\r") , '', $rate[3][1] );
					$rate[3][1] = str_replace( ',', '.', $rate[3][1] );
					$rate[3][2] = str_replace( '<td class="Numeric PriceTextUp">', '', $rate[3][2] );
					$rate[3][2] = str_replace( '<td class="Numeric PriceTextDown">', '', $rate[3][2] );
					$rate[3][2] = str_replace( '<td class="Numeric ">', '', $rate[3][2] );
					$rate[3][2] = str_replace( '%', '', $rate[3][2] );
					$rate[3][2] = str_replace( ',', '.', $rate[3][2] );

					if( (Float)$rate[3][2] > 0 ){
						$typeMarket = 'high';
					} else if( (Float)$rate[3][2] < 0 ){
						$typeMarket = 'low';
					} else {
						$typeMarket = 'null';
					}

					$arrRates[] = [
						'date' => $rate[1][0],
						'opened' => $rate[2][0],
						'closed' => $rate[3][0],
						'min' => $rate[4][0],
						'max' => $rate[5][0],
						'var' => $rate[3][1],
						'var_percent' => number_format( $rate[3][2] , 2),
						'vol' => trim( $rate[6][0] ),
						'type' => $typeMarket,
					];

				} catch ( Exception $e ){
					// $e->getMessage();
				}
				

			}

			return $arrRates;

		}

	}

?>