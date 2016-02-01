<?php
require("dbInfo.php");

// Gets data from URL parameters
$description = $_GET['description'];
$address = $_GET['address'];
$lat = $_GET['lat'];
$lng = $_GET['lng'];
$gender = $_GET['gender'];
$assign = $_GET['assign'];

// Opens a connection to a MySQL server
$connection=mysql_connect ("mysql.1freehosting.com", $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

// Set the active MySQL database
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

// Insert new row with user data
$query = sprintf("INSERT INTO markers " .
         " (id, description, address, lat, lng, gender, assign ) " .
         " VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s');",
         mysql_real_escape_string($description),
         mysql_real_escape_string($address),
         mysql_real_escape_string($lat),
         mysql_real_escape_string($lng),
         mysql_real_escape_string($gender),
		 mysql_real_escape_string($assign));

$result = mysql_query($query);

if (!$result) {
  die('Invalid query: ' . mysql_error());
}

?>