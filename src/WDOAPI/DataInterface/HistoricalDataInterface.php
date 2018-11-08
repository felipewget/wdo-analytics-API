<?php

	namespace WDOAPI\DataInterface;

	Class HistoricalDataInterface {

		public $days_of_week = [
			1 => 'monday',
			2 => 'tuesday',
			3 => 'wednesday',
			4 => 'thursday',
			5 => 'friday',
			];

		public $debug;
		public $conn;

		public function __construct( $debug = false ){

			$this->debug = $debug;

		}

		////////////






		public function showDataByOscVarMinAndMaxOfDay( $datas ){

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
				],
				"analytical_data" => [
					'0.05' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'0.20' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'0.40' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'0.60' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'0.80' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'1.00' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'1.20' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'1.40' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'1.60' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'1.80' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'2.00' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'2.20' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'2.40' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'2.60' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'2.80' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'3.00' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'3.20' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'3.40' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'3.60' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'3.80' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'4.00' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'4.20' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'4.40' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'4.60' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'4.80' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'5.00' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'5.20' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'5.40' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'5.60' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'5.80' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'6.00' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'6.50' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'7.00' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'7.50' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'8.00' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'more' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
				]
			];

			foreach( $datas as $data ){

				$variacaoMaximaDoDia = 0;
				if( $data['var_in_min'] > $data['var_in_max'] ){
					$variacaoMaximaDoDia = $data['var_in_min'];
				} else {
					$variacaoMaximaDoDia = $data['var_in_max'];
				}

				$days++;

				if( $variacaoMaximaDoDia > -0.05 && $variacaoMaximaDoDia < 0.05 ){
					$response['data']['0.05']++;
					$response['analytical_data']['0.05']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['0.05']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -0.20 && $variacaoMaximaDoDia < 0.20 ){
					$response['data']['0.20']++;
					$response['analytical_data']['0.20']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['0.20']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -0.40 && $variacaoMaximaDoDia < 0.40 ){
					$response['data']['0.40']++;
					$response['analytical_data']['0.40']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['0.40']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -0.60 && $variacaoMaximaDoDia < 0.60 ){
					$response['data']['0.60']++;
					$response['analytical_data']['0.60']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['0.60']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -0.80 && $variacaoMaximaDoDia < 0.80 ){
					$response['data']['0.80']++;
					$response['analytical_data']['0.80']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['0.80']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -1.00 && $variacaoMaximaDoDia < 1.00 ){
					$response['data']['1.00']++;
					$response['analytical_data']['1.00']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['1.00']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -1.20 && $variacaoMaximaDoDia < 1.20 ){
					$response['data']['1.20']++;
					$response['analytical_data']['1.20']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['1.20']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -1.40 && $variacaoMaximaDoDia < 1.40 ){
					$response['data']['1.40']++;
					$response['analytical_data']['1.40']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['1.40']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -1.60 && $variacaoMaximaDoDia < 1.60 ){
					$response['data']['1.60']++;
					$response['analytical_data']['1.60']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['1.60']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -1.80 && $variacaoMaximaDoDia < 1.80 ){
					$response['data']['1.80']++;
					$response['analytical_data']['1.80']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['1.80']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -2.00 && $variacaoMaximaDoDia < 2.00 ){
					$response['data']['2.00']++;
					$response['analytical_data']['2.00']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['2.00']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -2.20 && $variacaoMaximaDoDia < 2.20 ){
					$response['data']['2.20']++;
					$response['analytical_data']['2.20']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['2.20']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -2.40 && $variacaoMaximaDoDia < 2.40 ){
					$response['data']['2.40']++;
					$response['analytical_data']['2.40']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['2.40']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -2.60 && $variacaoMaximaDoDia < 2.60 ){
					$response['data']['2.60']++;
					$response['analytical_data']['2.60']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['2.60']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -2.80 && $variacaoMaximaDoDia < 2.80 ){
					$response['data']['2.80']++;
					$response['analytical_data']['2.80']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['2.80']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -3.00 && $variacaoMaximaDoDia < 3.00 ){
					$response['data']['3.00']++;
					$response['analytical_data']['3.00']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['3.00']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -3.20 && $variacaoMaximaDoDia < 3.20 ){
					$response['data']['3.20']++;
					$response['analytical_data']['3.20']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['3.20']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -3.40 && $variacaoMaximaDoDia < 3.40 ){
					$response['data']['3.40']++;
					$response['analytical_data']['3.40']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['3.40']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -3.60 && $variacaoMaximaDoDia < 3.60 ){
					$response['data']['3.60']++;
					$response['analytical_data']['3.60']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['3.60']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -3.80 && $variacaoMaximaDoDia < 3.80 ){
					$response['data']['3.80']++;
					$response['analytical_data']['3.80']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['3.80']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -4.00 && $variacaoMaximaDoDia < 4.00 ){
					$response['data']['4.00']++;
					$response['analytical_data']['4.00']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['4.00']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -4.20 && $variacaoMaximaDoDia < 4.20 ){
					$response['data']['4.20']++;
					$response['analytical_data']['4.20']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['4.20']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -4.40 && $variacaoMaximaDoDia < 4.40 ){
					$response['data']['4.40']++;
					$response['analytical_data']['4.40']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['4.40']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -4.60 && $variacaoMaximaDoDia < 4.60 ){
					$response['data']['4.60']++;
					$response['analytical_data']['4.60']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['4.60']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -4.80 && $variacaoMaximaDoDia < 4.80 ){
					$response['data']['4.80']++;
					$response['analytical_data']['4.80']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['4.80']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -5.00 && $variacaoMaximaDoDia < 5.00 ){
					$response['data']['5.00']++;
					$response['analytical_data']['5.00']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['5.00']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -5.20 && $variacaoMaximaDoDia < 5.20 ){
					$response['data']['5.20']++;
					$response['analytical_data']['5.20']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['5.20']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -5.40 && $variacaoMaximaDoDia < 5.40 ){
					$response['data']['5.40']++;
					$response['analytical_data']['5.40']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['5.40']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -5.60 && $variacaoMaximaDoDia < 5.60 ){
					$response['data']['5.60']++;
					$response['analytical_data']['5.60']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['5.60']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -5.80 && $variacaoMaximaDoDia < 5.80 ){
					$response['data']['5.80']++;
					$response['analytical_data']['5.80']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['5.80']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -6.00 && $variacaoMaximaDoDia < 6.00 ){
					$response['data']['6.00']++;
					$response['analytical_data']['6.00']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['6.00']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -6.50 && $variacaoMaximaDoDia < 6.50 ){
					$response['data']['6.50']++;
					$response['analytical_data']['6.50']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['6.50']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -7.00 && $variacaoMaximaDoDia < 7.00 ){
					$response['data']['7.00']++;
					$response['analytical_data']['7.00']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['7.00']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -7.50 && $variacaoMaximaDoDia < 7.50 ){
					$response['data']['7.50']++;
					$response['analytical_data']['7.50']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['7.50']['dates'][] = $data;
				} else if( $variacaoMaximaDoDia > -8.00 && $variacaoMaximaDoDia < 8.00 ){
					$response['data']['8.00']++;
					$response['analytical_data']['8.00']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['8.00']['dates'][] = $data;
				} else {
					$response['data']['more']++;
					$response['analytical_data']['more']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['more']['dates'][] = $data;
				}

			}

			$response['days'] = $days;

			return $response;

		}









		///////////

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
				],
				"analytical_data" => [
					'0.05' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'0.20' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'0.40' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'0.60' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'0.80' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'1.00' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'1.20' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'1.40' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'1.60' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'1.80' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'2.00' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'2.20' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'2.40' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'2.60' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'2.80' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'3.00' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'3.20' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'3.40' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'3.60' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'3.80' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'4.00' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'4.20' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'4.40' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'4.60' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'4.80' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'5.00' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'5.20' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'5.40' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'5.60' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'5.80' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'6.00' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'6.50' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'7.00' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'7.50' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'8.00' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'more' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
				]
			];

			foreach( $datas as $data ){

				$days++;

				if( $data['var'] > -0.05 && $data['var'] < 0.05 ){
					$response['data']['0.05']++;
					$response['analytical_data']['0.05']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['0.05']['dates'][] = $data;
				} else if( $data['var'] > -0.20 && $data['var'] < 0.20 ){
					$response['data']['0.20']++;
					$response['analytical_data']['0.20']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['0.20']['dates'][] = $data;
				} else if( $data['var'] > -0.40 && $data['var'] < 0.40 ){
					$response['data']['0.40']++;
					$response['analytical_data']['0.40']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['0.40']['dates'][] = $data;
				} else if( $data['var'] > -0.60 && $data['var'] < 0.60 ){
					$response['data']['0.60']++;
					$response['analytical_data']['0.60']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['0.60']['dates'][] = $data;
				} else if( $data['var'] > -0.80 && $data['var'] < 0.80 ){
					$response['data']['0.80']++;
					$response['analytical_data']['0.80']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['0.80']['dates'][] = $data;
				} else if( $data['var'] > -1.00 && $data['var'] < 1.00 ){
					$response['data']['1.00']++;
					$response['analytical_data']['1.00']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['1.00']['dates'][] = $data;
				} else if( $data['var'] > -1.20 && $data['var'] < 1.20 ){
					$response['data']['1.20']++;
					$response['analytical_data']['1.20']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['1.20']['dates'][] = $data;
				} else if( $data['var'] > -1.40 && $data['var'] < 1.40 ){
					$response['data']['1.40']++;
					$response['analytical_data']['1.40']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['1.40']['dates'][] = $data;
				} else if( $data['var'] > -1.60 && $data['var'] < 1.60 ){
					$response['data']['1.60']++;
					$response['analytical_data']['1.60']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['1.60']['dates'][] = $data;
				} else if( $data['var'] > -1.80 && $data['var'] < 1.80 ){
					$response['data']['1.80']++;
					$response['analytical_data']['1.80']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['1.80']['dates'][] = $data;
				} else if( $data['var'] > -2.00 && $data['var'] < 2.00 ){
					$response['data']['2.00']++;
					$response['analytical_data']['2.00']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['2.00']['dates'][] = $data;
				} else if( $data['var'] > -2.20 && $data['var'] < 2.20 ){
					$response['data']['2.20']++;
					$response['analytical_data']['2.20']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['2.20']['dates'][] = $data;
				} else if( $data['var'] > -2.40 && $data['var'] < 2.40 ){
					$response['data']['2.40']++;
					$response['analytical_data']['2.40']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['2.40']['dates'][] = $data;
				} else if( $data['var'] > -2.60 && $data['var'] < 2.60 ){
					$response['data']['2.60']++;
					$response['analytical_data']['2.60']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['2.60']['dates'][] = $data;
				} else if( $data['var'] > -2.80 && $data['var'] < 2.80 ){
					$response['data']['2.80']++;
					$response['analytical_data']['2.80']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['2.80']['dates'][] = $data;
				} else if( $data['var'] > -3.00 && $data['var'] < 3.00 ){
					$response['data']['3.00']++;
					$response['analytical_data']['3.00']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['3.00']['dates'][] = $data;
				} else if( $data['var'] > -3.20 && $data['var'] < 3.20 ){
					$response['data']['3.20']++;
					$response['analytical_data']['3.20']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['3.20']['dates'][] = $data;
				} else if( $data['var'] > -3.40 && $data['var'] < 3.40 ){
					$response['data']['3.40']++;
					$response['analytical_data']['3.40']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['3.40']['dates'][] = $data;
				} else if( $data['var'] > -3.60 && $data['var'] < 3.60 ){
					$response['data']['3.60']++;
					$response['analytical_data']['3.60']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['3.60']['dates'][] = $data;
				} else if( $data['var'] > -3.80 && $data['var'] < 3.80 ){
					$response['data']['3.80']++;
					$response['analytical_data']['3.80']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['3.80']['dates'][] = $data;
				} else if( $data['var'] > -4.00 && $data['var'] < 4.00 ){
					$response['data']['4.00']++;
					$response['analytical_data']['4.00']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['4.00']['dates'][] = $data;
				} else if( $data['var'] > -4.20 && $data['var'] < 4.20 ){
					$response['data']['4.20']++;
					$response['analytical_data']['4.20']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['4.20']['dates'][] = $data;
				} else if( $data['var'] > -4.40 && $data['var'] < 4.40 ){
					$response['data']['4.40']++;
					$response['analytical_data']['4.40']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['4.40']['dates'][] = $data;
				} else if( $data['var'] > -4.60 && $data['var'] < 4.60 ){
					$response['data']['4.60']++;
					$response['analytical_data']['4.60']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['4.60']['dates'][] = $data;
				} else if( $data['var'] > -4.80 && $data['var'] < 4.80 ){
					$response['data']['4.80']++;
					$response['analytical_data']['4.80']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['4.80']['dates'][] = $data;
				} else if( $data['var'] > -5.00 && $data['var'] < 5.00 ){
					$response['data']['5.00']++;
					$response['analytical_data']['5.00']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['5.00']['dates'][] = $data;
				} else if( $data['var'] > -5.20 && $data['var'] < 5.20 ){
					$response['data']['5.20']++;
					$response['analytical_data']['5.20']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['5.20']['dates'][] = $data;
				} else if( $data['var'] > -5.40 && $data['var'] < 5.40 ){
					$response['data']['5.40']++;
					$response['analytical_data']['5.40']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['5.40']['dates'][] = $data;
				} else if( $data['var'] > -5.60 && $data['var'] < 5.60 ){
					$response['data']['5.60']++;
					$response['analytical_data']['5.60']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['5.60']['dates'][] = $data;
				} else if( $data['var'] > -5.80 && $data['var'] < 5.80 ){
					$response['data']['5.80']++;
					$response['analytical_data']['5.80']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['5.80']['dates'][] = $data;
				} else if( $data['var'] > -6.00 && $data['var'] < 6.00 ){
					$response['data']['6.00']++;
					$response['analytical_data']['6.00']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['6.00']['dates'][] = $data;
				} else if( $data['var'] > -6.50 && $data['var'] < 6.50 ){
					$response['data']['6.50']++;
					$response['analytical_data']['6.50']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['6.50']['dates'][] = $data;
				} else if( $data['var'] > -7.00 && $data['var'] < 7.00 ){
					$response['data']['7.00']++;
					$response['analytical_data']['7.00']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['7.00']['dates'][] = $data;
				} else if( $data['var'] > -7.50 && $data['var'] < 7.50 ){
					$response['data']['7.50']++;
					$response['analytical_data']['7.50']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['7.50']['dates'][] = $data;
				} else if( $data['var'] > -8.00 && $data['var'] < 8.00 ){
					$response['data']['8.00']++;
					$response['analytical_data']['8.00']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['8.00']['dates'][] = $data;
				} else {
					$response['data']['more']++;
					$response['analytical_data']['more']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['more']['dates'][] = $data;
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
				],
				"analytical_data" => [
					'10' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'20' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'30' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'40' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'50' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'60' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'70' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'80' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'90' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'100' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'120' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'140' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'160' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'180' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'200' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'220' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'240' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'260' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'280' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'300' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'320' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'340' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'360' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'380' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'400' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'420' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'440' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'460' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'480' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'500' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'520' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'540' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'560' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'580' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'600' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
					'more' => [
						"data_day_week" => [
							'monday' => 0, // Seg
							'tuesday' => 0, // Ter
							'wednesday' => 0, // Qua
							'thursday' => 0, // Qui
							'friday' => 0, // Sex
						],
						"dates" => [],
					],
				]
			];

			foreach( $datas as $data ){

				$days++;

				if( $data['dif_points'] < 10 ){
					$response['data']['10']++;
					$response['analytical_data']['10']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['10']['dates'][] = $data;
				} else if( $data['dif_points'] < 20 ){
					$response['data']['20']++;
					$response['analytical_data']['20']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['20']['dates'][] = $data;
				} else if( $data['dif_points'] < 30 ){
					$response['data']['30']++;
					$response['analytical_data']['30']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['30']['dates'][] = $data;
				} else if( $data['dif_points'] < 40 ){
					$response['data']['40']++;
					$response['analytical_data']['40']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['40']['dates'][] = $data;
				} else if( $data['dif_points'] < 50 ){
					$response['data']['50']++;
					$response['analytical_data']['50']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['50']['dates'][] = $data;
				} else if( $data['dif_points'] < 60 ){
					$response['data']['60']++;
					$response['analytical_data']['60']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['60']['dates'][] = $data;
				} else if( $data['dif_points'] < 70 ){
					$response['data']['70']++;
					$response['analytical_data']['70']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['70']['dates'][] = $data;
				} else if( $data['dif_points'] < 80 ){
					$response['data']['80']++;
					$response['analytical_data']['80']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['80']['dates'][] = $data;
				} else if( $data['dif_points'] < 90 ){
					$response['data']['90']++;
					$response['analytical_data']['90']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['90']['dates'][] = $data;
				} else if( $data['dif_points'] < 100 ){
					$response['data']['100']++;
					$response['analytical_data']['100']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['100']['dates'][] = $data;
				} else if( $data['dif_points'] < 120 ){
					$response['data']['120']++;
					$response['analytical_data']['120']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['120']['dates'][] = $data;
				} else if( $data['dif_points'] < 140 ){
					$response['data']['140']++;
					$response['analytical_data']['140']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['140']['dates'][] = $data;
				} else if( $data['dif_points'] < 160 ){
					$response['data']['160']++;
					$response['analytical_data']['160']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['160']['dates'][] = $data;
				} else if( $data['dif_points'] < 180 ){
					$response['data']['180']++;
					$response['analytical_data']['180']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['180']['dates'][] = $data;
				} else if( $data['dif_points'] < 200 ){
					$response['data']['200']++;
					$response['analytical_data']['200']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['200']['dates'][] = $data;
				} else if( $data['dif_points'] < 220 ){
					$response['data']['220']++;
					$response['analytical_data']['220']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['220']['dates'][] = $data;
				} else if( $data['dif_points'] < 240 ){
					$response['data']['240']++;
					$response['analytical_data']['240']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['240']['dates'][] = $data;
				} else if( $data['dif_points'] < 260 ){
					$response['data']['260']++;
					$response['analytical_data']['260']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['260']['dates'][] = $data;
				} else if( $data['dif_points'] < 280 ){
					$response['data']['280']++;
					$response['analytical_data']['280']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['280']['dates'][] = $data;
				} else if( $data['dif_points'] < 300 ){
					$response['data']['300']++;
					$response['analytical_data']['300']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['300']['dates'][] = $data;
				} else if( $data['dif_points'] < 320 ){
					$response['data']['320']++;
					$response['analytical_data']['320']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['320']['dates'][] = $data;
				} else if( $data['dif_points'] < 340 ){
					$response['data']['340']++;
					$response['analytical_data']['340']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['340']['dates'][] = $data;
				} else if( $data['dif_points'] < 360 ){
					$response['data']['360']++;
					$response['analytical_data']['360']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['360']['dates'][] = $data;
				} else if( $data['dif_points'] < 380 ){
					$response['data']['380']++;
					$response['analytical_data']['380']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['380']['dates'][] = $data;
				} else if( $data['dif_points'] < 400 ){
					$response['data']['400']++;
					$response['analytical_data']['400']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['400']['dates'][] = $data;
				} else if( $data['dif_points'] < 420 ){
					$response['data']['420']++;
					$response['analytical_data']['420']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['420']['dates'][] = $data;
				} else if( $data['dif_points'] < 440 ){
					$response['data']['440']++;
					$response['analytical_data']['440']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['440']['dates'][] = $data;
				} else if( $data['dif_points'] < 460 ){
					$response['data']['460']++;
					$response['analytical_data']['460']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['460']['dates'][] = $data;
				} else if( $data['dif_points'] < 480 ){
					$response['data']['480']++;
					$response['analytical_data']['480']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['480']['dates'][] = $data;
				} else if( $data['dif_points'] < 500 ){
					$response['data']['500']++;
					$response['analytical_data']['500']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['500']['dates'][] = $data;
				} else if( $data['dif_points'] < 520 ){
					$response['data']['520']++;
					$response['analytical_data']['520']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['520']['dates'][] = $data;
				} else if( $data['dif_points'] < 540 ){
					$response['data']['540']++;
					$response['analytical_data']['540']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['540']['dates'][] = $data;
				} else if( $data['dif_points'] < 580 ){
					$response['data']['580']++;
					$response['analytical_data']['580']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['580']['dates'][] = $data;
				} else if( $data['dif_points'] < 600 ){
					$response['data']['600']++;
					$response['analytical_data']['600']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['600']['dates'][] = $data;
				} else {
					$response['data']['more']++;
					$response['analytical_data']['more']['data_day_week'][ $this->days_of_week[ $data['day_week'] ] ]++;
					$response['analytical_data']['more']['dates'][] = $data;
				}

			}

			$response['days'] = $days;

			return $response;

		}

		public function showDataByTypesRepeat( $datas ){

			$days = 0;
			$count = 0;
			$auxType = "n.d.a";

			$response = [
				"title" => 'Vezes seguidas que um tipo de mercado se repete',
				"days" => 0,
				"data" => [
					'1' => 0,
					'2' => 0,
					'3' => 0,
					'4' => 0,
					'5' => 0,
					'6' => 0,
					'7' => 0,
					'8' => 0,
					'9' => 0,
					'10' => 0,
					'11' => 0,
					'12' => 0,
					'13' => 0,
					'14' => 0,
					'15' => 0,
					'16' => 0,
					'17' => 0,
					'more' => 0,
				],
				"analytical_data" => [
					'1' => [
						"periods_days" => []
					],
					'2' => [
						"periods_days" => []
					],
					'3' => [
						"periods_days" => []
					],
					'4' => [
						"periods_days" => []
					],
					'5' => [
						"periods_days" => []
					],
					'6' => [
						"periods_days" => []
					],
					'7' => [
						"periods_days" => []
					],
					'8' => [
						"periods_days" => []
					],
					'9' => [
						"periods_days" => []
					],
					'10' => [
						"periods_days" => []
					],
					'11' => [
						"periods_days" => []
					],
					'12' => [
						"periods_days" => []
					],
					'13' => [
						"periods_days" => []
					],
					'14' => [
						"periods_days" => []
					],
					'15' => [
						"periods_days" => []
					],
					'16' => [
						"periods_days" => []
					],
					'17' => [
						"periods_days" => []
					],
					'more' => [
						"periods_days" => []
					],
				]
			];

			$arrPeriodDays = [];

			foreach( $datas as $data ){

				// @TODO <-- PRA DEBUG
				// echo $data['type'] . ' --- ' . $data['date'].'<br />'; 


				if( $auxType == "n.d.a" ){
					$auxType = $data["type"];
					$arrPeriodDays[] = $data;
				} else {

					if( $auxType != $data["type"] ){

						if( $count < 17){

							$index = $count + 1;

							// 1 == 1 dia de tendencia e mudou
							$response["data"][$index]++;
							$response['analytical_data'][$index]['periods_days'][] = $arrPeriodDays;
							
							$arrPeriodDays = [];

						} else {

							$response["data"]["more"]++;
							$response['analytical_data']["more"]['periods_days'][] = $arrPeriodDays;
							
							$arrPeriodDays = [];

						}

						$count = 0;
						$auxType = $data["type"];
						$arrPeriodDays[] = $data;

					} else {

						$arrPeriodDays[] = $data;
						$count++;

					}

				}

				$days++;

			}

			$response['days'] = $days;

			return $response;

		}

		
	}

?>