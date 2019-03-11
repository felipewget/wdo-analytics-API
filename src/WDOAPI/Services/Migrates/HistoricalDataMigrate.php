<?php

	namespace WDOAPI\Services\Migrates;

	use \WDOAPI\Models\HistoricalDataDAO;
	use \WDOAPI\Bootstrap\MetatraderFiles;
	use \Exception;

	Class HistoricalDataMigrate extends MetatraderFiles {

		public function migrateTable( $dirFile , $truncate = false )
		{

			try {

				$arrFromCSV = $this->readFileCSV( $dirFile, $separator = "," );
				$arrInsert = $this->historicalDataProcessCSVFile( $arrFromCSV );

				$modelHistoricalData = new HistoricalDataDAO();

				if( $truncate ){
					$modelHistoricalData->truncate();
				}

				foreach( $arrInsert as $indice => $arr ){

					$objInsert = new \stdClass();
					$objInsert->date 		= $arr['date'];
					$objInsert->open 		= $arr['opened'];
					$objInsert->close 		= $arr['closed'];
					$objInsert->max 		= $arr['max'];
					$objInsert->min 		= $arr['min'];
					$objInsert->type 		= $arr['type'];
					$objInsert->dif_points 	= $arr['var_dif_points'];
					$objInsert->var 		= $arr['var'];
					$objInsert->var_in_max 	= $arr['var_in_max'];
					$objInsert->var_in_min 	= $arr['var_in_min'];
					$objInsert->day_week 	= $arr['day_week'];
					$objInsert->volume 		= $arr['volume'];
					
					$modelHistoricalData->save( $objInsert );

				}

				return true;

			} catch( Exception $e ) {

				throw new Exception( $e->getMessage() );

			}
			
		}


	}

?>