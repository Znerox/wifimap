<?php

$OUI_file = "uploads/oui.txt";
$file_contents = file_get_contents($OUI_file);
$loopCount = 0;
$targetLoopCount = 1000;

// Check if the file exists
if($file_contents === FALSE) {
  echo "OUI.txt file not found, please make sure it exists<br><br><br>";
}

require "dbinfo.php";

// Opens a connection to the MySQL server
$connection = new mysqli($server, $username, $password, $database);

if (!$connection) {  die('Not connected : ' . $mysqli->connect_error);}

mysqli_set_charset($connection,"utf8");

// Do an initial database search for bluetooth devices with missing vendor
$probeQuery = "SELECT bssid FROM bluetooth WHERE vendor IS NULL OR vendor LIKE ''";
$probeResult = $connection->query($probeQuery);

$devicesWithNullVendor = $probeResult->num_rows;

if ($devicesWithNullVendor > 0) {

  echo $devicesWithNullVendor . " rows left without vendor (before the round just completed)<br>";
  echo "Running through loop up to " . $targetLoopCount . " times, updating " . $targetLoopCount . " next 'OUI's<br>";
  echo "All routers matching a particular OUI will be updated at once<br>";
  echo "Press F5 to run script again";
  echo "<br>----------------------------------------------------------------<br>";
  echo "Found vendors:<br><br>";

  $stopLoop = 0;

  while ($stopLoop == 0) {

    // Find bluetooth devices in the database without vendor information
    $query = "SELECT bssid FROM bluetooth WHERE vendor IS NULL OR vendor LIKE '' limit 1";
    $result = $connection->query($query);
    $row = $result->fetch_assoc();
    $mac_from_db_trimmed = substr($row["bssid"], 0, 8);

    // Make a string that matches the format in the OUI file
    $searchfor_lowercase = substr($mac_from_db_trimmed, 0, 2) . "-" . substr($mac_from_db_trimmed, 3, 2) . "-" . substr($mac_from_db_trimmed, 6, 2);
    $searchfor = strtoupper($searchfor_lowercase);

    // Escape special characters in the query
    $pattern = preg_quote($searchfor, '/');

    // Finalise the regular expression, matching the whole line
    $pattern = "/^.*$pattern.*\$/m";

    // Take the formatted OUI from database, search for it in OUI.txt file, output result to $match
    if(preg_match($pattern, $file_contents, $match)){

      // Find the length of the line. This varies based on the vendor name
      $length_of_found_vendor = strlen(implode ($match));

      // Vendor name starts at position 18. There is a blank space at the end of the line, therefore the length is length-1
      $vendor_name = substr(implode ($match), 18, $length_of_found_vendor - 19);

      // Output found vendor information to webpage
      echo $mac_from_db_trimmed . " - " . $vendor_name . "<br>";

      // Update database with found vendor, for all bluetooth devices containing this OUI
      $query2 = 'UPDATE bluetooth SET vendor="' . $vendor_name . '" WHERE bssid LIKE "' . $mac_from_db_trimmed . ':__:__:__";';
      $result2 = $connection->query($query2);
    }
    else{
      echo "No matches found - " . $mac_from_db_trimmed . " - UNKNOWN<br>";

      // This OUI was not found in OUI.txt file. Update database with UNKNOWN as vendor
      $query3 = "UPDATE bluetooth SET vendor='UNKNOWN' WHERE bssid LIKE '" . $mac_from_db_trimmed . ":__:__:__';";
      $result3 = $connection->query($query3);
    }

    // Check if there are still bluetooth devices in database with missing vendor information
    $endOfLoopQuery = "SELECT bssid FROM bluetooth WHERE vendor IS NULL OR vendor LIKE '' limit 1";
    $endOfLoopResult = $connection->query($endOfLoopQuery);
    $devicesWithNullVendor = $endOfLoopResult->num_rows;

    // Stop the loop if there are no bluetooth devices in database with missing vendor information
    if ($devicesWithNullVendor == 0) {
      $stopLoop = 1;
      echo "No more devices left with missing vendor! Stopping loop<br>";
    }

    $loopCount++;

    if ($loopCount >= $targetLoopCount) {
      $stopLoop = 1;
    }
  } //END while loop

  echo "<br>Loop completed. Press F5 to start another round";

} //END if rows with blank vendor > 0

else {
  echo "No more devices left with missing vendor!";
}

?>
