<?php

require "dbinfo.php";

// Opens a connection to the MySQL server
$connection = new mysqli("localhost", $username, $password, $database);

if (!$connection) {  die('Not connected : ' . $mysqli->connect_error);}

mysqli_set_charset($connection,"utf8");

$probeQuery = "SELECT bssid FROM bluetooth WHERE vendor IS NULL OR vendor LIKE ''";
$probeResult = $connection->query($probeQuery);

$networksWithNullVendor = $probeResult->num_rows;

if ($networksWithNullVendor > 0) {

  echo $networksWithNullVendor . " rows left without vendor (before the round just completed)<br>";
  echo "Running through loop up to 500 times, updating 500 next 'OUI's<br>";
  echo "All devices matching a particular OUI will be updated at once<br>";
  echo "Press F5 to run script again";
  echo "<br>----------------------------------------------------------------<br>";

  $stopLoop = 0;

  while ($stopLoop == 0) {

    $query = "SELECT bssid FROM bluetooth WHERE vendor IS NULL OR vendor LIKE '' limit 1";
    $result = $connection->query($query);

    $row = $result->fetch_assoc();
    $mac_from_db_trimmed = substr($row["bssid"], 0, 8);

    $url = "https://macvendors.co/api/vendorname/" . urlencode($mac_from_db_trimmed);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);

    if($response !== "No vendor") {

      echo $mac_from_db_trimmed . " - " . $response;
      echo "<br><br>The following command has been run against database:<br><br>";
      echo "UPDATE bluetooth";
      echo "<br>SET vendor='$response'";
      echo "<br>WHERE bssid LIKE '" . $mac_from_db_trimmed . ":__:__:__';";
      echo "<br>----------------------------------------------------------------<br>";

      $query2 = 'UPDATE bluetooth SET vendor="' . $response . '" WHERE bssid LIKE "' . $mac_from_db_trimmed . ':__:__:__";';
      $result2 = $connection->query($query2);

    } else {
      echo $mac_from_db_trimmed . " - UNKNOWN" ;
      echo "<br><br>MAC vendor is unknown. The following command has been run against database:<br><br>";
      echo "UPDATE bluetooth";
      echo "<br>SET vendor='UNKNOWN'<br>";
      echo "WHERE bssid LIKE '" . $mac_from_db_trimmed . ":__:__:__';";
      echo "<br>----------------------------------------------------------------<br>";

      $query3 = "UPDATE bluetooth SET vendor='UNKNOWN' WHERE bssid LIKE '" . $mac_from_db_trimmed . ":__:__:__';";
      $result3 = $connection->query($query3);
    }

    $endOfLoopQuery = "SELECT bssid FROM bluetooth WHERE vendor IS NULL OR vendor LIKE '' limit 1";
    $endOfLoopResult = $connection->query($endOfLoopQuery);
    $networksWithNullVendor = $endOfLoopResult->num_rows;

    if ($networksWithNullVendor == 0) {
      $stopLoop = 1;
      echo "No more devices left with missing vendor! Stopping loop<br>";
    }

    $loopCount++;

    if ($loopCount >= 500) {
      $stopLoop = 1;
    }
  } //END while loop

  echo "Loop completed. Press F5 to start another round";

} //END if rows with blank vendor > 0

else {
  echo "No more devices left with missing vendor!";
}

?>
