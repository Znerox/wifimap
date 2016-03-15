<?php

require("dbinfo.php");

// Opens a connection to a MySQL server
$connection = new mysqli("localhost", $username, $password, $database);
    
if (!$connection) {  die('Not connected : ' . mysql_error());}

mysqli_set_charset($connection,"utf8");

$probeQuery = "SELECT bssid FROM network WHERE vendor IS NULL OR vendor LIKE ''";
$probeResult = $connection->query($probeQuery);

$networksWithNullVendor = $probeResult->num_rows;

if ($networksWithNullVendor > 0) {
    
    echo $networksWithNullVendor . " rows left without vendor (before the round just completed)";
    echo "<br>";
    echo "Running through loop up to 500 times, updating 500 next 'OUI's";
    echo "<br>";
    echo "All routers matching a particular OUI will be updated at once";
    echo "<br>";
    echo "Press F5 to run script again";
    echo "<br>";
    echo "----------------------------------------------------------------";
    echo "<br>";
    
    $stopLoop = 0;
    
    while ($stopLoop == 0) {
        
        $query = "SELECT bssid FROM network WHERE vendor IS NULL OR vendor LIKE '' limit 1";
        $result = $connection->query($query);        
        
        $row = $result->fetch_assoc();
        $mac_from_db_trimmed = substr($row["bssid"], 0, 8);  
        
        $url = "http://api.macvendors.com/" . urlencode($mac_from_db_trimmed);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        if($response) {
            
            echo $mac_from_db_trimmed . " - " . $response;
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "The following command has been run against database:";
            echo "<br>";
            echo "<br>";
            echo "UPDATE network";
            echo "<br>";
            echo "SET vendor='$response'";
            echo "<br>";
            echo "WHERE bssid LIKE '" . $mac_from_db_trimmed . ":__:__:__';";
            echo "<br>";
            echo "----------------------------------------------------------------";
            echo "<br>";
            
            $query2 = 'UPDATE network SET vendor="' . $response . '" WHERE bssid LIKE "' . $mac_from_db_trimmed . ':__:__:__";';
            $result2 = $connection->query($query2);
        
            
        } else {
            echo $mac_from_db_trimmed . " - UNKNOWN" ;
            echo "<br>";
            echo "<br>";
            echo "MAC vendor is unknown. The following command has been run against database:";
            echo "<br>";
            echo "<br>";
            echo "UPDATE network";
            echo "<br>";
            echo "SET vendor='UNKNOWN'";
            echo "<br>";
            echo "WHERE bssid LIKE '" . $mac_from_db_trimmed . ":__:__:__';";
            echo "<br>";
            echo "----------------------------------------------------------------";
            echo "<br>";
            
            $query3 = "UPDATE network SET vendor='UNKNOWN' WHERE bssid LIKE '" . $mac_from_db_trimmed . ":__:__:__';";
            $result3 = $connection->query($query3);
        }
        
        $endOfLoopQuery = "SELECT bssid FROM network WHERE vendor IS NULL OR vendor LIKE '' limit 1";
        $endOfLoopResult = $connection->query($endOfLoopQuery);
        $networksWithNullVendor = $endOfLoopResult->num_rows;
       
        if ($networksWithNullVendor == 0) {
            $stopLoop = 1;
            echo "No more networks left with missing vendor! Stopping loop";
            echo "<br>";
        } 
        
        $loopCount++;
        
        if ($loopCount >= 500) {
            $stopLoop = 1;
        }
        
    } //END while loop
    
    echo "Loop completed. Press F5 to start another round";    
    
} //END if rows with blank vendor > 0

else {
    
    echo "No more clients left with missing vendor!";
}

?>