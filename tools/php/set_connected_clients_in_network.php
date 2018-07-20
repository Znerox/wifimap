<?php

require("dbinfo.php");

// Opens a connection to a MySQL server
$mysqli = new mysqli("localhost", $username, $password, $database);

// Change character set to utf8
mysqli_set_charset($mysqli,"utf8");

// Select all the rows in the clients table that has data in "connected_to_bssid"
$connected_to_bssid_lookup = "SELECT * FROM clients WHERE connected_to_bssid !=''";
$connected_to_bssid_lookup_result = $mysqli->query($connected_to_bssid_lookup);

//run code on each line in the result
while ($row = $connected_to_bssid_lookup_result->fetch_assoc()){

  //put all the connected bssid for this client into an array
  $connected_bssid_array_for_this_client = explode(",", $row['connected_to_bssid']);

  //count how many bssid this client is connected to
  $connected_bssid_number_for_client = count($connected_bssid_array_for_this_client);

  //run code on each of the connected bssid for this client. each one of theese routers has been connected by this client!
  for ($i = 0; $i < $connected_bssid_number_for_client; $i++) {

    //take the connected bssid from the client, and get all data on the router from network table
    $specificBSSIDQueryOnNetwork = "SELECT * FROM network WHERE bssid LIKE '$connected_bssid_array_for_this_client[$i]'";
    $specificBSSIDQueryOnNetworkResult = $mysqli->query($specificBSSIDQueryOnNetwork);
    $specificBSSIDQueryOnNetworkResultArray = $specificBSSIDQueryOnNetworkResult->fetch_assoc();

    //check if the connected_clients field for this router is empty
    if (!$specificBSSIDQueryOnNetworkResultArray['connected_clients']) {

      //this bssid in network has no data (empty/NULL) in connected_clients field, insert data
      $mysqli->query("UPDATE network SET connected_clients='<br>$row[client_mac]<br>' WHERE bssid LIKE '$connected_bssid_array_for_this_client[$i]'");
      //bssid in network table had empty/NULL data in connected_clients field. added client_mac
    } else {
      //put all the connected_clients for this network into an array
      $connected_clients_array_for_this_bssid = preg_split('/<br[^>]*>/i', $specificBSSIDQueryOnNetworkResultArray['connected_clients']);

      //this bssid in network has data in connected_clients field, check if this client_mac is present
      if (in_array($row['client_mac'], $connected_clients_array_for_this_bssid)) {
        //client_mac already in connected_clients field of bssid in network, not concatting!
      } else {
        //this bssid in network already has some data in connected_clients field, but this client_mac is new. concat new data
        $mysqli->query("UPDATE network SET connected_clients=CONCAT(connected_clients,'$row[client_mac]<br>') WHERE bssid LIKE '$connected_bssid_array_for_this_client[$i]'");
        //concatted client_mac to connected_clients field in network table
      }
    }
  }//end for loop, run code on each connected bssid for this client
}//end while loop, go through row data, code for each client that has at least one connected bssids

echo "script completed";

?>
