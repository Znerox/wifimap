<?php

require("dbinfo.php");

// Opens a connection to a MySQL server
$mysqli = new mysqli("localhost", $username, $password, $database);

// Change character set to utf8
mysqli_set_charset($mysqli,"utf8");

//delete inaccurate points
$mysqli->query("DELETE FROM `location` WHERE accuracy > '5'");
$mysqli->query("DELETE FROM `location` WHERE lat LIKE 'inf'");
$mysqli->query("DELETE FROM `location` WHERE lon LIKE 'inf'");

//set month_seen

//2013 GMT
$mysqli->query("UPDATE location SET month_seen='January 2013' WHERE time > '1356998400000' AND time < '1359676799000'");
$mysqli->query("UPDATE location SET month_seen='February 2013' WHERE time > '1359676800000' AND time < '1362095999000'");
$mysqli->query("UPDATE location SET month_seen='March 2013' WHERE time > '1362096000000' AND time < '1364774399000'");
$mysqli->query("UPDATE location SET month_seen='April 2013' WHERE time > '1364774400000' AND time < '1367366399000'");
$mysqli->query("UPDATE location SET month_seen='May 2013'WHERE time > '1367366400000' AND time < '1370044799000'");
$mysqli->query("UPDATE location SET month_seen='June 2013' WHERE time > '1370044800000' AND time < '1372636799000'");
$mysqli->query("UPDATE location SET month_seen='July 2013' WHERE time > '1372636800000' AND time < '1377993599000'");
$mysqli->query("UPDATE location SET month_seen='August 2013' WHERE time > '1375315200000' AND time < '1377986399000'");
$mysqli->query("UPDATE location SET month_seen='September 2013' WHERE time > '1377993600000' AND time < '1380585599000'");
$mysqli->query("UPDATE location SET month_seen='October 2013' WHERE time > '1380585600000' AND time < '1383263999000'");
$mysqli->query("UPDATE location SET month_seen='November 2013' WHERE time > '1383264000000' AND time < '1385855999000");
$mysqli->query("UPDATE location SET month_seen='December 2013' WHERE time > '1385856000000' AND time < '1388534399000'");

//2014 GMT
$mysqli->query("UPDATE location SET month_seen='January 2014' WHERE time > '1388534400000' AND time < '1391212799000'");
$mysqli->query("UPDATE location SET month_seen='February 2014' WHERE time > '1391212800000' AND time < '1393631999000'");
$mysqli->query("UPDATE location SET month_seen='March 2014' WHERE time > '1393632000000' AND time < '1396310399000'");
$mysqli->query("UPDATE location SET month_seen='April 2014' WHERE time > '1396310400000' AND time < '1398902399000'");
$mysqli->query("UPDATE location SET month_seen='May 2014' WHERE time > '1398902400000' AND time < '1401580799000'");
$mysqli->query("UPDATE location SET month_seen='June 2014' WHERE time > '1401580800000' AND time < '1404172799000'");
$mysqli->query("UPDATE location SET month_seen='July 2014' WHERE time > '1404172800000' AND time < '1406851199000'");
$mysqli->query("UPDATE location SET month_seen='August 2014' WHERE time > '1406851200000' AND time < '1409529599000'");
$mysqli->query("UPDATE location SET month_seen='September 2014' WHERE time > '1409529600000' AND time < '1412121599000'");
$mysqli->query("UPDATE location SET month_seen='October 2014' WHERE time > '1412121600000' AND time < '1414799999000'");
$mysqli->query("UPDATE location SET month_seen='November 2014' WHERE time > '1414800000000' AND time < '1417391999000'");
$mysqli->query("UPDATE location SET month_seen='December 2014' WHERE time > '1417392000000' AND time < '1420070399000'");

