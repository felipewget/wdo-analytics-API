<?php

	namespace WDOAPI\CURL;

	Class CURL {

		public function __construct(){

		}

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

		public function cropHtml( $code, $start, $last ){

			$arrCode = explode( $start, $code );
			if( isset($arrCode[1]) ){

				$arrCode = explode( $last, $arrCode[1] );
				return $arrCode[0];

			} else {
				return "";
			}

		}

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