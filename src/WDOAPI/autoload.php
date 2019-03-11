<?php

	include('Bootstrap/BaseGraphic.php');
	include('Bootstrap/Operations.php');
	
	include('Services/GraphicAnalysisNeurons/CandleOsc.php');
	include('Services/GraphicAnalysisNeurons/NivelOsc.php');
	include('Services/GraphicAnalysisNeurons/TiposDeCandlesRepetidos.php');
	include('Services/GraphicAnalysisNeurons/TiposDeTendenciaRepetidas.php');
	include('Services/GraphicAnalysisNeurons/GapAberturaOsc.php');

	include('Services/BackTest/BackTestOperations.php');

	include('Services/Train/Train.php');

	include('Config/Settings.php');
	include('Bootstrap/MySQL.php');
	include('Bootstrap/MetatraderFiles.php');
	
	include('Services/Migrates/HistoricalDataMigrate.php');
	include('Services/Migrates/IntraDayMigrate.php');	

	include('Models/HistoricalDataDAO.php');
	include('Models/IntraDayDAO.php');

	include('CURL/CURL.php');
	include('CURL/Advfn.php');

	include('WDOAPI.php');	

?>