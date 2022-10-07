<?php

require("dbinfo.php");

// Opens a connection to a MySQL server
$mysqli = new mysqli($server, $username, $password, $database);

// Change character set to utf8
mysqli_set_charset($mysqli,"utf8");

// Select all the rows in the clients table that has data in "probed_essid"
$probing_network_lookup = "SELECT * FROM clients WHERE probed_essid !=''";
$probing_network_lookup_result = $mysqli->query($probing_network_lookup);

//run code on each line in the result
while ($row = $probing_network_lookup_result->fetch_assoc()){

  //put all the probed essid for this client into an array
  $probed_essid_array_for_this_client = explode(",", $row['probed_essid']);

  //count how many essid this client has probed
  $probed_essid_number_for_client = count($probed_essid_array_for_this_client);

  //run code on each of the probed essid for this client. each one of theese routers have a name that matches the probes from this client!
  for ($i = 0; $i < $probed_essid_number_for_client; $i++) {

    //take the probed essid from the client, and get all data on the router from network table
    $specificESSIDQueryOnNetwork = "SELECT * FROM network WHERE BINARY ssid LIKE '$probed_essid_array_for_this_client[$i]'";
    $specificESSIDQueryOnNetworkResult = $mysqli->query($specificESSIDQueryOnNetwork);
    //$specificESSIDQueryOnNetworkResultArray = $mysqli->query($specificESSIDQueryOnNetworkResult);

    //go thorugh each network with this ssid, there could be multiple!
    while ($routerWithESSIDMatchingClientProbe = $specificESSIDQueryOnNetworkResult->fetch_assoc()) {

      //check if the probing_clients field for this router is empty
      if (!$routerWithESSIDMatchingClientProbe['probing_clients']) {

        //this router in network has no data (empty/NULL) in probing_clients field, insert data
        $mysqli->query("UPDATE network SET probing_clients='<br>$row[client_mac]<br>' WHERE bssid LIKE '$routerWithESSIDMatchingClientProbe[bssid]'");
        //router in network table had empty/NULL data in probing_clients field. added client_mac
      } else {
        //put all the probing_clients for this network into an array
        $probing_clients_array_for_this_router = preg_split('/<br[^>]*>/i', $routerWithESSIDMatchingClientProbe['probing_clients']);
        //this router in network has data in probing_clients field, check if this client_mac is present
        if (in_array($row['client_mac'], $probing_clients_array_for_this_router)) {

          //client_mac already in probing_clients field of router in network, not concatting!
        } else {
          //this router in network already has some data in probing_clients field, but this client_mac is new. concat new data
          $mysqli->query("UPDATE network SET probing_clients=CONCAT(probing_clients,'$row[client_mac]<br>') WHERE bssid LIKE '$routerWithESSIDMatchingClientProbe[bssid]'");
          //concatted client_mac to probing_clients field in network table
        }
      }
    }//end while loop, run code on each router that has matching ssid
  }//end for loop, run code on each connected router for denne klienten
}//end while loop, go through row data, code for each client that has at least one connected router

echo "script completed";

?>
