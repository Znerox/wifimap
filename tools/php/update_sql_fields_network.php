<?php

require("dbinfo.php");

// Opens a connection to a MySQL server
$mysqli = new mysqli("localhost", $username, $password, $database);

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

//set lastseen

//2015 GMT
$mysqli->query("UPDATE network SET lastseen='January 2015' WHERE lasttime > '1420070400000' AND lasttime < '1422748799000'");
$mysqli->query("UPDATE network SET lastseen='February 2015' WHERE lasttime > '1422748800000' AND lasttime < '1425167999000'");
$mysqli->query("UPDATE network SET lastseen='Mars 2015' WHERE lasttime > '1425168000000' AND lasttime < '1427846399000'");
$mysqli->query("UPDATE network SET lastseen='April 2015' WHERE lasttime > '1427846400000' AND lasttime < '1430438399000'");
$mysqli->query("UPDATE network SET lastseen='May 2015' WHERE lasttime > '1430438400000' AND lasttime < '1433116799000'");
$mysqli->query("UPDATE network SET lastseen='June 2015' WHERE lasttime > '1433116800000' AND lasttime < '1435708799000'");
$mysqli->query("UPDATE network SET lastseen='July 2015' WHERE lasttime > '1435708800000' AND lasttime < '1438387199000'");
$mysqli->query("UPDATE network SET lastseen='August 2015' WHERE lasttime > '1438387200000' AND lasttime < '1441065599000'");
$mysqli->query("UPDATE network SET lastseen='September 2015' WHERE lasttime > '1441065600000' AND lasttime < '1443657599000'");
$mysqli->query("UPDATE network SET lastseen='October 2015' WHERE lasttime > '1443657600000' AND lasttime < '1446335999000'");
$mysqli->query("UPDATE network SET lastseen='November 2015' WHERE lasttime > '1446336000000' AND lasttime < '1448927999000'");
$mysqli->query("UPDATE network SET lastseen='December 2015' WHERE lasttime > '1448928000000' AND lasttime < '1451606399000'");

//2016 GMT
$mysqli->query("UPDATE network SET lastseen='January 2016' WHERE lasttime > '1451606400000' AND lasttime < '1454284799000'");
$mysqli->query("UPDATE network SET lastseen='February 2016' WHERE lasttime > '1454284800000' AND lasttime < '1456790399000'");
$mysqli->query("UPDATE network SET lastseen='March 2016' WHERE lasttime > '1456790400000' AND lasttime < '1459468799000'");
$mysqli->query("UPDATE network SET lastseen='April 2016' WHERE lasttime > '1459468800000' AND lasttime < '1462060799000'");
$mysqli->query("UPDATE network SET lastseen='May 2016' WHERE lasttime > '1462060800000' AND lasttime < '1464739199000'");
$mysqli->query("UPDATE network SET lastseen='June 2016' WHERE lasttime > '1464739200000' AND lasttime < '1467331199000'");
$mysqli->query("UPDATE network SET lastseen='July 2016' WHERE lasttime > '1467331200000' AND lasttime < '1470009599000'");
$mysqli->query("UPDATE network SET lastseen='August 2016' WHERE lasttime > '1470009600000' AND lasttime < '1472687999000'");
$mysqli->query("UPDATE network SET lastseen='September 2016' WHERE lasttime > '1472688000000' AND lasttime < '1475279999000'");
$mysqli->query("UPDATE network SET lastseen='October 2016' WHERE lasttime > '1475280000000' AND lasttime < '1477958399000'");
$mysqli->query("UPDATE network SET lastseen='November 2016' WHERE lasttime > '1477958400000' AND lasttime < '1480550399000'");
$mysqli->query("UPDATE network SET lastseen='December 2016' WHERE lasttime > '1480550400000' AND lasttime < '1483228799000'");

