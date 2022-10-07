<?php

require "dbinfo.php";

$connection_1 = new mysqli($server, $username, $password);
mysqli_set_charset($connection_1,"utf8");

echo "'1' means command was successful<br>";
echo "If the line is blank after 'created', it probably means the database already exists<br><br>";

$database_result = $connection_1->query("CREATE DATABASE " . $database);
echo "Database created: $database_result<br>";

$connection_2 = new mysqli($server, $username, $password, $database);
mysqli_set_charset($connection_2,"utf8");

$create_table_information = "CREATE TABLE information(
DatabaseStructureVersion varchar (10) PRIMARY KEY)";

$set_structure_version = "INSERT INTO information (DatabaseStructureVersion) VALUES('2022-10-06')";

$create_table_network = "CREATE TABLE network(
type varchar(8) DEFAULT '',
bssid varchar(27) PRIMARY KEY NOT NULL DEFAULT '',
vendor varchar(128) NOT NULL DEFAULT '',
ssid varchar(32) NOT NULL DEFAULT '',
frequency varchar(13) NOT NULL DEFAULT '',
channel varchar(8) NOT NULL DEFAULT '',
band varchar(64) NOT NULL DEFAULT '',
capabilities varchar(128) NOT NULL DEFAULT '',
icon varchar(128) NOT NULL DEFAULT '',
lasttime varchar(49) NOT NULL DEFAULT '',
lastseen varchar(64) NOT NULL DEFAULT '',
lastlat decimal(28,12),
lastlon decimal(28,12),
bestlevel varchar(4) NOT NULL DEFAULT '',
bestlat decimal(28,12),
bestlon decimal(28,12),
predefined_search varchar (256) NOT NULL DEFAULT '',
connected_clients varchar(2048) NOT NULL DEFAULT '',
probing_clients varchar(4096) NOT NULL DEFAULT '',
needs_update int (1) NOT NULL DEFAULT '0',
never_updated int (1) NOT NULL DEFAULT '1')";

$create_table_location = "CREATE TABLE location(
id int AUTO_INCREMENT PRIMARY KEY,
bssid varchar(64) NOT NULL DEFAULT '',
level varchar(64) NOT NULL DEFAULT '',
lat varchar(64) NOT NULL DEFAULT '',
lon varchar(64) NOT NULL DEFAULT '',
altitude varchar(64) NOT NULL DEFAULT '',
accuracy decimal(64,0),
time varchar(64) NOT NULL DEFAULT '',
date varchar(64) NOT NULL DEFAULT '')";

$create_table_clients = "CREATE TABLE clients(
client_mac varchar(17) PRIMARY KEY NOT NULL DEFAULT '',
vendor varchar(128) NOT NULL DEFAULT '',
connected_to_bssid varchar(1024) NOT NULL DEFAULT '',
probed_essid varchar(1024) NOT NULL DEFAULT '',
first_seen varchar(32) NOT NULL DEFAULT '',
last_seen varchar(32) NOT NULL DEFAULT '')";

$create_table_bluetooth = "CREATE TABLE bluetooth(
type varchar(8) DEFAULT '',
bssid varchar(27) PRIMARY KEY NOT NULL DEFAULT '',
vendor varchar(128) NOT NULL DEFAULT '',
ssid varchar(32) NOT NULL DEFAULT '',
frequency varchar(13) NOT NULL DEFAULT '',
channel varchar(8) NOT NULL DEFAULT '',
capabilities varchar(57) NOT NULL DEFAULT '',
icon varchar(128) NOT NULL DEFAULT '',
lasttime varchar(49) NOT NULL DEFAULT '',
lastseen varchar(64) NOT NULL DEFAULT '',
lastlat decimal(28,12),
lastlon decimal(28,12),
bestlevel varchar(4) NOT NULL DEFAULT '',
bestlat decimal(28,12),
bestlon decimal(28,12),
predefined_search varchar (256) NOT NULL DEFAULT '',
needs_update int (1) NOT NULL DEFAULT '0',
never_updated int (1) NOT NULL DEFAULT '1')";

$connection_2->query($create_table_information);
$connection_2->query($set_structure_version);

$network_result = $connection_2->query($create_table_network);
echo "Network table created: $network_result<br>";

$location_result = $connection_2->query($create_table_location);
echo "Location table created : $location_result<br>";

$clients_result = $connection_2->query($create_table_clients);
echo "Clients table created: $clients_result<br>";

$bluetooth_result = $connection_2->query($create_table_bluetooth);
echo "Bluetooth table created: $bluetooth_result<br>";
?>
