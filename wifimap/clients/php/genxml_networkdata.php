<?php

require("dbinfo.php");

//create empty arrays
$bssidOfConnectedNetworksArray = [];
$essidOfConnectedNetworksArray = [];

// Start XML file, create parent node
$dom = new DOMDocument("1.0", "UTF-8");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server
$mysqli = new mysqli($server, $username, $password, $database);

// Set character set to utf8
mysqli_set_charset($mysqli,"utf8");

//------------------------------------------------
// Run through each posted bssid and get data
// from database
//------------------------------------------------
$postedBssidString = $_POST['connected_to_bssid'];
$postedBssidArray = explode(",", $postedBssidString);
$postedBssidArrayLength = count($postedBssidArray);

for ($i = 0; $i < $postedBssidArrayLength; $i++) {
  $postedBssidForQuery = $postedBssidArray[$i];
  $query_connected = "SELECT * FROM network WHERE
  BSSID LIKE '$postedBssidForQuery'
  ";

  $result_connected = $mysqli->query($query_connected);

  header("Content-type: text/xml;charset=UTF-8");

  // Iterate through the rows, adding XML nodes for each
  while ($row = $result_connected->fetch_assoc()){
    array_push ($bssidOfConnectedNetworksArray, $row['bssid']);
    array_push ($essidOfConnectedNetworksArray, $row['ssid']);

    // Run this code if "show connected" checkbox is checked
    if ($_POST['show_connected'] == "yes") {
      // ADD TO XML DOCUMENT NODE
      $node = $dom->createElement("marker");
      $newnode = $parnode->appendChild($node);
      $newnode->setAttribute("BSSID", $row['bssid']);
      $newnode->setAttribute("SSID", $row['ssid']);
      $newnode->setAttribute("FREQUENCY", $row['frequency']);
      $newnode->setAttribute("CAPABILITIES", $row['capabilities']);
      $newnode->setAttribute("LASTLAT", $row['lastlat']);
      $newnode->setAttribute("LASTLON", $row['lastlon']);
      $newnode->setAttribute("BESTLEVEL", $row['bestlevel']);
      $newnode->setAttribute("BESTLAT", $row['bestlat']);
      $newnode->setAttribute("BESTLON", $row['bestlon']);
      $newnode->setAttribute("CHANNEL", $row['channel']);
      $newnode->setAttribute("VENDOR", $row['vendor']);
      $newnode->setAttribute("LASTSEEN", $row['lastseen']);
      $newnode->setAttribute("ICON", "http://www.google.com/mapfiles/ms/micons/green.png");
      $newnode->setAttribute("CONNECTED_CLIENTS", $row['connected_clients']);
      $newnode->setAttribute("PROBING_CLIENTS", $row['probing_clients']);
      }// END 'if "show connected" checkbox is checked'

    }

}
//------------------------------------------------
// END each posted bssid
//------------------------------------------------

// Run this code if "show probing" checkbox is checked
if ($_POST['show_probing'] == "yes") {
  //------------------------------------------------
  // Run through each posted essid and get data
  // from database
  //------------------------------------------------
  $postedEssidString = $_POST['probed_essid'];
  $postedEssidArray = explode(",", $postedEssidString);
  $postedEssidArrayLength = count($postedEssidArray);

  for ($i = 0; $i < $postedEssidArrayLength; $i++) {
    $postedEssidForQuery = $postedEssidArray[$i];

    $query_probing = "SELECT * FROM network WHERE
    SSID LIKE BINARY '$postedEssidForQuery'
    ";

    $result_probing = $mysqli->query($query_probing);

    header("Content-type: text/xml;charset=UTF-8");

    // Iterate through the rows, adding XML nodes for each
    while ($row = $result_probing->fetch_assoc()){
      if (in_array($row['bssid'], $bssidOfConnectedNetworksArray)) {
        //this bssid from query is in $bssidOfConnectedNetworksArray, meaning that the client is connected to this network.
        //therefore this row will not be added to XML.
        } else {
          if (in_array($row['ssid'], $essidOfConnectedNetworksArray)) {
            //this ssid from query is in $essidOfConnectedNetworksArray, meaning it is very unlikely
            //the client has ever used this network. therefore it will be marked with a red marker,
            //if checkbox is checked and user want to see theese results

            if ($_POST['show_false_positives'] == "yes") {
              // ADD TO XML DOCUMENT NODE
              $node = $dom->createElement("marker");
              $newnode = $parnode->appendChild($node);
              $newnode->setAttribute("BSSID", $row['bssid']);
              $newnode->setAttribute("SSID", $row['ssid']);
              $newnode->setAttribute("FREQUENCY", $row['frequency']);
              $newnode->setAttribute("CAPABILITIES", $row['capabilities']);
              $newnode->setAttribute("LASTLAT", $row['lastlat']);
              $newnode->setAttribute("LASTLON", $row['lastlon']);
              $newnode->setAttribute("BESTLEVEL", $row['bestlevel']);
              $newnode->setAttribute("BESTLAT", $row['bestlat']);
              $newnode->setAttribute("BESTLON", $row['bestlon']);
              $newnode->setAttribute("CHANNEL", $row['channel']);
              $newnode->setAttribute("VENDOR", $row['vendor']);
              $newnode->setAttribute("LASTSEEN", $row['lastseen']);
              $newnode->setAttribute("ICON", "../images/red.png");
              $newnode->setAttribute("CONNECTED_CLIENTS", $row['connected_clients']);
              $newnode->setAttribute("PROBING_CLIENTS", $row['probing_clients']);
              }

              } else {
                // ADD TO XML DOCUMENT NODE
                $node = $dom->createElement("marker");
                $newnode = $parnode->appendChild($node);
                $newnode->setAttribute("BSSID", $row['bssid']);
                $newnode->setAttribute("SSID", $row['ssid']);
                $newnode->setAttribute("FREQUENCY", $row['frequency']);
                $newnode->setAttribute("CAPABILITIES", $row['capabilities']);
                $newnode->setAttribute("LASTLAT", $row['lastlat']);
                $newnode->setAttribute("LASTLON", $row['lastlon']);
                $newnode->setAttribute("BESTLEVEL", $row['bestlevel']);
                $newnode->setAttribute("BESTLAT", $row['bestlat']);
                $newnode->setAttribute("BESTLON", $row['bestlon']);
                $newnode->setAttribute("CHANNEL", $row['channel']);
                $newnode->setAttribute("VENDOR", $row['vendor']);
                $newnode->setAttribute("LASTSEEN", $row['lastseen']);
                $newnode->setAttribute("ICON", "../images/yellow.png");
                $newnode->setAttribute("CONNECTED_CLIENTS", $row['connected_clients']);
                $newnode->setAttribute("PROBING_CLIENTS", $row['probing_clients']);
                }

            }

        }// END while loop '$row = $result_probing->fetch_assoc'

    } //END for
    //------------------------------------------------
    // END each posted essid
    //------------------------------------------------

}// END 'if "show probing" checkbox is checked'

echo $dom->saveXML();

?>
