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
				'resultado_pontos'					=> 0,
				'count_operacoes'					=> 0,
				'pontos_em_emolumentos'				=> 0,
				'count_buy'							=> 0,
				'count_sell'						=> 0,
				'count_tipos_operacoes' 			=> [
					'gain' 			=> 0,
					'loss' 			=> 0,
					'interrompido' 	=> 0,
					'indefinido' 	=> 0,
				],
				'settings_operations'				=> $this->settingOperations,
				'risk'								=> [
					'max_gain_in_point'	=> 0,
					'max_loss_in_point'	=> 0,
				],
				'operations'						=> $this->historicalOperations,

			];

			$arrAgrupadorOperacoesPorDia 	= [];
			$arrAgrupadorOperacoesPorMes 	= [];
			$resultadoPontos 				= 0;
			$countOperations 				= 0;
			$pontosEmolumentos 				= 0;

			$riskPointsGain = 0;
			$riskPointsLoss = 0;

			$dataDiaAtual = 0;
			$countOperacoesPorDia = 0;

			$dataMesAtual = 0;
			$countOperacoesPorMes = 0;

			foreach( $this->getHistoryOperations() as $operacao ){

				$arrDate = explode( '-', $operacao['metadata']['date'] );

				
				$countOperations++;

				$pontosEmolumentos = $pontosEmolumentos + $operacao["emoluments_in_points"];
				$response['pontos_em_emolumentos'] = $pontosEmolumentos;

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

				// Mais uma operacao no dia
				$countOperacoesPorDia++;

				// Mias um mes na operacao
				$countOperacoesPorMes++;

			}

			$somarItens = function( $armazenador, $valor ){
				return ( $armazenador + $valor );
			};

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

									// Significa que o preco chegou na taxa de stoploss porem, posso ter subido o stop loss
									// para o preco nao voltar, se isso aconteceu, considero um gain
									// LEMBRANDO QUE ESTAMOS NO "IF" DE OPERACOES DE COMPRA

									// Se o StopLoss for maior que a taxa, entao puxei pra cima e o stop loss e e gain
									if( $openedOperation["stop_loss"] >= $openedOperation["taxa"] ){

										// Gain
										// Se for gain, ele pega os pontos do STOP GAIN, entao preciso ajusta-lo para 
										// o preco do stoploss que eu defini
										$this->openOperations[$index]["stop_gain"] = $this->openOperations[$index]["stop_loss"];
										$openedOperation["stop_gain"] 			   = $this->openOperations[$index]["stop_loss"];

										if( $this->closeOperation( "gain", $openedOperation, $currentCandle ) ){
											unset( $this->openOperations[$index] );
										}

									} else {
										
										if( $this->closeOperation( "loss", $openedOperation, $currentCandle ) ){
											unset( $this->openOperations[$index] );
										}

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

									// Significa que o preco chegou na taxa de stoploss porem, posso ter descido o stop loss
									// para o preco nao voltar, se isso aconteceu, considero um gain
									// LEMBRANDO QUE ESTAMOS NO "IF" DE OPERACOES DE VENDA

									// Se o StopLoss for menor que a taxa inicial, entao puxei pra baixo e o stop loss e e gain
									if( $openedOperation["stop_loss"] <= $openedOperation["taxa"] ){

										// Gain
										// Se for gain, ele pega os pontos do STOP GAIN, entao preciso ajusta-lo para 
										// o preco do stoploss que eu defini
										$this->openOperations[$index]["stop_gain"] = $this->openOperations[$index]["stop_loss"];
										$openedOperation["stop_gain"] 			   = $this->openOperations[$index]["stop_loss"];

										if( $this->closeOperation( "gain", $openedOperation, $currentCandle ) ){
											unset( $this->openOperations[$index] );
										}

									} else {

										if( $this->closeOperation( "loss", $openedOperation, $currentCandle ) ){
											unset( $this->openOperations[$index] );
										}

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


					// Verifica se tem que subir o stoploss pra cima da abertura da operacao, pra evitar que
					// o preco volte

					// @internal Talvez tenha saido da operacao antes de checar se o preco pode voltar
					// 			 Importante checkar se ainda existe a operacao no index
					if( isset( $this->openOperations[$index] ) ){
						$this->checkPreventionOfPriveBack( $currentCandle, $openedOperation, $index );
					}


					// /// Verifica Mediana
					// if( $openedOperation['metadata']['prevention_of_price_back']['active'] == true ){

					// 	if( $openedOperation['metadata']['prevention_of_price_back']['leave_the_operations'] === true ){

					// 		// FECHA UMA OPERACAO DE MEDIANA

					// 		if( $openedOperation["compra_ou_venda"] == "compra" ){

					// 			var_dump( $openedOperation['metadata']['prevention_of_price_back']['points_get_out_at'] );

					// 			echo '<pre>';
					// 			var_dump($openedOperation);
					// 			die('finaliza uma mediana de compra');

					// 		} else if( $openedOperation["compra_ou_venda"] == "venda" ){

					// 			var_dump( $openedOperation['metadata']['prevention_of_price_back']['points_get_out_at'] );
					// 			echo '<pre>';
					// 			var_dump($openedOperation);
					// 			die('finaliza uma mediana de venda');

					// 		}

					// 	} else {

					// 		// ABRE UMA MEDIANA

					// 		// Se o numero minimo de candle for maior ou igual ao minimo pra sair da operacao
					// 		// antes do preco voltar
					// 		if( $openedOperation["metadata"]["num_candles_percorridos"] >= $openedOperation['metadata']['prevention_of_price_back']['min_candle'] ){


					// 			// Se for false apenas, ai starta
					// 			if( !$this->openOperations[$index]["metadata"]['prevention_of_price_back']['leave_the_operations'] ){

					// 				if( $openedOperation["compra_ou_venda"] == "compra" ){

					// 					// Se for compra e a taxa cair e o preco - a taxa dor menos ou infual a min
					// 					if( $openedOperation['metadata']['prevention_of_price_back']['points_after_points'] >= $currentCandle->min ){

					// 						// STARTA UMA MEDIANA DE COMPRA
					// 						$this->openOperations[$index]["metadata"]['prevention_of_price_back']['leave_the_operations'] = true;

					// 						// Abre uma Mediana

					// 					}

					// 				} else if( $openedOperation["compra_ou_venda"] == "venda" ){

					// 					// Se for venda e o preco subir
					// 						// Se o preco for menor que o maximo significa que durante um tempo, o preco foi maior que o 
					// 						// preco atual
					// 					if( $openedOperation['metadata']['prevention_of_price_back']['points_after_points'] <= $currentCandle->max ){

					// 						// STARTA UMA MEDIANA DE VENDA
					// 						$this->openOperations[$index]["metadata"]['prevention_of_price_back']['leave_the_operations'] = true;

					// 						// Abre uma Mediana

					// 						// $this->openOperation( 	$candle,
					// 						// 				$checkCandleEmRelaxaoAbertura["op_retracao"], 
					// 						// 				$candle->close,
					// 						// 				$taxStopLoss, 
					// 						// 				$taxStopGain, 
					// 						// 				$operations["range_candle"]["min"], 
					// 						// 				$operations["range_candle"]["max"],
					// 						// 				$operations['prevention_of_price_back']	);



					// 					}

					// 				}

					// 			}

					// 		}

					// 	}

					// }



					

				}

			}

		}


		/**
		 *	Verifica se deve entrar em modo de prevenir que o preco volte e se torne uma operacao negativa
		 *
		 *	@internal 			Quando atinge uma pontuacao, o preco pode voltar e ficar negativo, por isso e 
		 *			  			criado um stop loss no positivo da operacao, para que isso aconteca, e necessario 
		 *			  			alterar o stop loss pro positivo  como, sair da operacao na operacao e tambem e marcar como 
		 *	@param array 		$openedOperation 	Envia detalhes de uma operacao, para verificar se ja foi startado a
		 *								  			prevencao sobre o preco voltar
		 *	@param array<obj> 	$currentCandle		Candle atual no grafico, que deve ser analizado
		 *	@param int 			$index 				Index e um indice do arr de operacoes abertas
		 */
		public function checkPreventionOfPriveBack( $currentCandle, $openedOperation, $index )
		{
			
			if( isset( $openedOperation['metadata']['prevention_of_price_back'] ) ){

				// Verifica se esta ativo a prvencao contra a volta do preco de uma operacao ganha
				if( $openedOperation['metadata']['prevention_of_price_back']['active'] == true ){

					// Se o numero minimo de candle percorridos na operacao aberta for maior
					// ou igual ao minimo pra sair da operacao antes do preco voltar, comeco a considerar prevenir a volta
					if( $openedOperation["metadata"]["num_candles_percorridos"] >= $openedOperation['metadata']['prevention_of_price_back']['min_candle'] ){

						// Se JA nao estiver setado para sair da operacao antes do preco voltar, seta
						if( !$this->openOperations[$index]["metadata"]['prevention_of_price_back']['leave_the_operations'] ){

							switch ( $openedOperation["compra_ou_venda"] ) {

								case 'compra':
									
									// se na COMPRA, a fechamento do candle for A CIMA da taxa para evitar que o preco volte
									// Previne que o preco volte
									if( $currentCandle->close >= $openedOperation['metadata']['prevention_of_price_back']['points_after_points'] ){
										
										// Se o candle fechar numa determinada taxa, sobe o stoploss para cima da taxa de abertura da operacao
										$this->startPreventionOfPriveBack( $index, $this->openOperations[$index]["metadata"]['prevention_of_price_back']['points_get_out_at'] );
										$this->openOperations[$index]["metadata"]['prevention_of_price_back']['leave_the_operations'] = true;
										// Redefine o stop loss para cima do preco

									}

									break;

								case 'venda':

									// se na VENDA, o fechamento do candle for A BAIXO da taxa para evitar que o preco volte
									// Previne que o preco volte
									if( $currentCandle->close <= $openedOperation['metadata']['prevention_of_price_back']['points_after_points'] ){

										// Se o candle fechar numa determinada taxa, sobe o stoploss para cima da taxa de abertura da operacao
										$this->startPreventionOfPriveBack( $index, $this->openOperations[$index]["metadata"]['prevention_of_price_back']['points_get_out_at'] );
										$this->openOperations[$index]["metadata"]['prevention_of_price_back']['leave_the_operations'] = true;
										// Redefine o stop loss para cima do preco

									}

									break;

							}

						}

					}

				}

			}

		}

		/**
		 *	Arrastar Stop Loss pra uma taxa positiva em relaxao ao inicio da operacao
		 *
		 *	@param int 		$index 			Indice do arr com operacoes em andamento apra arrastar o stop loss
		 *	@param float 	$newStopLoss 	Nova taxa de StopLoss
		 */
		public function startPreventionOfPriveBack( $index, $newStopLoss )
		{

			if( $newStopLoss != null ){
				$this->openOperations[$index]["stop_loss"] = $newStopLoss;
			}

			

		}


		/**
		 *	Verifica se deve startar a mediana
		 *
		 *	@param array $openedOperation Envia detalhes de uma operacao, para verificar se ja foi startado alguma
		 *								  mediana ou se esta no range de abrir uma mediana
		 */
		public function checkMedian( $openedOperation )
		{

			/// Se metadata da operacao atual de preven
			if( $openedOperation['metadata']['prevention_of_price_back']['active'] == true ){

			}



		}


		/**
		 *	Inicia a Mediana
		 *
		 *	@internal Quando e criado uma operacao, ela aparece como MEDIANA FALSE, ao criar a mediana, criar uma operacao com
		 *			  MEDIANA como TRUE, e tambem altera o GAIN da operacao principal para a saida da mediana
		 */
		public function startMedian()
		{


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

			$objOperation['emoluments_in_points'] = isset( $objOperation['emoluments_in_points'] ) ? 
																$objOperation['emoluments_in_points'] : 
																0 ;

			switch ( $gainOrLoss ) {

				case null: // Nao conta pois bateu o stoploss e o gain no mesmo candle

					$objOperation["metadata"]["pontos"] = ( 0 - $objOperation['emoluments_in_points'] );
					$objOperation["result"] = null;
					
					break;

				case 'loss': // Stop Loss

					$points = $this->getRatesDifference( $objOperation["taxa"], $objOperation["stop_loss"] );
					// Paga o loss e mais os emolumentos
					$objOperation["metadata"]["pontos"] = "-" . ( $points["dif_points"] + $objOperation['emoluments_in_points'] );
					$objOperation["result"] = 'loss';

					break;

				case 'gain': // Stop Gain

					$points = $this->getRatesDifference( $objOperation["taxa"], $objOperation["stop_gain"] );
					// Paga os emolumentos mas e diluido no gain
					$objOperation["metadata"]["pontos"] = ( $points["dif_points"] - $objOperation['emoluments_in_points'] );
					$objOperation["result"] = 'gain';

					break;

				case 'interrupted': // Interrompido pois alcancou o tempo maximo programado pra operacao

					$objOperation["result"] = 'interrupted';
				
					if( $objOperation["compra_ou_venda"] == "compra" ){


						$points = $this->getRatesDifference( $objOperation["taxa"], $currentCandle->close );

						if( $objOperation["taxa"] > $currentCandle->close ){ // se taxa inicial for maior

							// Perde pontos mais os emolumentos
							$objOperation["metadata"]["pontos"] = "-" . ( $points["dif_points"] + $objOperation['emoluments_in_points'] );

						} else if( $objOperation["taxa"] < $currentCandle->close ){ // Se a taxa inicial for menor

							// Ganha o lucro mas perde os emolumentos
							$objOperation["metadata"]["pontos"] = ( $points["dif_points"] - $objOperation['emoluments_in_points'] );

						} else { // Se for a mesma taxa

							$objOperation["metadata"]["pontos"] = ( 0  - $objOperation['emoluments_in_points'] );

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
										$maxCandles,
										$preventionOfPriceBack = null,
										$pointsInEmoluments = 0 )
		{


			if( $preventionOfPriceBack['active'] === true ){

				$objPreventionOfPriceBack = $preventionOfPriceBack;

			} else {
				$objPreventionOfPriceBack['active'] = false;
			}

			$arrDate = explode( ' ', $candle->date );

			$this->openOperations[] = [
				'compra_ou_venda'		=> $buyOrSell,
				'taxa'					=> $tax,
				'stop_loss'				=> $taxStopLoss,
				'stop_gain'				=> $taxStopGain,
				'min_candles'			=> $minCandles,
				'max_candles'			=> $maxCandles,
				'emoluments_in_points' 	=> $pointsInEmoluments,
				'result'				=> null,
				'metadata'				=> [
					'fechamento_op_forcado' 	=> false,
					'prevention_of_price_back'	=> $objPreventionOfPriceBack,
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