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
    <link href="css/signin.css" rel="stylesheet">

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

    <div class="container">

      <form class="form-signin" method = "post" action = "register.php">
        <h2 class="form-signin-heading">Please sign up</h2>
		<label for="inputEmail" class="sr-only">Email address</label>
        <input name = "name" type="text" id="inputEmail" class="form-control" placeholder="Username" required autofocus>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input name = "email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input name = "pass" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button name = "submit" class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
      </form>

    </div> <!-- /container -->
	
	<center>
	<font color = 'red' size = '4'>Already Registered?</font>
	<a href = 'index.php'>Login Here</a>
	</center>


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>


<?php

mysql_connect("mysql.1freehosting.com","u721737790_ic","GanDidean2015");
mysql_select_db("u721737790_gd");

	if(isset($_POST['submit'])){
		$user_name = $_POST['name'];
		$user_pass = $_POST['pass'];
		$user_email = $_POST['email'];
		
		if($user_name == ''){
			echo "<script>alert('Please enter your name!')</script>";
			exit();
		}
		if($user_pass == ''){
			echo "<script>alert('Please enter your password!')</script>";
			exit();
		}
		if($user_email == ''){
			echo "<script>alert('Please enter your email!')</script>";
			exit();
		}
		
		$check_email = "SELECT * FROM users WHERE user_email = '$user_email'";

		$run = mysql_query($check_email);
		
		if(mysql_num_rows($run)>0){
		echo "<script>alert('Email $user_email already exists in our database, Please try again!')</script>";
		exit();
		}
		
		$query = "INSERT INTO users(user_name,user_pass,user_email) 
		VALUES('$user_name',md5('$user_pass'),'$user_email')";
		
		if(mysql_query($query)){
			
			echo "<script>alert('Account successfully created!')</script>";
			echo "<script>window.open('index.php','_self')</script>";
		}
		
		
		
	}

?>