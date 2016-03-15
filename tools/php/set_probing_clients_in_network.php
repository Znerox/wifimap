<?php

require("dbinfo.php");

// Opens a connection to a MySQL server
$connection=mysql_connect ('localhost', $username, $password);
if (!$connection) {  die('Not connected : ' . mysql_error());}


// Set the active MySQL database
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}


// Select all the rows in the clients table that has data in "probed_essid"
$probing_network_lookup = "SELECT * FROM clients WHERE probed_essid !=''";
$probing_network_lookup_result = mysql_query($probing_network_lookup);


//run code on each line in the result
while ($row = @mysql_fetch_assoc($probing_network_lookup_result)){

    
    //put all the probed essid for this client into an array
    $probed_essid_array_for_this_client = explode(",", $row['probed_essid']); 
    
    //count how many essid this client has probed
    $probed_essid_number_for_client = count($probed_essid_array_for_this_client);
    
    //run code on each of the probed essid for this client. each one of theese routers have a name that matches the probes from this client!
    for ($i = 0; $i < $probed_essid_number_for_client; $i++) {
        
        //take the probed essid from the client, and get all data on the router from network table
        $specificESSIDQueryOnNetwork = "SELECT * FROM network WHERE BINARY ssid LIKE '$probed_essid_array_for_this_client[$i]'";
        $specificESSIDQueryOnNetworkResult = mysql_query($specificESSIDQueryOnNetwork);
        //$specificESSIDQueryOnNetworkResultArray = @mysql_fetch_assoc($specificESSIDQueryOnNetworkResult);
        
        
        //go thorugh each network with this ssid, there could be multiple!
        while ($routerWithESSIDMatchingClientProbe = @mysql_fetch_assoc($specificESSIDQueryOnNetworkResult)) {
            
            
            //check if the probing_clients field for this router is empty
            if (!$routerWithESSIDMatchingClientProbe['probing_clients']) {
                
                //this router in network has no data (NULL) in probing_clients field, insert data
                mysql_query ("UPDATE network SET probing_clients='$row[client_mac]' WHERE bssid LIKE '$routerWithESSIDMatchingClientProbe[bssid]'");
                //router in network table had NULL data in probing_clients field. added client_mac
                
            } else {
                
                //put all the probing_clients for this network into an array
                $probing_clients_array_for_this_router = explode(",", $routerWithESSIDMatchingClientProbe['probing_clients']);
                
                
                //this router in network has data in probing_clients field, check if this client_mac is present
                if (in_array($row['client_mac'], $probing_clients_array_for_this_router)) {
                    
                    //client_mac already in probing_clients field of router in network, not concatting!
                    
                } else {
                    
                    //this router in network already has some data in probing_clients field, but this client_mac is new. concat new data
                    mysql_query ("UPDATE network SET probing_clients=CONCAT(probing_clients,',$row[client_mac]') WHERE bssid LIKE '$routerWithESSIDMatchingClientProbe[bssid]'");
                    //concatted client_mac to probing_clients field in network table
                    
                }
                
                
            }
            
            
        }//end while loop, kjør kode på hver ruter som har matchende ssid
        
        
    }//end for loop, kjør kode på hver connected router for denne klienten
    
}//end while loop, gå gjennom row data, kode for hver klient som har minst en connected router

echo "script completed";

?>