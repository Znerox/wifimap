<?php

require("dbinfo.php");

// Opens a connection to a MySQL server
$mysqli = new mysqli($server, $username, $password, $database);
if (!$mysqli) {  die('Not connected : ' . $mysqli->connect_error);}

// Change character set to utf8
mysqli_set_charset($mysqli,"utf8");

//set icon
$mysqli->query("UPDATE bluetooth SET icon='../images/bluetooth.png' WHERE TYPE LIKE 'B' OR TYPE LIKE 'E'");

//set bestlat/bestlon for networks from old version of app, with no "best" position
$mysqli->query("UPDATE bluetooth SET bestlat=lastlat WHERE bestlat LIKE '0.000000000000'");
$mysqli->query("UPDATE bluetooth SET bestlon=lastlon WHERE bestlon LIKE '0.000000000000'");

//set lastseen, for networks with new data
$result = $mysqli->query("SELECT bssid FROM bluetooth WHERE needs_update LIKE '1'");
$networksNeedingUpdate = $result->num_rows;

if ($networksNeedingUpdate > 0) {
  $networks_to_process = $mysqli->query("SELECT bssid,lasttime FROM bluetooth WHERE needs_update LIKE '1'");

  //run code on each line in the result
  while ($row = $networks_to_process->fetch_assoc()){
    $epochtime_rounded = round($row["lasttime"], -3); //In case of networks with timestamp not on even second
    $epochtime = $epochtime_rounded / 1000; //Convert from millisecond to seconds

    // Convert from epoch time to human readable date
    $dt = new DateTime("@$epochtime");
    $humantime = $dt->format('Y-m-d');
    $mysqli->query("UPDATE bluetooth SET lastseen='" . $humantime . "',
    needs_update='0',
    never_updated='0' WHERE bssid LIKE '" . $row['bssid'] . "'");
  }

}

//set lastseen, for networks with emty lastseen field
$result = $mysqli->query("SELECT bssid FROM bluetooth WHERE lastseen LIKE ''");
$networksWithNullDate = $result->num_rows;

if ($networksWithNullDate > 0) {
  $networks_to_process = $mysqli->query("SELECT bssid,lasttime FROM bluetooth WHERE lastseen LIKE ''");

  //run code on each line in the result
  while ($row = $networks_to_process->fetch_assoc()){
    $epochtime_rounded = round($row["lasttime"], -3); //In case of networks with timestamp not on even second
    $epochtime = $epochtime_rounded / 1000; //Convert from millisecond to seconds

    // Convert from epoch time to human readable date
    $dt = new DateTime("@$epochtime");
    $humantime = $dt->format('Y-m-d');
    $mysqli->query("UPDATE bluetooth SET lastseen='" . $humantime . "' WHERE bssid LIKE '" . $row['bssid'] . "'");
  }

}

//delete wifi data from list of bluetooth devices
$mysqli->query("DELETE FROM `bluetooth` WHERE type LIKE 'W'");

//let user know script is completed
echo "script completed";

?>
