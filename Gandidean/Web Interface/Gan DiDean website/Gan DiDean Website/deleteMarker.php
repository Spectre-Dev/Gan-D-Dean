<?php  
 require("dbInfo.php");
// Get parameters from URL
 $id = $_GET["id"];
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
// delete the row in the table
$query = sprintf("DELETE FROM markers WHERE id = '$id'");
//echo "<br>";
//echo $query;
$result = mysql_query($query);

if (!$result) {
  die('Invalid query: ' . mysql_error());
}

//query to set count to 0
$query0 = sprintf("SET @count = 0");
$result0 = mysql_query($query0);

if (!$result0) {
  die('Invalid query: ' . mysql_error());
}


//query to update the markers id to match the id of the marker in the array in the deleCase.php file
$query1 = sprintf("UPDATE markers SET markers.id = @count:= @count + 1");
$result1 = mysql_query($query1);

if (!$result1) {
  die('Invalid query: ' . mysql_error());
}

//query to reset the id's of markers with the first marker in the table being set to one
$query2 = sprintf("ALTER TABLE markers AUTO_INCREMENT = 1");
$result2 = mysql_query($query2);

if (!$result2) {
  die('Invalid query: ' . mysql_error());
}

header("Refresh:0");

?>