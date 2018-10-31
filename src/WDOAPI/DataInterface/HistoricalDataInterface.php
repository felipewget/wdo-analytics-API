<?php

	namespace WDOAPI\DataInterface;

	Class HistoricalDataInterface {

		public $debug;
		public $conn;

		public function __construct( $debug = false ){

			$this->debug = $debug;

		}

		public function showDataByOscVar( $datas ){

			$days = 0;

			$response = [
				"title" => 'Contador de Nivel das Oscilacoes',
				"days" => 0,
				"data" => [
					'0.05' => 0,
					'0.20' => 0,
					'0.40' => 0,
					'0.60' => 0,
					'0.80' => 0,
					'1.00' => 0,
					'1.20' => 0,
					'1.40' => 0,
					'1.60' => 0,
					'1.80' => 0,
					'2.00' => 0,
					'2.20' => 0,
					'2.40' => 0,
					'2.60' => 0,
					'2.80' => 0,
					'3.00' => 0,
					'3.20' => 0,
					'3.40' => 0,
					'3.60' => 0,
					'3.80' => 0,
					'4.00' => 0,
					'4.20' => 0,
					'4.40' => 0,
					'4.60' => 0,
					'4.80' => 0,
					'5.00' => 0,
					'5.20' => 0,
					'5.40' => 0,
					'5.60' => 0,
					'5.80' => 0,
					'6.00' => 0,
					'6.50' => 0,
					'7.00' => 0,
					'7.50' => 0,
					'8.00' => 0,
					'more' => 0,
				]
			];

			foreach( $datas as $data ){

				$days++;

				if( $data['var'] > -0.05 && $data['var'] < 0.05 ){
					$response['data']['0.05']++;
				} else if( $data['var'] > -0.20 && $data['var'] < 0.20 ){
					$response['data']['0.20']++;
				} else if( $data['var'] > -0.40 && $data['var'] < 0.40 ){
					$response['data']['0.40']++;
				} else if( $data['var'] > -0.60 && $data['var'] < 0.60 ){
					$response['data']['0.60']++;
				} else if( $data['var'] > -0.80 && $data['var'] < 0.80 ){
					$response['data']['0.80']++;
				} else if( $data['var'] > -1.00 && $data['var'] < 1.00 ){
					$response['data']['1.00']++;
				} else if( $data['var'] > -1.20 && $data['var'] < 1.20 ){
					$response['data']['1.20']++;
				} else if( $data['var'] > -1.40 && $data['var'] < 1.40 ){
					$response['data']['1.40']++;
				} else if( $data['var'] > -1.60 && $data['var'] < 1.60 ){
					$response['data']['1.60']++;
				} else if( $data['var'] > -1.80 && $data['var'] < 1.80 ){
					$response['data']['1.80']++;
				} else if( $data['var'] > -2.00 && $data['var'] < 2.00 ){
					$response['data']['2.00']++;
				} else if( $data['var'] > -2.20 && $data['var'] < 2.20 ){
					$response['data']['2.20']++;
				} else if( $data['var'] > -2.40 && $data['var'] < 2.40 ){
					$response['data']['2.40']++;
				} else if( $data['var'] > -2.60 && $data['var'] < 2.60 ){
					$response['data']['2.60']++;
				} else if( $data['var'] > -2.80 && $data['var'] < 2.80 ){
					$response['data']['2.80']++;
				} else if( $data['var'] > -3.00 && $data['var'] < 3.00 ){
					$response['data']['3.00']++;
				} else if( $data['var'] > -3.20 && $data['var'] < 3.20 ){
					$response['data']['3.20']++;
				} else if( $data['var'] > -3.40 && $data['var'] < 3.40 ){
					$response['data']['3.40']++;
				} else if( $data['var'] > -3.60 && $data['var'] < 3.60 ){
					$response['data']['3.60']++;
				} else if( $data['var'] > -3.80 && $data['var'] < 3.80 ){
					$response['data']['3.80']++;
				} else if( $data['var'] > -4.00 && $data['var'] < 4.00 ){
					$response['data']['4.00']++;
				} else if( $data['var'] > -4.20 && $data['var'] < 4.20 ){
					$response['data']['4.20']++;
				} else if( $data['var'] > -4.40 && $data['var'] < 4.40 ){
					$response['data']['4.40']++;
				} else if( $data['var'] > -4.60 && $data['var'] < 4.60 ){
					$response['data']['4.60']++;
				} else if( $data['var'] > -4.80 && $data['var'] < 4.80 ){
					$response['data']['4.80']++;
				} else if( $data['var'] > -5.00 && $data['var'] < 5.00 ){
					$response['data']['5.00']++;
				} else if( $data['var'] > -5.20 && $data['var'] < 5.20 ){
					$response['data']['5.20']++;
				} else if( $data['var'] > -5.40 && $data['var'] < 5.40 ){
					$response['data']['5.40']++;
				} else if( $data['var'] > -5.60 && $data['var'] < 5.60 ){
					$response['data']['5.60']++;
				} else if( $data['var'] > -5.80 && $data['var'] < 5.80 ){
					$response['data']['5.80']++;
				} else if( $data['var'] > -6.00 && $data['var'] < 6.00 ){
					$response['data']['6.00']++;
				} else if( $data['var'] > -6.50 && $data['var'] < 6.50 ){
					$response['data']['6.50']++;
				} else if( $data['var'] > -7.00 && $data['var'] < 7.00 ){
					$response['data']['7.00']++;
				} else if( $data['var'] > -7.50 && $data['var'] < 7.50 ){
					$response['data']['7.50']++;
				} else if( $data['var'] > -8.00 && $data['var'] < 8.00 ){
					$response['data']['8.00']++;
				} else {
					$response['data']['more']++;
				}

			}

			$response['days'] = $days;

			return $response;

		}

		public function showDataByOscPoints( $datas ){

			$days = 0;

			$response = [
				"title" => 'Faixa de pontos entre maxima e minima',
				"days" => 0,
				"data" => [
					'10' => 0,
					'20' => 0,
					'30' => 0,
					'40' => 0,
					'50' => 0,
					'60' => 0,
					'70' => 0,
					'80' => 0,
					'90' => 0,
					'100' => 0,
					'120' => 0,
					'140' => 0,
					'160' => 0,
					'180' => 0,
					'200' => 0,
					'220' => 0,
					'240' => 0,
					'260' => 0,
					'280' => 0,
					'300' => 0,
					'320' => 0,
					'340' => 0,
					'360' => 0,
					'380' => 0,
					'400' => 0,
					'420' => 0,
					'440' => 0,
					'460' => 0,
					'480' => 0,
					'500' => 0,
					'520' => 0,
					'540' => 0,
					'560' => 0,
					'580' => 0,
					'600' => 0,
					'more' => 0,
				]
			];

			foreach( $datas as $data ){

				$days++;

				if( $data['dif_points'] < 10 ){
					$response['data']['10']++;
				} else if( $data['dif_points'] < 20 ){
					$response['data']['20']++;
				} else if( $data['dif_points'] < 30 ){
					$response['data']['30']++;
				} else if( $data['dif_points'] < 40 ){
					$response['data']['40']++;
				} else if( $data['dif_points'] < 50 ){
					$response['data']['50']++;
				} else if( $data['dif_points'] < 60 ){
					$response['data']['60']++;
				} else if( $data['dif_points'] < 70 ){
					$response['data']['70']++;
				} else if( $data['dif_points'] < 80 ){
					$response['data']['80']++;
				} else if( $data['dif_points'] < 90 ){
					$response['data']['90']++;
				} else if( $data['dif_points'] < 100 ){
					$response['data']['100']++;
				} else if( $data['dif_points'] < 120 ){
					$response['data']['120']++;
				} else if( $data['dif_points'] < 140 ){
					$response['data']['140']++;
				} else if( $data['dif_points'] < 160 ){
					$response['data']['160']++;
				} else if( $data['dif_points'] < 180 ){
					$response['data']['180']++;
				} else if( $data['dif_points'] < 200 ){
					$response['data']['200']++;
				} else if( $data['dif_points'] < 220 ){
					$response['data']['220']++;
				} else if( $data['dif_points'] < 240 ){
					$response['data']['240']++;
				} else if( $data['dif_points'] < 260 ){
					$response['data']['260']++;
				} else if( $data['dif_points'] < 280 ){
					$response['data']['280']++;
				} else if( $data['dif_points'] < 300 ){
					$response['data']['300']++;
				} else if( $data['dif_points'] < 320 ){
					$response['data']['320']++;
				} else if( $data['dif_points'] < 340 ){
					$response['data']['340']++;
				} else if( $data['dif_points'] < 360 ){
					$response['data']['360']++;
				} else if( $data['dif_points'] < 380 ){
					$response['data']['380']++;
				} else if( $data['dif_points'] < 400 ){
					$response['data']['400']++;
				} else if( $data['dif_points'] < 420 ){
					$response['data']['420']++;
				} else if( $data['dif_points'] < 440 ){
					$response['data']['440']++;
				} else if( $data['dif_points'] < 460 ){
					$response['data']['460']++;
				} else if( $data['dif_points'] < 480 ){
					$response['data']['480']++;
				} else if( $data['dif_points'] < 500 ){
					$response['data']['500']++;
				} else if( $data['dif_points'] < 520 ){
					$response['data']['520']++;
				} else if( $data['dif_points'] < 540 ){
					$response['data']['540']++;
				} else if( $data['dif_points'] < 580 ){
					$response['data']['580']++;
				} else if( $data['dif_points'] < 600 ){
					$response['data']['600']++;
				} else {
					$response['data']['more']++;
				}

			}

			$response['days'] = $days;

			return $response;

		}

		
	}

?>