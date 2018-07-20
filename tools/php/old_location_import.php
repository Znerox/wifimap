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

require("dbinfo.php");

// Opens a connection to a MySQL server
$mysqli = new mysqli("localhost", $username, $password, $database);

// Change character set to utf8
mysqli_set_charset($mysqli,"utf8");

$handle = fopen("uploads/" . basename( $_FILES["fileToUpload"]["name"]), "r");
if ($handle) {
  while (($line = fgets($handle)) !== false) {
    // this is done on each line in the uploaded document
    //put uploaded data (line) into an array
    $uploaded_location_data_array = explode(",", $line);
    $uploaded_bssid = substr($uploaded_location_array[1], 1, -1);
    $uploaded_level = substr($uploaded_location_array[2], 1, -1);
    $uploaded_lat = substr($uploaded_location_array[3], 1, -1);
    $uploaded_lon = substr($uploaded_location_array[4], 1, -1);
    $uploaded_altitude = substr($uploaded_location_array[5], 1, -1);
    $uploaded_accuracy = substr($uploaded_location_array[6], 1, -1);
    $uploaded_time = substr($uploaded_location_array[7], 1, 13);

    //checks if line is a wifi network
    if  (substr($uploaded_bssid, 2, 1) == ":") {
      //check if database contains line with same bssid and timestamp
      $database_query = "SELECT * FROM location WHERE bssid LIKE '$uploaded_bssid' AND time LIKE '$uploaded_time'";
      $database_query_result = $mysqli->query($database_query);
      $database_query_result_array = $database_query_result->fetch_assoc();

      //check if there were any results
      if (!$database_query_result_array) {
        //no results found, adding location info to database
        $mysqli->query("INSERT INTO `location`(bssid, level, lat, lon, altitude, accuracy, time) VALUES ('$uploaded_bssid', '$uploaded_level', '$uploaded_lat', '$uploaded_lon', '$uploaded_altitude', '$uploaded_accuracy', '$uploaded_time')");
      } else {
        //database contains line with same bssid/timestamp. assuming it's a duplicate, will not be uploading this line
      }
    } else {
      //doesn't look like a valid wifi network, will not upload this
    }
  }

fclose($handle);
echo "script completed";
} else {
  // error opening the file.
}

?>
