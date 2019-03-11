<?php

	namespace WDOAPI\Services\Migrates;

	use \WDOAPI\Models\IntraDayDAO;
	use \WDOAPI\Bootstrap\MetatraderFiles;
	use \Exception;

	Class IntraDayMigrate extends MetatraderFiles {

		public function migrateTable( $dirFile , $truncate = false )
		{

			try {

				set_time_limit( 60 * 50 ); // 5 minutos no maximo

				$arrFromCSV = $this->readFileCSV( $dirFile, $separator = "," );
				$arrInsert = $this->intradayProcessCSVFile( $arrFromCSV );

				$modelIntraDay = new IntraDayDAO();

				if( $truncate ){
					$modelIntraDay->truncate();
				}

				foreach( $arrInsert as $indice => $arr ){

					$objInsert = new \stdClass();
					$objInsert->date 			= $arr['date'];
					$objInsert->open 			= $arr['opened'];
					$objInsert->close 			= $arr['closed'];
					$objInsert->max 			= $arr['max'];
					$objInsert->min 			= $arr['min'];
					$objInsert->type 			= $arr['type'];
					$objInsert->dif_points 		= $arr['var_dif_points'];
					$objInsert->var 			= $arr['var'];
					$objInsert->var_in_max 		= $arr['var_in_max'];
					$objInsert->var_in_min 		= $arr['var_in_min'];
					$objInsert->day_week 		= $arr['day_week'];
					$objInsert->volume 			= $arr['volume'];
					$objInsert->var_opened_day	= $arr['var_opened_day'];
					
					$modelIntraDay->save( $objInsert );

				}

				return [
					'success'	=> true,
				];

			} catch( Exception $e ) {

				throw new Exception( $e->getMessage() );

			}

		}

	}

?>