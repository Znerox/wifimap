<?php

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$FileType = pathinfo($target_file,PATHINFO_EXTENSION);

/*
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
*/

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
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// upload complete

require "dbinfo.php";

// Opens a connection to a MySQL server
$mysqli = new mysqli("localhost", $username, $password, $database);

// Change character set to utf8
mysqli_set_charset($mysqli,"utf8");


$handle = fopen("uploads/" . basename( $_FILES["fileToUpload"]["name"]), "r");
if ($handle) {    
    while (($line = fgets($handle)) !== false) {
       
        // this is done on each line in the uploaded document
        
        
        //checks if line is a wifi network
        if  (substr($line, 3, 1) == ":") {
            
            
            //put uploaded data (line) into an array
            $uploaded_network_array = explode(",", $line);
            //$firephp->log($uploaded_network_array);
            $uploaded_bssid = substr($uploaded_network_array[0], 1, -1);
            $uploaded_ssid = substr($uploaded_network_array[1], 1, -1);
            $uploaded_frequency = substr($uploaded_network_array[2], 1, -1);
            $uploaded_capabilities = substr($uploaded_network_array[3], 1, -1);
            $uploaded_lasttime = substr($uploaded_network_array[4], 1, -1);
            $uploaded_lastlat = substr($uploaded_network_array[5], 1, -1);
            $uploaded_lastlon = substr($uploaded_network_array[6], 1, -1);
            $uploaded_bestlevel = substr($uploaded_network_array[8], 1, -1);
            $uploaded_bestlat = substr($uploaded_network_array[9], 1, -1);
            $uploaded_bestlon = substr($uploaded_network_array[10], 1, 11);
            
            
            //Searh for network in database
            $bssid_query = "SELECT * FROM network WHERE bssid LIKE '$uploaded_bssid'";
            $bssid_query_result = $mysqli->query($bssid_query);
            $bssid_query_result_array = $bssid_query_result->fetch_assoc();
            
            
            //check if the bssid lookup returned any results
            if (!$bssid_query_result_array) {
                
                //bssid not found in database, proceeding to add it
                $mysqli->query("INSERT INTO `network`(bssid, ssid, frequency, capabilities, lasttime, lastlat, lastlon, bestlevel, bestlat, bestlon) VALUES ('$uploaded_bssid', '$uploaded_ssid', '$uploaded_frequency', '$uploaded_capabilities', '$uploaded_lasttime', '$uploaded_lastlat', '$uploaded_lastlon', '$uploaded_bestlevel', '$uploaded_bestlat', '$uploaded_bestlon')");
                
                
            } else {
                
                //bssid found in database
                
                
                //check if uploaded data is newer than database
                if ($uploaded_lasttime > $bssid_query_result_array[lasttime]) {
                    
                    //if bssid is  found in database, and uploaded data is newer than database, this updates ssid, frequency, capabilities, lasttime, lastlat, lastlon
                   $mysqli->query("UPDATE network SET ssid='$uploaded_ssid', frequency='$uploaded_frequency', capabilities='$uploaded_capabilities', lasttime='$uploaded_lasttime', lastlat='$uploaded_lastlat', lastlon='$uploaded_lastlon' WHERE bssid LIKE '$uploaded_bssid'");
                    
                } else {
                    
                    //existing data is newer than data being uploaded, do not make any changes to this network. (bestlevel/bestlat/bestlon is checked next, doesn't matter what is newest
                    
                }
                
                
                //checks bestlevel, if uploaded value is higher than in database, update bestlevel, bestlat, bestlon
                if ($uploaded_bestlevel > $bssid_query_result_array[bestlevel]) {
                    //$firephp->log("uploaded bestlevel is higher than bestlevel in database");
                    $mysqli->query("UPDATE network SET bestlevel='$uploaded_bestlevel', bestlat='$uploaded_bestlat', bestlon='$uploaded_bestlon' WHERE bssid LIKE '$uploaded_bssid'");
                }
                      
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