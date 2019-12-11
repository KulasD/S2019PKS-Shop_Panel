<?php
	$tabelson = array();
	$rowssss = array();
	$tabelson['cols'] = array(
		array(
			'label' => 'cosik',
			'type' => 'string'
		),
		array(
			'label' => 'cosok',
			'type' => 'number'
		)
	);
	$a=0;
	while ($a<30){
		$a=$a+1;
		$rowssss = array();
		$rowssss[] = array ( "v" => 'v'.$a); 	// powinna się wpisywać data
		$rowssss[] = array ( "v" => $a);	// powinna się wpisywać liczba zamowień
		$rows[] = array ( "c" => $rowssss);	// push takiego jednego wpisu do tabeli
	}
	$tabelson['rows'] = $rows;
	$jsonTable = json_encode($tabelson);
?>
<html>
  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
   
    // Load the Visualization API.
    google.load('visualization', '1', {'packages':['corechart']});
     
    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);
     
    function drawChart() {
         
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(<?php echo $jsonTable; ?>);
	  var options = {
		  legend: {position: 'none'},
		  width: 363,
		  height: 290,
		  chartArea: {left: 40, top: 0, right: 0, width: '80%', height: '80%'},
	  };

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }

    </script>
  </head>

  <body>
    <!--Div that will hold the column chart-->
    <div id="chart_div"></div>
  </body>
</html>
