<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	include('../../src/WDOAPI/autoload.php');

	$days = 180;
	// $days = 10;
	// $days = 40;
	$oscMinima = 4;
	$pontuacaoMinima = 5;
	$validarPelaSombra = 0; // se for pela sombra, ele ve a maxima e a minima ao inves do fechamento

	$numeroMinimoDeCandlesAposTaxaDeAbertura = 1; // Minimo de candles para comecar a ver se voltou pra taxa em um "fechamento de candle" ou e esta vencendo a retracao
	$numeroMaximoDeCandlesAposTaxaDeAbertura = 40; // Maximo de candles para comecar a ver se voltou pra taxa em um "fechamento de candle" ou e esta vencendo a retracao

	$WDOAPI = new WDOAPI\WDOAPI( true );
 
	// Dados para grafico de osc | Contador de Nivel das Oscilacoes por Niveis
	$data = $WDOAPI->mainCandlesOfDayThatHavePullbackPerOsc(  $days, 
																		"", 
																		$numeroMinimoDeCandlesAposTaxaDeAbertura, 
																		$numeroMaximoDeCandlesAposTaxaDeAbertura, 
																		$pontuacaoMinima,
																		$validarPelaSombra
																		);

	$arrLabel = [];
	$arrValuePullBack = [];
	$arrValuesWidthoutPullback = [];
	
	foreach($data['lookup']['pullback'] as $rate => $value ){

		$arrLabel[] = $rate;
		$arrValuePullBack[] = count($value);
		$arrValuesWidthoutPullback[] = count($data['lookup']['without_pullback'][$rate]);

	}
	

	$arrLabel = json_encode($arrLabel);
	'<hr />';
	$arrValuePullBack = json_encode($arrValuePullBack);
	'<hr />';
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
				data: <?=$arrValuePullBack?>
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
						text: 'Retracao por Oscilacao'
					}
				}
			});

		};

	</script>

	<?php

		echo '<pre>';
		var_dump($data);

	?>

	</body>
</html>