//2015 GMT
$mysqli->query("UPDATE location SET month_seen='January 2015' WHERE time > '1420070400000' AND time < '1422748799000'");
$mysqli->query("UPDATE location SET month_seen='February 2015' WHERE time > '1422748800000' AND time < '1425167999000'");
$mysqli->query("UPDATE location SET month_seen='Mars 2015' WHERE time > '1425168000000' AND time < '1427846399000'");
$mysqli->query("UPDATE location SET month_seen='April 2015' WHERE time > '1427846400000' AND time < '1430438399000'");
$mysqli->query("UPDATE location SET month_seen='May 2015' WHERE time > '1430438400000' AND time < '1433116799000'");
$mysqli->query("UPDATE location SET month_seen='June 2015' WHERE time > '1433116800000' AND time < '1435708799000'");
$mysqli->query("UPDATE location SET month_seen='July 2015' WHERE time > '1435708800000' AND time < '1438387199000'");
$mysqli->query("UPDATE location SET month_seen='August 2015' WHERE time > '1438387200000' AND time < '1441065599000'");
$mysqli->query("UPDATE location SET month_seen='September 2015' WHERE time > '1441065600000' AND time < '1443657599000'");
$mysqli->query("UPDATE location SET month_seen='October 2015' WHERE time > '1443657600000' AND time < '1446335999000'");
$mysqli->query("UPDATE location SET month_seen='November 2015' WHERE time > '1446336000000' AND time < '1448927999000'");
$mysqli->query("UPDATE location SET month_seen='December 2015' WHERE time > '1448928000000' AND time < '1451606399000'");

//2016 GMT
$mysqli->query("UPDATE location SET month_seen='January 2016' WHERE time > '1451606400000' AND time < '1454284799000'");
$mysqli->query("UPDATE location SET month_seen='February 2016' WHERE time > '1454284800000' AND time < '1456790399000'");
$mysqli->query("UPDATE location SET month_seen='March 2016' WHERE time > '1456790400000' AND time < '1459468799000'");
$mysqli->query("UPDATE location SET month_seen='April 2016' WHERE time > '1459468800000' AND time < '1462060799000'");
$mysqli->query("UPDATE location SET month_seen='May 2016' WHERE time > '1462060800000' AND time < '1464739199000'");
$mysqli->query("UPDATE location SET month_seen='June 2016' WHERE time > '1464739200000' AND time < '1467331199000'");
$mysqli->query("UPDATE location SET month_seen='July 2016' WHERE time > '1467331200000' AND time < '1470009599000'");
$mysqli->query("UPDATE location SET month_seen='August 2016' WHERE time > '1470009600000' AND time < '1472687999000'");
$mysqli->query("UPDATE location SET month_seen='September 2016' WHERE time > '1472688000000' AND time < '1475279999000'");
$mysqli->query("UPDATE location SET month_seen='October 2016' WHERE time > '1475280000000' AND time < '1477958399000'");
$mysqli->query("UPDATE location SET month_seen='November 2016' WHERE time > '1477958400000' AND time < '1480550399000'");
$mysqli->query("UPDATE location SET month_seen='December 2016' WHERE time > '1480550400000' AND time < '1483228799000'");

//2017 GMT
$mysqli->query("UPDATE location SET month_seen='January 2017' WHERE time > '1483228800000' AND time < '1485907199000'");
$mysqli->query("UPDATE location SET month_seen='February 2017' WHERE time > '1485907200000' AND time < '1488326399000'");
$mysqli->query("UPDATE location SET month_seen='March 2017' WHERE time > '1488326400000' AND time < '1491004799000'");
$mysqli->query("UPDATE location SET month_seen='April 2017' WHERE time > '1491004800000' AND time < '1493596799000'");
$mysqli->query("UPDATE location SET month_seen='May 2017' WHERE time > '1493596800000' AND time < '1496275199000'");
$mysqli->query("UPDATE location SET month_seen='June 2017' WHERE time > '1496275200000' AND time < '1498867199000'");
$mysqli->query("UPDATE location SET month_seen='July 2017' WHERE time > '1498867200000' AND time < '1501459199000'");
$mysqli->query("UPDATE location SET month_seen='August 2017' WHERE time > '1501545600000' AND time < '1504223999000'");
$mysqli->query("UPDATE location SET month_seen='September 2017' WHERE time > '1504224000000' AND time < '1506815999000'");
$mysqli->query("UPDATE location SET month_seen='October 2017' WHERE time > '1506816000000' AND time < '1509494399000'");
$mysqli->query("UPDATE location SET month_seen='November 2017' WHERE time > '1509494400000' AND time < '1512086399000'");
$mysqli->query("UPDATE location SET month_seen='December 2017' WHERE time > '1512086400000' AND time < '1514764799000'");

//if date is not set, update field to let user know. you can use use epochconverter.com to find timestamp (in milliseconds) to update this list yourself
$mysqli->query("UPDATE location SET month_seen='UNKNOWN' WHERE month_seen LIKE ''");

//let user know script is completed
echo "script completed";

?> 