//2017 GMT
$mysqli->query("UPDATE network SET lastseen='January 2017' WHERE lasttime > '1483228800000' AND lasttime < '1485907199000'");
$mysqli->query("UPDATE network SET lastseen='February 2017' WHERE lasttime > '1485907200000' AND lasttime < '1488326399000'");
$mysqli->query("UPDATE network SET lastseen='March 2017' WHERE lasttime > '1488326400000' AND lasttime < '1491004799000'");
$mysqli->query("UPDATE network SET lastseen='April 2017' WHERE lasttime > '1491004800000' AND lasttime < '1493596799000'");
$mysqli->query("UPDATE network SET lastseen='May 2017' WHERE lasttime > '1493596800000' AND lasttime < '1496275199000'");
$mysqli->query("UPDATE network SET lastseen='June 2017' WHERE lasttime > '1496275200000' AND lasttime < '1498867199000'");
$mysqli->query("UPDATE network SET lastseen='July 2017' WHERE lasttime > '1498867200000' AND lasttime < '1501459199000'");
$mysqli->query("UPDATE network SET lastseen='August 2017' WHERE lasttime > '1501545600000' AND lasttime < '1504223999000'");
$mysqli->query("UPDATE network SET lastseen='September 2017' WHERE lasttime > '1504224000000' AND lasttime < '1506815999000'");
$mysqli->query("UPDATE network SET lastseen='October 2017' WHERE lasttime > '1506816000000' AND lasttime < '1509494399000'");
$mysqli->query("UPDATE network SET lastseen='November 2017' WHERE lasttime > '1509494400000' AND lasttime < '1512086399000'");
$mysqli->query("UPDATE network SET lastseen='December 2017' WHERE lasttime > '1512086400000' AND lasttime < '1514764799000'");

//if date is not set, update field to let user know. you can use use epochconverter.com to find timestamp (in milliseconds) to update this list yourself
$mysqli->query("UPDATE network SET lastseen='UNKNOWN' WHERE lastseen LIKE ''");

//set icon
$mysqli->query("UPDATE network SET icon='http://www.google.com/mapfiles/ms/micons/blue.png' WHERE CAPABILITIES NOT LIKE '%WEP%' AND CAPABILITIES NOT LIKE '%WPA%'");
$mysqli->query("UPDATE network SET icon='http://www.google.com/mapfiles/ms/micons/red.png' WHERE CAPABILITIES LIKE '%WEP%'");
$mysqli->query("UPDATE network SET icon='http://www.google.com/mapfiles/ms/micons/yellow.png' WHERE CAPABILITIES NOT LIKE '%WEP%' AND CAPABILITIES LIKE '%WPA%' AND CAPABILITIES LIKE '%WPS%'");
$mysqli->query("UPDATE network SET icon='http://www.google.com/mapfiles/ms/micons/green.png' WHERE CAPABILITIES NOT LIKE '%WEP%' AND CAPABILITIES NOT LIKE '%WPS%' AND CAPABILITIES LIKE '%WPA%'");

//set bestlat/bestlon for networks from old version of app, with no "best" position
$mysqli->query("UPDATE network SET bestlat=lastlat WHERE bestlat LIKE '0.000000000000'");
$mysqli->query("UPDATE network SET bestlon=lastlon WHERE bestlon LIKE '0.000000000000'");

//temporary solution to bug. delete networks which were not imported correctly
$mysqli->query("DELETE FROM `network` WHERE frequency LIKE ''");
$mysqli->query("DELETE FROM `network` WHERE capabilities LIKE '2412'
OR capabilities LIKE '2417'
OR capabilities LIKE '2422'
OR capabilities LIKE '2427'
OR capabilities LIKE '2432'
OR capabilities LIKE '2437'
OR capabilities LIKE '2442'
OR capabilities LIKE '2447'
OR capabilities LIKE '2452'
OR capabilities LIKE '2457'
OR capabilities LIKE '2462'
OR capabilities LIKE '2467'
OR capabilities LIKE '2472'
OR capabilities LIKE '2484'
OR capabilities LIKE '5180'
OR capabilities LIKE '5200'
OR capabilities LIKE '5220'
OR capabilities LIKE '5240'
OR capabilities LIKE '5260'
OR capabilities LIKE '5280'
OR capabilities LIKE '5300'
OR capabilities LIKE '5320'
OR capabilities LIKE '5500'
OR capabilities LIKE '5520'
OR capabilities LIKE '5540'
OR capabilities LIKE '5560'
OR capabilities LIKE '5580'
OR capabilities LIKE '5600'
OR capabilities LIKE '5620'
OR capabilities LIKE '5640'
OR capabilities LIKE '5660'
OR capabilities LIKE '5680'
OR capabilities LIKE '5700'
");

//let user know script is completed
echo "script completed";

?>
