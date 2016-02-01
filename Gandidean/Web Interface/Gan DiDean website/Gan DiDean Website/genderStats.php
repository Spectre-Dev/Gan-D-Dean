<?php
session_start();

if(!$_SESSION['email']){
	header("location: index.php");
}

?>

<?php
$con=mysql_connect("mysql.1freehosting.com","u721737790_ic","GanDidean2015") or die("Failed to connect with database!!!!");
mysql_select_db("u721737790_gd", $con); 

$sth = mysql_query("SELECT gender, COUNT(id) AS Cases
					FROM markers
					GROUP BY gender");


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
    $temp[] = array('v' => (string) $r['gender']); 

    // Values of each slice
    $temp[] = array('v' => (int) $r['Cases']); 
    $rows[] = array('c' => $temp);
}

$table['rows'] = $rows;
$jsonTable = json_encode($table);
//echo $jsonTable;
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Gan Dídean</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/starter-template.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	
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
          title: 'Cases By Gender',
          is3D: 'false',
          pieHole: 0.4,
          width: 800,
          height: 600
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
	
	function drawTable() {  //this is the method where I am drawing my table
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(<?=$jsonTable?>);
      var options = {
          title: 'Cases By Gender',
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

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top"> <!--style = "background: #5cb85c;-->
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
		  <a class="navbar-brand" href="welcome.php"><img src = "images/gandideanlogo.png" alt = "Gan Didean" width = "30" height = "30"></a>
          <a class="navbar-brand" href="welcome.php">Gan Didean</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="welcome.php">Home</a></li>
            <li><a href="liveMap.php">Live Map</a></li>
            <li><a href="createCase.php">Create Case</a></li>
			<li><a href="deleteCase.php">Delete Case</a></li>
			<li class = "active"><a href="dash.php">Dashboard</a></li>
			<li><a href="logout.php">Logout</a></li>
          </ul>
		  <div id="navbar" class="navbar-collapse collapse">
          <form class="navbar-form navbar-right" method = "post" action = "logout.php">
            <div class="form-group">
              <font color = 'white' size = '3'>
				<b><?php echo $_SESSION['email']; ?></b>
			  </font>
            </div>
			<div class="form-group">
              
            </div>
            <button type="submit" class="btn btn-success">Log out</button>
          </form>
        </div><!--/.navbar-collapse -->
		  
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" style = "margin-top: 2%;">
			<!--this is the div that will hold the chart-->
		<div id="chart_div" style = "margin-left: 20%;"></div>
		<div id="table_div" style = "margin-left: 20%;"></div>
      

      <hr>

      <footer>
	<div style = "float: left; margin-top: 2%;">
        	<p>&copy; Gan Dídean 2015</p>
	</div>
	<div style = "float:right;">
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="TS3FRA68SH35G">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>
	</div>
	<br/><br/><br/>
      </footer>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>