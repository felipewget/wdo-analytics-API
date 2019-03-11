<?php

	namespace WDOAPI\Bootstrap;

	use \Exception;

	/**
	 * 	Classe com metodos auxiliares para neuronios da IA e manipular candles
	 *	@package 	WDOAPI\Bootstrap;
	 *	@author 	Fe Oliveira<felipe.wget@gmail.com>
	 *	@version 	1.0.0
	 *	@copyright 	Felipe Rodrigues Oliveira | 2019
	 */
	Class BaseGraphic {


		/**
		 *	Processa arr candles de candles e os agrupa candles por data repeitando horario de operacoes
		 *	@param array  $arrSgbdCandles 				Array de candles
		 *	@param string $startHourOperation<HH:mm:ss> A partir de que horas comecar o dia
		 *	@param string $endHourOperation<HH:mm:ss> 	A partir de que horas terminar o dia
		 *	@return array
		 */
		public function groupCandlesByDay( $arrSgbdCandles, $startHourOperation="07:00:00", $endHourOperation="19:00:00" )
		{


			try {

				$startHourOperation = (int)str_replace( ":", "", $startHourOperation );
				$endHourOperation = (int)str_replace( ":", "", $endHourOperation );

				$arrCandlesGroupedByDay = [];

				foreach( $arrSgbdCandles as $arrSgbdCandle ){

					if( isset( $arrSgbdCandle->date ) ){

						$arrDate = explode(" ", $arrSgbdCandle->date);

						$date = $arrDate[0];
						$hour = (int)str_replace( ":", "", $arrDate[1] );

						if( $hour >= $startHourOperation && $hour <= $endHourOperation ){
							$arrCandlesGroupedByDay[ $date ][] = $arrSgbdCandle;
						}

					}

				}

				return $arrCandlesGroupedByDay;

			} catch( Exception $e ) {

				throw new Exception( $e->getMessage() );

			}

		}


		/**
		 *	Verifica se a segunda taxa e maior ou menor que a primeira taxa passada
		 *
		 *	@param float $primeiraTaxa 	Primeira Taxa a ser verificada
		 *	@param float $segundaTaxa 	Segunda Taxa a ser verificada
		 *	@return array	
		 */
		public function checkTaxaMaiorOuMenor( $primeiraTaxa, $segundaTaxa )
		{

			$response = null;

			if( $primeiraTaxa > $segundaTaxa ){
				
				$response = [
					'posicionamento_abertura'	=> 'menor',
					'op_retracao'	=> 'compra',
					'op_rompimento'	=> 'venda',
				];

			} else if( $primeiraTaxa < $segundaTaxa ){

				$response = [
					'posicionamento_abertura'	=> 'maior',
					'op_retracao'	=> 'venda',
					'op_rompimento'	=> 'compra',
				];

			}

			return $response;

		}


		/**
		 *	Recupera a diferenca entre 2 taxas passadas
		 *
		 *	@param float $fisrtRate 	Primeira Taxa a ser verificada
		 *	@param float $secondRate 	Segunda Taxa a ser verificada
		 *	@return array	
		 */
		public function getRatesDifference( $fisrtRate, $secondRate )
		{

			$response = [
				'type'			=> null,
				'dif_points'	=> 0,
			];

			if( $fisrtRate < $secondRate ){
				
				$response['type'] = 'high';
				$response['dif_points'] = (float)( $secondRate - $fisrtRate );

			} else if( $fisrtRate > $secondRate ){

				$response['type'] = 'low';
				$response['dif_points'] = (float)( $fisrtRate - $secondRate );

			}

			return $response;

		}

		/**
		 *	Adiciona adiciona|remove pontos a uma taxa e retorna
		 *
		 *	@param float $tax 		Taxa a ser verificada
		 *	@param float $points 	Quanto de pontos sera adicionado ou removido
		 *	@param float $sumOrLess	Se vai somar um subtrair pontos a taxa atual
		 *	@param float $openedTax	Taxa de abertura do mercado
		 *	@return array	
		 */
		public function calculateTax( $tax, $points, $sumOrLess, $openedTax )
		{

			$index = strlen( $points ) - 1;

			// Calcula por porcentagem
			if( $points[ $index ] == '%' ){
				
				$nPoints = ($openedTax/100) * str_replace( '%', '', $points );

				if( $sumOrLess == "sum" ){
					return ( $tax + $nPoints );
				} else if( $sumOrLess == "less" ){
					return ( $tax - $nPoints );
				}

			} else {

				// Calcula por pontos

				if( $sumOrLess == "sum" ){
					return ( $tax + $points );
				} else if( $sumOrLess == "less" ){
					return ( $tax - $points );
				}

			}

		}


		/**
		 *	Recupera a variacao(osc)  entre 2 taxas passadas
		 *
		 *	@param float $tax1 	Primeira Taxa a ser verificada
		 *	@param float $tax2 	Segunda Taxa a ser verificada
		 *	@return array	
		 */
		public function getOscBetweenTwoTaxes( $tax1, $tax2 )
		{

			$variation = number_format( ( ( 100 / $tax1 ) * $tax2 ) - 100 , 2 );

			if( $variation < 0 ){
				$variation = $variation * -1;
			}

			return $variation;

		}

	}

?>