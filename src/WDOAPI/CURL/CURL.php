<?php

	namespace WDOAPI\CURL;

	/**
	 * 	Classe com metodos auxiliares para usar CURL em outras classes
	 *	@package 	WDOAPI\CURL;
	 *	@author 	Fe Oliveira<felipe.wget@gmail.com>
	 *	@version 	1.0.0
	 *	@copyright 	Felipe Rodrigues Oliveira | 2019
	 *	@todo 		Estou na duvida se coloco na pasta de bootstrap ou utils... vou deixa-la por aqui pois 
	 *				ainda nao esta sendo usada
	 */
	Class CURL {


		/**
		 *	Acessa um link via POST 
		 *
		 *	@param string 	$link 		Link a ser acessado
		 *	@param array 	$arrParams 	Array de parametros que sao enviados ao acessar o link
		 *	@return string
		 */
		public function postAccess( $link, $arrParams = "" ){

			$fields_string = "";
			$response = "";

			if( count( $arrParams ) > 0 ){

				$fields = $arrParams;

				foreach($fields as $key => $value) { 
					$fields_string .= $key.'='.$value.'&'; 
				}

				rtrim($fields_string, '&');

			}

			$ch = curl_init();

			curl_setopt( $ch, CURLOPT_URL, $link );
			curl_setopt( $ch, CURLOPT_POST, 1 );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $fields_string );

			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

			$response = curl_exec($ch);

			curl_close ($ch);

			return $response;

		}


		/**
		 *	Corta e recupera parte do HTML
		 *
		 *	@param string 	$code 		Codigo HTML
		 *	@param string 	$start 		Comeco do codigo que sera cortado
		 *	@param string 	$last 		Final do codigo que sera cortado
		 *	@return string
		 */
		public function cropHtml( $code, $start, $last ){

			$arrCode = explode( $start, $code );
			if( isset($arrCode[1]) ){

				$arrCode = explode( $last, $arrCode[1] );
				return $arrCode[0];

			} else {
				return "";
			}

		}


		/**
		 *	Corta varios pedacos e recupera parte do HTMLs, percorrendo todos os elementos da pagina
		 *
		 *	@param string 	$code 		Codigo HTML
		 *	@param string 	$start 		Comeco do codigo que sera cortado
		 *	@param string 	$last 		Final do codigo que sera cortado
		 *	@return string
		 */
		public function cropHtmlAndScroll( $code , $start, $last ){

			$arrCode = explode( $start, $code );
			$arrRow = [];

			foreach( $arrCode as $code ){
				$arrRow[] = explode( $last, $code );
			}

			return $arrRow;

		}

	}

?>