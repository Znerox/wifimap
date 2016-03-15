<?php

$reached_client_list = false;
$clients_added = 0;
$connected_added = 0;
$probes_added = 0;

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
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// upload complete

require("dbinfo.php");

// Opens a connection to a MySQL server
$mysqli = new mysqli("localhost", $username, $password, $database);

// Change character set to utf8
mysqli_set_charset($mysqli,"utf8");


$handle = fopen("uploads/" . basename( $_FILES["fileToUpload"]["name"]), "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
       
        // this is done on each line in the uploaded document
        
        $first11char = substr($line, 0, 11);
        
        //changes global variable so script know we are past networks, now working on clients
        if (strpos($first11char,'Station MAC') !== false) {
            $reached_client_list = true;
        }

        
        if ($reached_client_list) {
            
            //loks like we're now getting clients, proceed to process data
            if  (substr($line, 2, 1) == ":") {
                
                //looks like a valid client, now put assign variables to data
                $uploaded_network_array = explode(",", $line);
                
                $uploaded_network_array_length = count($uploaded_network_array);
                $uploaded_essid_number = $uploaded_network_array_length - 6;
                
                $uploaded_client_mac = substr($uploaded_network_array[0], 0, 17);
                $uploaded_first_time_seen = substr($uploaded_network_array[1], 1, 19);
                $uploaded_last_time_seen = substr($uploaded_network_array[2], 1, 19);
                $uploaded_power = substr($uploaded_network_array[3], 1, 3);
                $uploaded_number_packets = substr($uploaded_network_array[4], 1, 8);
                $uploaded_router_bssid = substr($uploaded_network_array[5], 1, 17);
                
                $uploaded_probed_essid_1_untrimmed = $uploaded_network_array[6];
                $uploaded_probed_essid_1 = trim($uploaded_probed_essid_1_untrimmed);

                
                if ($uploaded_essid_number > 1) {
                    
                    
                    for ($i = 2;$i <= $uploaded_essid_number; $i++) {
                        

                        $j = $i + 5;    
                        
                        //goal of the following piece of code:
                        //$uploaded_probed_essid_$i = trim($uploaded_network_array[7]);
                        //$uploaded_probed_essid_$i = trim($uploaded_network_array[8]);
                        //etc.
                        
                        
                        $thisProbedEssidTemp = "uploaded_probed_essid_".$i;
                        //really says:
                        //$thisProbedEssidTemp = uploaded_probed_essid_$i;
                        
                        $$thisProbedEssidTemp = trim($uploaded_network_array[$j]);
                        //really says:
                        //$uploaded_probed_essid_$i = trim($uploaded_probed_essid_$i_untrimmed);
                        
                        //ultimately declares:
                        //$uploaded_probed_essid_2 = trim($uploaded_network_array[7]);
                        //$uploaded_probed_essid_3 = trim($uploaded_network_array[8]);
                        //etc.
                        
                    }
                    
                }
      
                
                //Searh for client in database
                $client_query = "SELECT * FROM clients WHERE client_mac LIKE '$uploaded_client_mac'";
                $client_query_result = $mysqli->query($client_query);
                $client_query_result_array = $client_query_result->fetch_assoc();

                
                 //check if the client lookup returned any results
                if (!$client_query_result_array) {
                    
                    
                    //client not found in database, proceeding to add it
                    
                    //If it's a new client, without connected_bssid
                    if ($uploaded_router_bssid == "(not associated) ") {
                        
                        //If it's a new client, without connected_bssid and without probes
                        if ($uploaded_probed_essid_1 == "") {
                            $mysqli->query("INSERT INTO `clients`(client_mac) VALUES ('$uploaded_client_mac')");
                            ++$clients_added;
                            //added new client
                        }
                        
                        //If it's a new client, without connected_bssid and with probes
                        else {  
                            $mysqli->query("INSERT INTO `clients`(client_mac, probed_essid) VALUES ('$uploaded_client_mac','$uploaded_probed_essid_1')");
                            ++$clients_added;
                            //added new client
                            
                            if ($uploaded_essid_number > 1) {
                                
                                for ($i = 2; $i <= $uploaded_essid_number; $i++) {
                                    $probed_essid_to_upload_variable = "uploaded_probed_essid_".$i;
                                    $probed_essid_to_upload = $$probed_essid_to_upload_variable;
                                    $mysqli->query("UPDATE clients SET probed_essid=CONCAT(probed_essid,',$probed_essid_to_upload') WHERE client_mac LIKE '$uploaded_client_mac'");
                                    ++$probes_added;
                                    //added new probe to client   
                                }
       
                            }
        
                            
                        }//END new client, without connected_bssid and with probes
                    }//END new client, without connected_bssid
                    
                    
                    //If it's a new client, with connected_bssid
                    else {
                        
                        
                        //If it's a new client, with connected_bssid and without probes
                        if ($uploaded_probed_essid_1 == "") {
                            
                            $mysqli->query("INSERT INTO `clients`(client_mac, connected_to_bssid) VALUES ('$uploaded_client_mac','$uploaded_router_bssid')");
                            ++$clients_added;
                            //added new client
                        }
                        
                        //If it's a new client, with connected_bssid and with probes
                        else {
                            $mysqli->query("INSERT INTO `clients`(client_mac, connected_to_bssid, probed_essid) VALUES ('$uploaded_client_mac','$uploaded_router_bssid','$uploaded_probed_essid_1')");
                            ++$clients_added;
                            //added new client
                            
                            if ($uploaded_essid_number > 1) {
                                
                                for ($i = 2; $i <= $uploaded_essid_number; $i++) {
                                    $probed_essid_to_upload_variable = "uploaded_probed_essid_".$i;
                                    $probed_essid_to_upload = $$probed_essid_to_upload_variable;
                                    $mysqli->query("UPDATE clients SET probed_essid=CONCAT(probed_essid,',$probed_essid_to_upload') WHERE client_mac LIKE '$uploaded_client_mac'");
                                    ++$probes_added;
                                    //added new probe to client
                                }
                                
                            }       
                            
                        } //end if new client
                        
                    }//END new client, with connected_bssid and with probes 
                    
                    
                } else {
                    
                    //client found in database, update info
                    
                    
                    //Set variables
                    $client_mac_db = $client_query_result_array['client_mac'];
                    $connected_to_bssid_db = $client_query_result_array['connected_to_bssid'];
                    $probed_essid_db = $client_query_result_array['probed_essid'];
                    
                    //this is to fix bug where client uploaded with one probe, '0'. probe would be added again on next run, because 0 is seen as empty probedb. Would also be overwritten if client uploaded with other probed essid at a later time
                    if ($probed_essid_db == '0') {
                        
                        $single_0_in_probedb = true;
                        
                    }

                    
                    //Check if any bssid are posted, then check for probes if no bssid
                    if ($uploaded_router_bssid == "(not associated) ") {
                        //no bssid posted, going to check for posted probes
                    } else {
                        
                        //Checks if posted connected_bssid exists in db
                        if (strpos($connected_to_bssid_db, $uploaded_router_bssid) === false) {
                            
                            if (!$connected_to_bssid_db) {
                                
                                //do this if there is no connected_bssid in db
                                //no connected_bssid in db, trying to add it. Then checking probes
                                $mysqli->query("UPDATE clients SET connected_to_bssid='$uploaded_router_bssid' WHERE client_mac LIKE '$uploaded_client_mac'");
                                ++$connected_added;
                                //added to connected_bssid
                            } else {
                                
                                //do this if there is some connected_bssid in db
                                //connected_bssid not in db, trying to append it. Then checking probes
                                $mysqli->query("UPDATE clients SET connected_to_bssid=CONCAT(connected_to_bssid,',$uploaded_router_bssid') WHERE client_mac LIKE '$uploaded_client_mac'");
                                ++$connected_added;
                                //added to connected_bssid. Then checking probes
                            }
                            
                        } else {
                            
                            //connected_bssid already in db, checking probes
                        
                        }//end if ($uploaded_router_bssid == "(not associated) ")
                        
                        
                    } //end else, if posted connected_to_bssid is blank. end connected_bssid part, next probe part
                    
                    
                    //Check if any probes are posted, finish if none
                    if ($uploaded_probed_essid_1 == "") {
                        //no probes posted, finished with this client
                        
                       
                        } else {

                        
                        //do this if probes are posted
                        
                        //do this if probes are posted, and probe db is blank
                        if (!$probed_essid_db && !$single_0_in_probedb == true) {
         
                            $mysqli->query("UPDATE clients SET probed_essid='$uploaded_probed_essid_1' WHERE client_mac LIKE '$uploaded_client_mac'");
                            ++$probes_added;
                            //added first probe to client, running thorugh loop if there are more probes
                            
                            if ($uploaded_essid_number > 1) {
                                
                                for ($i = 2; $i <= $uploaded_essid_number; $i++) {
                                    $probed_essid_to_upload_variable = "uploaded_probed_essid_".$i;
                                    $probed_essid_to_upload = $$probed_essid_to_upload_variable;
                                    $mysqli->query("UPDATE clients SET probed_essid=CONCAT(probed_essid,',$probed_essid_to_upload') WHERE client_mac LIKE '$uploaded_client_mac'");
                                    ++$probes_added;
                                    //added new probe to client, running thorugh loop again if there are more probes
                                }
                                
                            }
                            
        
                        } //END "probes are posted, and blank probe db"

                        
                        else {
                            
                            //if populated probe db, checks each probe, and add to db if it's new 
                
                            $probed_essid_db_array = explode(",", $probed_essid_db);
            
                            
                            for ($i = 1; $i <= $uploaded_essid_number; $i++) {
                                
                                $probed_essid_to_upload_variable = "uploaded_probed_essid_".$i;
                                $probed_essid_to_upload = $$probed_essid_to_upload_variable;
                                
                                
                                if (in_array($probed_essid_to_upload, $probed_essid_db_array)) {
                                    
                                    //probe already in db, checking next probe
                                }        
                                
                                else {
                                    
                                    //probe not in db, trying to add it
                                    $mysqli->query("UPDATE clients SET probed_essid=CONCAT(probed_essid,',$probed_essid_to_upload') WHERE client_mac LIKE '$uploaded_client_mac'");
                                    ++$probes_added;
                                    //added to probed_essid. checking next probe. after that next client
                                    
                                }//end if-else
                            } //end for, posted_probe                   
                            
                        } //end else, if posted_probe is blank.
                        
                        
                    }//END probes posted                
          
                    
                }
    
                
            }
                   
            
        } else {
            
            //doesn't look like we're past network part yet, start loop over again
        
        }


    }

    fclose($handle);
    echo "script completed";
    echo "<br>";
    echo "<br>";
    echo "New clients added (with or without data): " . $clients_added;
    echo "<br>";
    echo "Connected networks added to client: " . $connected_added;
    echo "<br>";
    echo "Probes added to client: " . $probes_added;
} else {
    // error opening the file.
} 
                                                    
?> 