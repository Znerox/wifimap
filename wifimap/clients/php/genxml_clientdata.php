<?php

require("dbinfo.php");

// Start XML file, create parent node
$dom = new DOMDocument("1.0", "UTF-8");
$node = $dom->createElement("clients");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server
$mysqli = new mysqli("localhost", $username, $password, $database);

// Change character set to utf8
mysqli_set_charset($mysqli,"utf8");

// Select all the rows in the clients table that matches client mac
$query = "SELECT * FROM clients WHERE
client_mac LIKE '$_POST[searchinput]'";

$result = $mysqli->query($query);

header("Content-type: text/xml;charset=UTF-8");

// Iterate through the rows, adding XML nodes for each
while ($row = $result->fetch_assoc()){
  // ADD TO XML DOCUMENT NODE
  $node = $dom->createElement("client");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("client_mac", $row['client_mac']);
  $newnode->setAttribute("vendor", $row['vendor']);
  $newnode->setAttribute("connected_to_bssid", $row['connected_to_bssid']);
  $newnode->setAttribute("probed_essid", $row['probed_essid']);
  $newnode->setAttribute("first_seen", $row['first_seen']);
  $newnode->setAttribute("last_seen", $row['last_seen']);
}

echo $dom->saveXML();

?>
