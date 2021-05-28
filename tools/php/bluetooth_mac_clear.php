<?php

require "dbinfo.php";

// Opens a connection to the MySQL server
$connection = new mysqli($server, $username, $password, $database);

if (!$connection) {  die('Not connected : ' . $mysqli->connect_error);}

mysqli_set_charset($connection,"utf8");

// Do a query to remove all vendor information from table
$query = "UPDATE bluetooth SET vendor='' WHERE vendor LIKE '%'";
$result = $connection->query($query);

echo "Vendor information cleared from 'bluetooth' table"

?>
