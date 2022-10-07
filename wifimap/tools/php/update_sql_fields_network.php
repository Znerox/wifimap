<?php

require("dbinfo.php");

// Opens a connection to a MySQL server
$mysqli = new mysqli($server, $username, $password, $database);
if (!$mysqli) {  die('Not connected : ' . $mysqli->connect_error);}

// Change character set to utf8
mysqli_set_charset($mysqli,"utf8");

//set hidden network ssid
$mysqli->query("UPDATE network SET ssid='[Hidden network]' WHERE ssid = ''");

//set channel for 2.4ghz band
$mysqli->query("UPDATE network SET channel='1' WHERE frequency LIKE '2412'");
$mysqli->query("UPDATE network SET channel='2' WHERE frequency LIKE '2417'");
$mysqli->query("UPDATE network SET channel='3' WHERE frequency LIKE '2422'");
$mysqli->query("UPDATE network SET channel='4' WHERE frequency LIKE '2427'");
$mysqli->query("UPDATE network SET channel='5' WHERE frequency LIKE '2432'");
$mysqli->query("UPDATE network SET channel='6' WHERE frequency LIKE '2437'");
$mysqli->query("UPDATE network SET channel='7' WHERE frequency LIKE '2442'");
$mysqli->query("UPDATE network SET channel='8' WHERE frequency LIKE '2447'");
$mysqli->query("UPDATE network SET channel='9' WHERE frequency LIKE '2452'");
$mysqli->query("UPDATE network SET channel='10' WHERE frequency LIKE '2457'");
$mysqli->query("UPDATE network SET channel='11' WHERE frequency LIKE '2462'");
$mysqli->query("UPDATE network SET channel='12' WHERE frequency LIKE '2467'");
$mysqli->query("UPDATE network SET channel='13' WHERE frequency LIKE '2472'");
$mysqli->query("UPDATE network SET channel='14' WHERE frequency LIKE '2484'");

//set channel for 5ghz band
$mysqli->query("UPDATE network SET channel='36' WHERE frequency LIKE '5180'");
$mysqli->query("UPDATE network SET channel='40' WHERE frequency LIKE '5200'");
$mysqli->query("UPDATE network SET channel='44' WHERE frequency LIKE '5220'");
$mysqli->query("UPDATE network SET channel='48' WHERE frequency LIKE '5240'");
$mysqli->query("UPDATE network SET channel='52' WHERE frequency LIKE '5260'");
$mysqli->query("UPDATE network SET channel='56' WHERE frequency LIKE '5280'");
$mysqli->query("UPDATE network SET channel='60' WHERE frequency LIKE '5300'");
$mysqli->query("UPDATE network SET channel='64' WHERE frequency LIKE '5320'");
$mysqli->query("UPDATE network SET channel='100' WHERE frequency LIKE '5500'");
$mysqli->query("UPDATE network SET channel='104' WHERE frequency LIKE '5520'");
$mysqli->query("UPDATE network SET channel='108' WHERE frequency LIKE '5540'");
$mysqli->query("UPDATE network SET channel='112' WHERE frequency LIKE '5560'");
$mysqli->query("UPDATE network SET channel='116' WHERE frequency LIKE '5580'");
$mysqli->query("UPDATE network SET channel='120' WHERE frequency LIKE '5600'");
$mysqli->query("UPDATE network SET channel='124' WHERE frequency LIKE '5620'");
$mysqli->query("UPDATE network SET channel='128' WHERE frequency LIKE '5640'");
$mysqli->query("UPDATE network SET channel='132' WHERE frequency LIKE '5660'");
$mysqli->query("UPDATE network SET channel='136' WHERE frequency LIKE '5680'");
$mysqli->query("UPDATE network SET channel='140' WHERE frequency LIKE '5700'");

//set band
$mysqli->query("UPDATE network SET band='2.4ghz' WHERE frequency BETWEEN '2412' AND '2484'");
$mysqli->query("UPDATE network SET band='5ghz' WHERE frequency BETWEEN '5180' AND '5700'");
$mysqli->query("UPDATE network SET band='INVALID' WHERE band LIKE ''");

//set icon
$mysqli->query("UPDATE network SET icon='images/blue.png' WHERE CAPABILITIES NOT LIKE '%WEP%' AND CAPABILITIES NOT LIKE '%WPA%'");
$mysqli->query("UPDATE network SET icon='images/red.png' WHERE CAPABILITIES LIKE '%WEP%'");
$mysqli->query("UPDATE network SET icon='images/yellow.png' WHERE CAPABILITIES NOT LIKE '%WEP%' AND CAPABILITIES LIKE '%WPA%' AND CAPABILITIES LIKE '%WPS%'");
$mysqli->query("UPDATE network SET icon='images/green.png' WHERE CAPABILITIES NOT LIKE '%WEP%' AND CAPABILITIES NOT LIKE '%WPS%' AND CAPABILITIES LIKE '%WPA%'");

//set bestlat/bestlon for networks from old version of app, with no "best" position
$mysqli->query("UPDATE network SET bestlat=lastlat WHERE bestlat LIKE '0.000000000000'");
$mysqli->query("UPDATE network SET bestlon=lastlon WHERE bestlon LIKE '0.000000000000'");

//set lastseen, for networks with new data
$result = $mysqli->query("SELECT bssid FROM network WHERE needs_update LIKE '1'");
$networksNeedingUpdate = $result->num_rows;

if ($networksNeedingUpdate > 0) {
  $networks_to_process = $mysqli->query("SELECT bssid,lasttime FROM network WHERE needs_update LIKE '1'");

  //run code on each line in the result
  while ($row = $networks_to_process->fetch_assoc()){
    $epochtime_rounded = round($row["lasttime"], -3); //In case of networks with timestamp not on even second
    $epochtime = $epochtime_rounded / 1000; //Convert from millisecond to seconds

    // Convert from epoch time to human readable date
    $dt = new DateTime("@$epochtime");
    $humantime = $dt->format('Y-m-d');
    $mysqli->query("UPDATE network SET lastseen='" . $humantime . "',
    needs_update='0',
    never_updated='0' WHERE bssid LIKE '" . $row['bssid'] . "'");
  }

}

//set lastseen, for networks with emty lastseen field
$result = $mysqli->query("SELECT bssid FROM network WHERE lastseen LIKE ''");
$networksWithNullDate = $result->num_rows;

if ($networksWithNullDate > 0) {
  $networks_to_process = $mysqli->query("SELECT bssid,lasttime FROM network WHERE lastseen LIKE ''");

  //run code on each line in the result
  while ($row = $networks_to_process->fetch_assoc()){
    $epochtime_rounded = round($row["lasttime"], -3); //In case of networks with timestamp not on even second
    $epochtime = $epochtime_rounded / 1000; //Convert from millisecond to seconds

    // Convert from epoch time to human readable date
    $dt = new DateTime("@$epochtime");
    $humantime = $dt->format('Y-m-d');
    $mysqli->query("UPDATE network SET lastseen='" . $humantime . "' WHERE bssid LIKE '" . $row['bssid'] . "'");
  }

}

//temporary solution to bug. delete networks which were not imported correctly
$mysqli->query("DELETE FROM `network` WHERE frequency LIKE ''");
$mysqli->query("DELETE FROM `network` WHERE capabilities LIKE '2___' OR capabilities LIKE '5___'");

//delete bluetooth data from list of wifi networks
$mysqli->query("DELETE FROM `network` WHERE type NOT LIKE 'W'");

//let user know script is completed
echo "script completed";

?>
