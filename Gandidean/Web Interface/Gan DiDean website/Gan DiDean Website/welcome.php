<?php
session_start();

if(!$_SESSION['email']){
	header("location: index.php");
}

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
            <li class="active"><a href="welcome.php">Home</a></li>
            <li><a href="liveMap.php">Live Map</a></li>
            <li><a href="createCase.php">Create Case</a></li>
			<li><a href="deleteCase.php">Delete Case</a></li>
			<li><a href="dash.php">Dashboard</a></li>
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

      <div class="starter-template" style = "border: 1px solid black; border-radius: 5px; background-image: url(images/welcomePage.jpg); background-size: 100% 100%;">
        <br><br><br><br><br><br><br><br><br><br><br><br>
		<!--<h1>Welcome <?php echo $_SESSION['email']; ?></h1>
        <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a mostly barebones HTML document.</p>-->
      </div>
	  <br>
	  <br>
	  <!-- Example row of columns -->
      <div class="row">
        <<div class="col-md-3">
          <h2>Live Map</h2>
          <p>Our live interactive map will provide users with locations of homeless people around the city. Users can place a marker on a location where they have spotted a homeless person. Also usrs may delete markers from the map to signal that the person has been given help.</p>
        </div>
        <div class="col-md-3">
          <h2>Charities</h2>
          <p>The various charity organisations that provide for the homeless people of Ireland can benefit using this application. This application will provides charities the oppertunoity to locate homeless people more quickly and frequently. Also it gives charities the oppertunity to add homeless people sightings to the map, delete them from the map and assign a team to a created case.</p>
       </div>
        <div class="col-md-3">
          <h2>Dashboard</h2>
          <p>Check out the latest and most recent statistics regarding current homeless cases in Ireland. The dashboard provides graphical representations of the collected data regarding cases. Included are charts, for example the ratio from male to female for all cases can be measured on a chart</p>
        </div>
		<div class="col-md-3">
          <div style = "float: right;">
			<a class="twitter-timeline" href="https://twitter.com/hashtag/homelesscrisis" data-widget-id="660927541667094528">#homelesscrisis Tweets</a>
				<script>
				!function(d,s,id)
				{
					var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
					if(!d.getElementById(id))
					{
						js=d.createElement(s);
						js.id=id;js.src=p+"://platform.twitter.com/widgets.js";
						fjs.parentNode.insertBefore(js,fjs);
					}
				}
				(document,"script","twitter-wjs");
				</script>
			</div>
        </div>
      </div>

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