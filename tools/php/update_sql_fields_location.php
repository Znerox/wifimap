<?php

require("dbinfo.php");

// Opens a connection to a MySQL server
$mysqli = new mysqli("localhost", $username, $password, $database);
if (!$mysqli) {  die('Not connected : ' . $mysqli->connect_error);}

// Change character set to utf8
mysqli_set_charset($mysqli,"utf8");

//delete inaccurate points
$mysqli->query("DELETE FROM `location` WHERE lat LIKE 'inf'");
$mysqli->query("DELETE FROM `location` WHERE lon LIKE 'inf'");

//set date
$result = $mysqli->query("SELECT bssid,time FROM location WHERE date LIKE ''");
$networksWithNullDate = $result->num_rows;

if ($networksWithNullDate > 0) {
  $rows_to_process = $mysqli->query("SELECT bssid,time FROM location WHERE date LIKE ''");

  //run code on each line in the result
  while ($row = $rows_to_process->fetch_assoc()){
    $epochtime_rounded = round($row["time"], -3); //In case of networks with timestamp not on even second
    $epochtime = $epochtime_rounded / 1000; //Convert from millisecond to seconds

    // Convert from epoch time to human readable date
    $dt = new DateTime("@$epochtime");
    $humantime = $dt->format('d-m-Y');
    $mysqli->query("UPDATE location SET date='" . $humantime . "' WHERE time LIKE '" . $row[time] . "'");
  }

}

//set date t o"Unknown" for networks with date = 0
$mysqli->query("UPDATE location SET date='' WHERE time LIKE '0'");

//let user know script is completed
echo "script completed";

?>
