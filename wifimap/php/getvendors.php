<?php

require("dbinfo.php");

// Start XML file, create parent node
$dom = new DOMDocument("1.0", "UTF-8");
$node = $dom->createElement("vendor");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server
$mysqli = new mysqli("localhost", $username, $password, $database);

// Change character set to utf8
mysqli_set_charset($mysqli,"utf8");

$query = "SELECT DISTINCT vendor FROM network GROUP BY vendor ORDER BY MAX(vendor) ASC, vendor";
$result = $mysqli->query($query);

header("Content-type: text/xml;charset=UTF-8");

// Iterate through the rows, adding XML nodes for each
while ($row = $result->fetch_assoc()){
	// ADD TO XML DOCUMENT NODE
  $node = $dom->createElement("vendor");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("vendor", $row['vendor']);
}

echo $dom->saveXML();

?>
