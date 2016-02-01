<?php
$con=mysql_connect("localhost","root","") or die("Failed to connect with database!!!!");
mysql_select_db("homeless_tracker", $con); 

$sth = mysql_query("SELECT assign AS Team, COUNT(id) AS Cases FROM `markers` GROUP BY Team");


$rows = array();
//flag is not needed
$flag = true;
$table = array();
$table['cols'] = array(

    // Labels for your chart, these represent the column titles
    // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
	array('label' => 'gender', 'type' => 'string'),
	array('label' => 'Cases', 'type' => 'number')

);

$rows = array();
while($r = mysql_fetch_assoc($sth)) {
    $temp = array();
    // the following line will be used to slice the Pie chart
    $temp[] = array('v' => (string) $r['Team']); 

    // Values of each slice
    $temp[] = array('v' => (int) $r['Cases']); 
    $rows[] = array('c' => $temp);
}

$table['rows'] = $rows;
$jsonTable = json_encode($table);
//echo $jsonTable;
?>

<!DOCTYPE html >
<html style = "width:100%; height:100%; margin:0; padding:0;">
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Gan Dídean</title>
	
	<!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/jasny-bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/navmenu-reveal.css" rel="stylesheet">
	
	<!--Load the Ajax API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript">

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});
	google.load('visualization', '1', {'packages':['table']});


    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);
	google.setOnLoadCallback(drawTable);
	

    function drawChart() {

      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(<?=$jsonTable?>);
      var options = {
          title: 'Cases By Team',
          is3D: 'false',
          pieHole: 0.4,
          width: 800,
          height: 600
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
      var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
	
	function drawTable() {  //this is the method where I am drawing my table
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(<?=$jsonTable?>);
      var options = {
          title: 'Cases By Team',
          width: 800,
          height: 400
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID

      var table = new google.visualization.Table(document.getElementById('table_div'));
      table.draw(data, {showRowNumber: true, width: '50%', height: '50%'});
    }
	
    </script>
	
	
	</head>

  <body style = "width:100%; height:100%; margin:0; padding:0;">
    <div class="navmenu navmenu-default navmenu-fixed-left">
      <a class="navmenu-brand" href="#" style = "background: black; color: white;">Gan Dídean - Create Case</a>
      <ul class="nav navmenu-nav">
        <li><a href="liveMap.php">Live Cases</a></li>
        <li><a href="createCase.php">Create Cases</a></li>
        <li><a href="deleteCase.php">Delete Cases</a></li>
        <li><a href="welcome.php">Home</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Statistics</a>
          <ul class="dropdown-menu navmenu-nav">
            <li><a href="graph.php">Cases by Gender</a></li>
            <li><a href="graphTwo.php">Cases by Team</a></li>
          </ul>
        </li>
      </ul>
    </div>

    <div class="canvas">
      <div class="navbar navbar-default navbar-fixed-top" style = "background-color: transparent;">
        <button type="button" class="navbar-toggle" data-toggle="offcanvas" data-recalc="false" data-target=".navmenu" data-canvas=".canvas">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
	  
	  <!--this is the div that will hold the pie chart-->
    <div id="chart_div" style = "margin-left: 20%;"></div>
	<div id="table_div" style = "margin-left: 20%;"></div>
	  
	  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jasny-bootstrap.min.js"></script>
  </body>

</html>