<?php

require "dbinfo.php";

// Start XML file, create parent node
$dom = new DOMDocument("1.0", "UTF-8");
$node = $dom->createElement("version");
$parnode = $dom->appendChild($node);

// Opens a connection to the MySQL server
$connection = new mysqli($server, $username, $password, $database);

// Change character set to utf8
mysqli_set_charset($connection,"utf8");

$query = "SELECT DatabaseStructureVersion FROM information WHERE 1";
$result = $connection->query($query);

header("Content-type: text/xml;charset=UTF-8");

// Iterate through the rows, adding XML nodes for each
while ($row = $result->fetch_assoc()){
    // ADD TO XML DOCUMENT NODE
    $node = $dom->createElement("version");
    $newnode = $parnode->appendChild($node);
    $newnode->setAttribute("version", $row['DatabaseStructureVersion']);
}

echo $dom->saveXML();

?>