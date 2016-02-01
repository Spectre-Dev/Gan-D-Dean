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

    <title>Gan Didean Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">

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
		
		<div class="container-fluid">
      <div class="row">
        
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard</h1>

          <div class="row placeholders">
            <div class="col-xs-6 col-sm-6 placeholder">
              <a href = "genderStats.php"><img src = "images/gandideanlogo.png" alt = "Gender Stats" width = "200" height = "200"></a>
              <h4>Gender Stats</h4>
              <span class="text-muted">Cases By Gender</span>
            </div>
            <div class="col-xs-6 col-sm-6 placeholder">
              <a href = "teamStats.php"><img src = "images/gandideanlogo.png" alt = "Team Stats" width = "200" height = "200"></a>
              <h4>Team Stats</h4>
              <span class="text-muted">Cases By Team</span>
            </div>
          </div>
          
          </div>
        </div>
      </div>
      
	  <br/><br/><br/><br/>
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
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
