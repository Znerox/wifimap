<?php

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$FileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000) {
  echo "Sorry, your file is over 50MB.";
  $uploadOk = 0;
}
// Allow certain file formats
if($FileType != "csv" && $FileType != "txt" ) {
  echo "Sorry, only CSV, TXT files are allowed.";
  $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}

require "dbinfo.php";

// Opens a connection to a MySQL server
$mysqli = new mysqli($server, $username, $password, $database);

// Change character set to utf8
mysqli_set_charset($mysqli,"utf8");

$handle = fopen("uploads/" . basename( $_FILES["fileToUpload"]["name"]), "r");
if ($handle) {
  while (($line = fgets($handle)) !== false) {
    // this is done on each line in the uploaded document
    //checks if line is a wifi network / bluetooth device
    if  (substr($line, 2, 1) == ":") {
      //put uploaded data (line) into an array
      $router_data_array = explode(",", $line);
      $router_bssid = $router_data_array[0];
      $router_ssid = $router_data_array[1];
      $router_frequency = $router_data_array[2];
      $router_capabilities = $router_data_array[3];
      $router_lasttime = $router_data_array[4];
      $router_lastlat = $router_data_array[5];
      $router_lastlon = $router_data_array[6];
      $router_type = $router_data_array[7];
      $router_bestlevel = $router_data_array[8];
      $router_bestlat = $router_data_array[9];
      $router_bestlon = substr($router_data_array[10], 0, 11);

      if ($router_type == 'W') {
        //this line is a WiFi network. searh for network in database
        $bssid_query = "SELECT * FROM network WHERE bssid LIKE '$router_bssid'";
        $bssid_query_result = $mysqli->query($bssid_query);
        $bssid_query_result_array = $bssid_query_result->fetch_assoc();

        //check if the bssid lookup returned any results
        if (!$bssid_query_result_array) {
          //BSSID not found in database, proceeding to add it
          $mysqli->query("INSERT INTO `network`(bssid, ssid, frequency, capabilities, lasttime, lastlat, lastlon, type, bestlevel, bestlat, bestlon) VALUES ('$router_bssid', '$router_ssid', '$router_frequency', '$router_capabilities', '$router_lasttime', '$router_lastlat', '$router_lastlon', '$router_type', '$router_bestlevel', '$router_bestlat', '$router_bestlon')");
        } else {
          //BSSID found in database. check if uploaded data is newer than database
          if ($router_lasttime > $bssid_query_result_array['lasttime']) {
            //uploaded data is newer than existing data in db
            //if bssid is  found in database, and uploaded data is newer than database, this updates ssid, frequency, capabilities, lasttime, lastlat, lastlon, type
            $mysqli->query("UPDATE network SET ssid='$router_ssid', frequency='$router_frequency', capabilities='$router_capabilities', lasttime='$router_lasttime', lastlat='$router_lastlat', lastlon='$router_lastlon', type='$router_type' WHERE bssid LIKE '$router_bssid'");

            //check if uploaded SSID matches SSID from db. if changed, overwrite bestlevel/bestlat/bestlon. SSID is changed, so it should be treated like a new network.
            if ($router_ssid == $bssid_query_result_array['ssid']) {
              //SSID has not changed for this network, do nothing more
            } else {
              //check if SSID from db is "[Hidden network]". If it is, and uploaded SSID is blank, it has not changed.
              if ($router_ssid == "" && $bssid_query_result_array['ssid'] == "[Hidden network]") {
                //SSID have not changed, do nothing more
              }
              else {
                //SSID has changed for this network. meaning the same router has been set up like a new network. overwrite bestlevel/bestlat/bestlon, no matter if new bestlevel is lower than db
                $mysqli->query("UPDATE network SET bestlevel='$router_bestlevel', bestlat='$router_bestlat', bestlon='$router_bestlon' WHERE bssid LIKE '$router_bssid'");

                echo "SSID for router: $router_bssid have changed since the network was last seen<br>";
                echo "Treating this BSSID like a brand new network, wiped bestlon/bestlat/bestlevel from db and inserted new values<br>";
                echo "old SSID: $bssid_query_result_array[ssid], new SSID: $router_ssid<br><br>";
                //todo: run code here to update/delete data in clients table. delete this bssid from clients "connected to"
              }
            }
          } else {
            //db data is newer than data being uploaded, do not make any changes to this network. (bestlevel/bestlat/bestlon is checked next, doesn't matter what is newest
          }
          //this is in "BSSID found in database". checks if uploaded SSID matches SSID from db. if it doesn't match, best* should not be overwritten
          if ($router_ssid == $bssid_query_result_array['ssid']) {
            //uploaded SSID matches

            //checks bestlevel, if uploaded value is higher than in database, update bestlevel, bestlat, bestlon.
            if ($router_bestlevel > $bssid_query_result_array['bestlevel']) {
              //uploaded bestlevel higher than existing bestlevel in db
              $mysqli->query("UPDATE network SET bestlevel='$router_bestlevel', bestlat='$router_bestlat', bestlon='$router_bestlon' WHERE bssid LIKE '$router_bssid'");
            }
          }
        } //end BSSID found in database
      } else if ($router_type == 'B' OR $router_type == 'E') {
        //this line is a Bluetooth device. searh for device in database
        $bssid_query = "SELECT * FROM bluetooth WHERE bssid LIKE '$router_bssid'";
        $bssid_query_result = $mysqli->query($bssid_query);
        $bssid_query_result_array = $bssid_query_result->fetch_assoc();

        //check if the bssid lookup returned any results
        if (!$bssid_query_result_array) {
          //BSSID not found in database, proceeding to add it
          $mysqli->query("INSERT INTO `bluetooth`(bssid, ssid, frequency, capabilities, lasttime, lastlat, lastlon, type, bestlevel, bestlat, bestlon) VALUES ('$router_bssid', '$router_ssid', '$router_frequency', '$router_capabilities', '$router_lasttime', '$router_lastlat', '$router_lastlon', '$router_type', '$router_bestlevel', '$router_bestlat', '$router_bestlon')");
        } else {
          //BSSID found in database. check if uploaded data is newer than database
          if ($router_lasttime > $bssid_query_result_array['lasttime']) {
            //uploaded data is newer than existing data in db
            //if bssid is  found in database, and uploaded data is newer than database, frequency, capabilities, lasttime, lastlat, lastlon, type
            $mysqli->query("UPDATE bluetooth SET frequency='$router_frequency', capabilities='$router_capabilities', lasttime='$router_lasttime', lastlat='$router_lastlat', lastlon='$router_lastlon' , type='$router_type' WHERE bssid LIKE '$router_bssid'");

            //this is in "uploaded date is newer than db data". checks if uploaded name matches name from db
            if ($router_ssid != $bssid_query_result_array['ssid']) {
            //uploaded name does not match name stored in db
            if ($bssid_query_result_array['ssid'] == "") {
              //the device is already stored in db with empty name. add a name to it
              $mysqli->query("UPDATE bluetooth SET ssid='$router_ssid' WHERE bssid LIKE '$router_bssid'");
              echo "Name for device: $router_bssid have changed since the device was last seen<br>old name: $bssid_query_result_array[ssid], new name: $router_ssid<br><br>";
            }
          }
        }
        //checks bestlevel, if uploaded value is higher than in database, update bestlevel, bestlat, bestlon.
        if ($router_bestlevel > $bssid_query_result_array['bestlevel']) {
          //uploaded bestlevel higher than existing bestlevel in db
          $mysqli->query("UPDATE bluetooth SET bestlevel='$router_bestlevel', bestlat='$router_bestlat', bestlon='$router_bestlon' WHERE bssid LIKE '$router_bssid'");
          echo "Device with name: $router_ssid and MAC: $router_bssid have had it's 'best' location updated<br><br>";
        }
      } //end BSSID found in database
    }
  } else {
    //this line will be skipped, as it appears to not be a valid mac address
  }
}
  fclose($handle);
  echo "script completed";
} else {
  // error opening the file.
}
?>
