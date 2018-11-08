<?php

	ini_set('display_errors', 1);
	
	include('../../src/WDOAPI/autoload.php');

	// $days = 300;
	$days = 500;
	// $days = 40;
	$oscMinima = 1;
	$pontuacaoMinima = 0;

	$numeroMinimoDeCandlesAposTaxaDeAbertura = 5; // Minimo de candles para comecar a ver se voltou pra taxa em um "fechamento de candle" ou e esta vencendo a retracao
	$numeroMaximoDeCandlesAposTaxaDeAbertura = 20; // Maximo de candles para comecar a ver se voltou pra taxa em um "fechamento de candle" ou e esta vencendo a retracao

	$WDOAPI = new WDOAPI\WDOAPI( true );

	// Dados para grafico de osc | Contador de Nivel das Oscilacoes por Niveis
	$data = $WDOAPI->mainCandlesOfDayThatHaveAPullbackAfterSomePeriod(  $days, 
																		"", 
																		$numeroMinimoDeCandlesAposTaxaDeAbertura, 
																		$numeroMaximoDeCandlesAposTaxaDeAbertura, 
																		$oscMinima,
																		$pontuacaoMinima
																		
																		);

	$arrLabel = [];
	$arrValuesPullback = [];
	$arrValuesWidthoutPullback = [];
	$numberOfOperations = [];

	foreach( $data['retraction_by_candles'] as $key => $value ){

		$arrLabel[] = $key;

		$arrValuesPullback[] = $value;
		$arrValuesWidthoutPullback[] = $data['without_retraction_by_candles'][$key];
		$numberOfOperations[] = count( $data['analytical_data']['pullback'][$key] ) + count( $data['analytical_data']['without_pullback'][$key] );

	}

	$arrLabel = json_encode($arrLabel);
	$arrValuesPullback = json_encode($arrValuesPullback);
	$arrValuesWidthoutPullback = json_encode($arrValuesWidthoutPullback);

?>


<html><head>
	<title>Bar Chart</title>
	<script async="" src="//www.google-analytics.com/analytics.js"></script>
	<script src="http://www.chartjs.org/dist/2.7.3/Chart.bundle.js"></script><style type="text/css">/* Chart.js */
@-webkit-keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}@keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}.chartjs-render-monitor{-webkit-animation:chartjs-render-animation 0.001s;animation:chartjs-render-animation 0.001s;}</style>
	<script src="http://www.chartjs.org/samples/latest/utils.js"></script>
	<style>
	canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
	</style>
</head>

<body>
	<div id="container" style="width: 100%;"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
		<canvas id="canvas" width="1013" height="506" class="chartjs-render-monitor" style="display: block; width: 1013px; height: 506px;"></canvas>
	</div>
	
	<script>
		var color = Chart.helpers.color;
		var barChartData = {
			labels: <?=$arrLabel?>,
			datasets: [{
				label: 'Com Pullback',
				backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
				borderColor: window.chartColors.blue,
				borderWidth: 1,
				data: <?=$arrValuesPullback?>
			}, {
				label: 'Nao Teve Pullback',
				backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
				borderColor: window.chartColors.red,
				borderWidth: 1,
				data: <?=$arrValuesWidthoutPullback?>
			}]

		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myBar = new Chart(ctx, {
				type: 'bar',
				data: barChartData,
				options: {
					responsive: true,
					legend: {
						position: 'top',
					},
					title: {
						display: true,
						text: 'Dia a candles com ou sem Pullback ( <?=$data['days']?> Dias ) ( Minimo de OSC: <?=$oscMinima?> ) ( Min. Candles para comecar a verificar: <?=$numeroMinimoDeCandlesAposTaxaDeAbertura?> ) ( Max. Candles para comecar a verificar: <?=$numeroMaximoDeCandlesAposTaxaDeAbertura?> ) '
					}
				}
			});

		};

	</script>

	<?php

		echo '<pre>';
		print_r($data);

	?>

	</body>
</html>