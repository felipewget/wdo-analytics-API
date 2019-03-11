<?php

	namespace WDOAPI\Bootstrap;

	use \Exception;
	use \WDOAPI\Bootstrap\BaseGraphic;

	/**
	 * 	Classe com metodos auxiliares para gerenciar operacoes simuladas em backtests
	 *	@package 	WDOAPI\Bootstrap;
	 *	@author 	Fe Oliveira<felipe.wget@gmail.com>
	 *	@version 	1.0.0
	 *	@copyright 	Felipe Rodrigues Oliveira | 2019
	 */
	Class Operations extends BaseGraphic {

		public $openOperations = [];
		public $historicalOperations = [];
		public $resumeOfOperations = [];

		/**
		 *	Verifica se ha alguma operacao aberta
		 *
		 *	@return bool
		 */
		public function checkOpenedPerations(){

			if( count($this->openOperations) > 0 ){
				return true;
			} else {
				return false;
			}

		}

		/**
		 *	Recupera o historico de operacoes uma vez criado
		 *
		 *	@return array
		 */
		public function getHistoryOperations()
		{

			return $this->historicalOperations;

		}

		/**
		 *	Cria um resumo de facil leitura baseano no historico de operacoes
		 */
		public function createResumeOperations()
		{

			$response = [
				'resultado_pontos'				=> 0,
				'count_operacoes'				=> 0,
				'count_buy'						=> 0,
				'count_sell'					=> 0,
				'count_tipos_operacoes' 		=> [
					'gain' 			=> 0,
					'loss' 			=> 0,
					'interrompido' 	=> 0,
					'indefinido' 	=> 0,
				],
				'settings_operations'			=> $this->settingOperations,
				'risk'							=> [
					'max_gain_in_point'	=> 0,
					'max_loss_in_point'	=> 0,
				],
				'operations'					=> $this->historicalOperations,

			];

			$resultadoPontos = 0;
			$countOperations = 0;

			$riskPointsGain = 0;
			$riskPointsLoss = 0;

			foreach( $this->getHistoryOperations() as $operacao ){

				$countOperations++;

				// Incremento o contador da categoria da operacao
				switch ( $operacao["result"] ) {

					case 'gain':

						$response['count_tipos_operacoes']["gain"] = $response['count_tipos_operacoes']["gain"] + 1;
						
						break;

					case 'loss':

						$response['count_tipos_operacoes']["loss"] = $response['count_tipos_operacoes']["loss"] + 1;
						
						break;

					case 'interrupted':

						$response['count_tipos_operacoes']["interrompido"] = $response['count_tipos_operacoes']["interrompido"] + 1;
						
						break;

					case null:

						$response['count_tipos_operacoes']["indefinido"] = $response['count_tipos_operacoes']["indefinido"] + 1;
						
						break;
					
				}

				// Tipo e operacao ( compra|venda )
				switch ( $operacao["compra_ou_venda"] ) {
					
					case 'compra':
						$response['count_buy'] = $response['count_buy'] + 1;
						break;

					case 'venda':
						$response['count_sell'] = $response['count_sell'] + 1;
						break;
					
				}

				$resultadoPontos = $resultadoPontos + (float)$operacao["metadata"]["pontos"];

				if( $resultadoPontos > $riskPointsGain ){
					$riskPointsGain = $resultadoPontos;

				}

				if( $resultadoPontos < $riskPointsLoss ){
					$riskPointsLoss = $resultadoPontos;
				}

			}

			$response['risk']['max_gain_in_point'] = $riskPointsGain;
			$response['risk']['max_loss_in_point'] = $riskPointsLoss;

			$response['count_operacoes'] = $countOperations; 
			$response['resultado_pontos'] = $resultadoPontos;

			return $response;

		}


		/**
		 *	Percorre as operacoes abertas e processa baseado nas taxas se foi gain, loss e atualiza as mesmas
		 *
		 *	@param object $currentCandle Candle atual
		 */
		public function checkOperactions( $currentCandle, $forceCloseAll=false, $observacao="" )
		{

			// $currentCandle
			if( count( $this->openOperations ) > 0 ){

				foreach( $this->openOperations as $index => $openedOperation ){

					$numCandlesPercorridos = $openedOperation["metadata"]["num_candles_percorridos"] + 1;
					$this->openOperations[$index]["metadata"]["num_candles_percorridos"] = $numCandlesPercorridos;

					if( $forceCloseAll ){

						// Forca a saida de todas as operacoes, por exemplo, saida no final do dia
						$observation = "Forca a saida de todas as operacoes";
						if( $this->closeOperation( "interrupted", $openedOperation, $currentCandle, $observation ) ){
							unset( $this->openOperations[$index] );
						}

					} else {

						// Se estiver entre o numero minimo de candles candles
						
						if(	$numCandlesPercorridos >= $openedOperation["min_candles"] &&
							$numCandlesPercorridos <= $openedOperation["max_candles"] 
							){

							if( $openedOperation["compra_ou_venda"] == "compra" ){

								if(	$currentCandle->min <= $openedOperation["stop_loss"] && // Se stop loss for menor que a minima
									$currentCandle->max > $openedOperation["stop_gain"] // Stop gain for maior que a maxima
									) {

									// Operacao indefinida pois o msm candle bateu o stoploss e stopgain
									$observation = "Operacao indefinida pois o msm candle bateu o stoploss e stopgain";
									if( $this->closeOperation( null, $openedOperation, $currentCandle, $observation ) ){
										unset( $this->openOperations[$index] );
									}

								} else if( $currentCandle->min <= $openedOperation["stop_loss"] ){

									if( $this->closeOperation( "loss", $openedOperation, $currentCandle ) ){
										unset( $this->openOperations[$index] );
									}

								} else if( $currentCandle->max > $openedOperation["stop_gain"] ) {

									if( $this->closeOperation( "gain", $openedOperation, $currentCandle ) ){
										unset( $this->openOperations[$index] );
									}

								}

							} else if( $openedOperation["compra_ou_venda"] == "venda" ){

								if(	$currentCandle->max >= $openedOperation["stop_loss"] && // Se stop loss for menor que a max
									$currentCandle->min < $openedOperation["stop_gain"] // Stop gain for menor que a minima
									) {
									// Operacao indefinida pois o msm candle bateu o stoploss e stopgain
									
									$observation = "Operacao indefinida pois o msm candle bateu o stoploss e stopgain";
									if( $this->closeOperation( null, $openedOperation, $currentCandle, $observation ) ){
										unset( $this->openOperations[$index] );
									}

								} else if( $currentCandle->max >= $openedOperation["stop_loss"] ){
									
									if( $this->closeOperation( "loss", $openedOperation, $currentCandle ) ){
										unset( $this->openOperations[$index] );
									}

								} else if( $currentCandle->min < $openedOperation["stop_gain"] ) {
									
									if( $this->closeOperation( "gain", $openedOperation, $currentCandle ) ){
										unset( $this->openOperations[$index] );
									}

								}

							}

						} else if( $numCandlesPercorridos >= $openedOperation["max_candles"] ){

							// Se tiver maior do que o numero maximo de candles, forca a saida
							$observation = "Forca saida pois o tempo maximo previsto(max de candles) foi atingido";
							if( $this->closeOperation( "interrupted", $openedOperation, $currentCandle, $observation ) ){
								unset( $this->openOperations[$index] );
							}

						}

					}

				}

			}

		}


		/**
		 *	Fecha uma Operacao
		 *
		 *	@todo Alem das observacoes que podem ser adicionadas antes, adiciona algumas observacoes padroes, pra ajudar a ler o resumo da operacao
		 *	@todo precisa dados de loss ou gain, pontos, observacao
		 * 	@todo adiciona ao historico e tira do arr de operacoes
		 *	@return bool
		 */
		public function closeOperation( $gainOrLoss, $objOperation, $currentCandle, $freeObservation = null )
		{

			$response = true;

			$arrDate = explode( " ", $currentCandle->date );
			$objOperation["metadata"]["finalizado_em"] = $arrDate[1];
			$objOperation["metadata"]["candles"]["fechamento_operacao"] = $currentCandle;

			switch ( $gainOrLoss ) {

				case null: // Nao conta pois bateu o stoploss e o gain no mesmo candle

					$objOperation["metadata"]["pontos"] = 0;
					$objOperation["result"] = null;
					
					break;

				case 'loss': // Stop Loss

					$points = $this->getRatesDifference( $objOperation["taxa"], $objOperation["stop_loss"] );
					$objOperation["metadata"]["pontos"] = "-" . $points["dif_points"];
					$objOperation["result"] = 'loss';

					break;

				case 'gain': // Stop Gain

					$points = $this->getRatesDifference( $objOperation["taxa"], $objOperation["stop_gain"] );
					$objOperation["metadata"]["pontos"] = $points["dif_points"];
					$objOperation["result"] = 'gain';

					break;

				case 'interrupted': // Interrompido pois alcancou o tempo maximo programado pra operacao

					$objOperation["result"] = 'interrupted';
				
					if( $objOperation["compra_ou_venda"] == "compra" ){


						$points = $this->getRatesDifference( $objOperation["taxa"], $currentCandle->close );

						if( $objOperation["taxa"] > $currentCandle->close ){ // se taxa inicial for maior

							$objOperation["metadata"]["pontos"] = "-" . $points["dif_points"];

						} else if( $objOperation["taxa"] < $currentCandle->close ){ // Se a taxa inicial for menor

							$objOperation["metadata"]["pontos"] = $points["dif_points"];

						} else { // Se for a mesma taxa

							$objOperation["metadata"]["pontos"] = 0;

						}


					} else if( $objOperation["compra_ou_venda"] == "venda" ) {


						$points = $this->getRatesDifference( $objOperation["taxa"], $currentCandle->close );

						if( $objOperation["taxa"] > $currentCandle->close ){ // se taxa inicial for maior

							$objOperation["metadata"]["pontos"] = $points["dif_points"];

						} else if( $objOperation["taxa"] < $currentCandle->close ){ // Se a taxa inicial for menor

							$objOperation["metadata"]["pontos"] = "-" . $points["dif_points"];

						} else { // Se for a mesma taxa

							$objOperation["metadata"]["pontos"] = 0;

						}


					}

					break;

			}


			$this->historicalOperations[] = $objOperation;

			return $response;

		}


		/**
		 *	Abre uma operacao
		 *
		 *	@param object 	  $candle 		Obj de um candle
		 *	@param string 	  $buyOrSell 	String que informa se a operacao e compra ou venda String: compra|venda
		 *	@param double|int $tax 			Taxa em que entrou na operacao
		 *	@param double|int $taxStopLoss 	Taxa para Stop Loss
		 *	@param double|int $taxStopGain 	Taxa para Stop Gain
		 *	@param int 		  $minCandles 	Numero de candles corridos minimo para sair da operacao
		 *	@param int 		  $maxCandles 	Numero de candles corridos maximo para sair da operacao
		 *
		 *	@todo Adicionar parametros de emolumentos
		 *	@todo Adicionar parametros de parcial e mediana
		 */
		public function openOperation( 	$candle,
										$buyOrSell, 
										$tax, 
										$taxStopLoss, 
										$taxStopGain, 
										$minCandles, 
										$maxCandles )
		{

			$arrDate = explode( ' ', $candle->date );

			$this->openOperations[] = [
				'compra_ou_venda'	=> $buyOrSell,
				'taxa'				=> $tax,
				'stop_loss'			=> $taxStopLoss,
				'stop_gain'			=> $taxStopGain,
				'min_candles'		=> $minCandles,
				'max_candles'		=> $maxCandles,
				'result'			=> null,
				'metadata'			=> [
					'fechamento_op_forcado' 	=> false,
					'num_candles_percorridos' 	=> 0,
					'max_tax' 					=> $tax,
					'min_tax' 					=> $tax,
					'date'						=> $arrDate[0],
					'iniciado_em'				=> $arrDate[1],
					'finalizado_em'				=> null,
					'pontos'					=> null,
					'candles'					=> [
						'abertura_operacao'			=> $candle,
						'fechamento_operacao'		=> null,
					],
					'observacoes'				=> [],
				]
			];
			
		}

	}

?>