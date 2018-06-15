<?php

require("dbinfo.php");

// Start XML file, create parent node
$dom = new DOMDocument("1.0", "UTF-8");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server
$mysqli = new mysqli("localhost", $username, $password, $database);

// Change character set to utf8
mysqli_set_charset($mysqli,"utf8");

// Select all the rows in the location table that matches bssid
$query = "SELECT * FROM location WHERE
BSSID LIKE '$_POST[bssid]'";

$result = $mysqli->query($query);

header("Content-type: text/xml;charset=UTF-8");

// Iterate through the rows, adding XML nodes for each
while ($row = $result->fetch_assoc()){
  // ADD TO XML DOCUMENT NODE
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("BSSID", $row['bssid']);
  $newnode->setAttribute("LEVEL", $row['level']);
  $newnode->setAttribute("LAT", $row['lat']);
  $newnode->setAttribute("LON", $row['lon']);
  $newnode->setAttribute("ACCURACY", $row['accuracy']);
  $newnode->setAttribute("MONTH_SEEN", $row['month_seen']);
}

echo $dom->saveXML();

?>
