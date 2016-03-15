function help_click(div, txt) {
    if (div.innerHTML == "") div.innerHTML = "<br/>   " + txt; else div.innerHTML = "";
}

//------------------------------------------------
// setVariables function, is called when
// page is first loaded
//------------------------------------------------
function setVariables() {
    
    searchinput=document.getElementById("searchinput").value;
    connected_to_bssid = "";
    probed_essid = "";
    markersarray = [];
    
    show_connected = "yes";
    show_probing = "yes";
    dont_show_probe_matching_connected = "yes";
    
    activeSite = "clients";
    loadSettings();
  }
//------------------------------------------------
// END setVariables function
//------------------------------------------------


//------------------------------------------------
// deleteMarkers function
//
// Is called when search button is clicked.
// It deletes existing markers, resets variables,
// resets field on the side, then calls 'load'
//------------------------------------------------
function deleteMarkers() {
    
    for (i = 0; i < markersarray.length; i++) {
        markersarray[i].setMap(null);
    }
    
    searchinput=document.getElementById("searchinput").value;
    
    if (document.getElementById("show_connected").checked)
    {show_connected = "yes"; }
    else
    {show_connected = "no"; }
    
    if (document.getElementById("show_probing").checked)
    {show_probing = "yes"; }
    else
    {show_probing = "no"; }
    
    if (document.getElementById("dont_show_probe_matching_connected").checked)
    {dont_show_probe_matching_connected = "yes"; }
    else
    {dont_show_probe_matching_connected = "no"; }
    
    connected_to_bssid = "";
    probed_essid = "";
    
    client_mac = "";
    vendor = "";
    connected_to_bssid = "";
    probed_essid = "";
    
    $(mac_field).html(client_mac);
    $(vendor_field).html(vendor);
    $(connected_field).html(connected_to_bssid);
    $(probing_field).html(probed_essid);
    
    load();
    
}
//------------------------------------------------
// END deleteMarkers function
//------------------------------------------------


//This runs when page is loaded, after variables are set
function load() {
    
    
    map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(mapCenterLatitude,mapCenterLongitude),
        zoom: 12,
        mapTypeId: 'roadmap'
      });
        
        
        var styleArray = [
            {
                "featureType": "administrative.locality",
                "stylers": [
                    { "visibility": "off" }
                ]
            },{
                "featureType": "landscape.natural",
                "elementType": "geometry.fill",
                "stylers": [
                    { "gamma": 0.5 }
                ]
            },{
                "featureType": "landscape.natural",
                "elementType": "labels.text",
                "stylers": [
                    { "visibility": "off" }
                ]
            },{
                "featureType": "poi.attraction",
                "stylers": [
                    { "visibility": "off" }
                ]
            },{
                "featureType": "poi.business",
                "stylers": [
                    { "visibility": "off" }
                ]
            },{
                "featureType": "poi.place_of_worship",
                "stylers": [
                    { "visibility": "off" }
                ]
            },{
                "featureType": "poi.sports_complex",
                "stylers": [
                    { "visibility": "off" }
                ]
            },{
                "featureType": "road.local",
                "elementType": "geometry",
                "stylers": [
                    { "gamma": 2.0 }
                ]
            },{
                "featureType": "transit.station.airport",
                "elementType": "labels.icon",
                "stylers": [
                    { "visibility": "off" }
                ]
            },{
                "featureType": "water",
                "elementType": "geometry.fill",
                "stylers": [
                    { "gamma": 0.5 },
                    { "weight": 0.1 }
                ]
            }         
        ];
    
    
    map.setOptions({styles: styleArray});
    
    infoWindow = new google.maps.InfoWindow;
        
    
    downloadUrl_clientdata("php/genxml_clientdata.php", function(data) {
        var xml_clientdata = data.responseXML;
        clients = xml_clientdata.documentElement.getElementsByTagName("client");
        
        client_mac = clients[0].getAttribute("client_mac");
        vendor = clients[0].getAttribute("vendor");
        connected_to_bssid = clients[0].getAttribute("connected_to_bssid");
        probed_essid = clients[0].getAttribute("probed_essid");
        
        
        $(mac_field).html(client_mac);
        $(vendor_field).html(vendor);
        

        //------------------------------------------------
        // This piece of code first prints the 1st connected,
        // then adds newline and prints the next if more
        //------------------------------------------------
        connectedBssidArray = connected_to_bssid.split(','); 
        
        $(connected_field).html(connectedBssidArray[0]);
        
        if (connectedBssidArray.length > 1) {
            
            for (var i = 1; i < connectedBssidArray.length; i++) {
                
                $(connected_field).append('<br>' + connectedBssidArray[i]);
                
            }
             
        }
        //------------------------------------------------
        // END
        //------------------------------------------------
        

        //------------------------------------------------
        // This piece of code first prints the 1st probe,
        // then adds newline and prints the next if more
        //------------------------------------------------
        probedEssidArray = probed_essid.split(',');
        
        $(probing_field).html(probedEssidArray[0]);
        
        if (probedEssidArray.length > 1) {
            
            for (var i = 1; i < probedEssidArray.length; i++) {
                
                $(probing_field).append('<br>' + probedEssidArray[i]);
                
            }
             
        }
        //------------------------------------------------
        // END
        //------------------------------------------------
        
        getNetworkData();
        
    }); //END OF downloadUrl_clientdata
    
    
    } //END OF LOAD


//------------------------------------------------
// MISC FUNCTIONS BELOW HERE
//------------------------------------------------





//------------------------------------------------
// START getNetworkData function (not actual
// function, but launching, from within clientdata)
//------------------------------------------------
function getNetworkData() {
    
    downloadUrl_networkdata("php/genxml_networkdata.php", function(data) {
        var xml_networkdata = data.responseXML;
        markers = xml_networkdata.documentElement.getElementsByTagName("marker");
        
        
        //This is array for markerclusterer?
        markersarray = [];
        
        var markersLength =  markers.length;
        
        for (var i = 0; i < markersLength; i++) {
            var BSSID = markers[i].getAttribute("BSSID");
            var VENDOR = markers[i].getAttribute("VENDOR");
            var SSID = markers[i].getAttribute("SSID");
            var FREQUENCY = markers[i].getAttribute("FREQUENCY");
            var CHANNEL = markers[i].getAttribute("CHANNEL");
            var CAPABILITIES = markers[i].getAttribute("CAPABILITIES");
            var ICON = markers[i].getAttribute("ICON");
            var LASTSEEN = markers[i].getAttribute("LASTSEEN");
            var LASTLAT = markers[i].getAttribute("LASTLAT");
            var LASTLON = markers[i].getAttribute("LASTLON");
            var TYPE = markers[i].getAttribute("TYPE");
            var BESTLEVEL = markers[i].getAttribute("BESTLEVEL");
            var BESTLAT = markers[i].getAttribute("BESTLAT");
            var BESTLON = markers[i].getAttribute("BESTLON");
            var CONNECTED_CLIENTS = markers[i].getAttribute("CONNECTED_CLIENTS");
            var PROBING_CLIENTS = markers[i].getAttribute("PROBING_CLIENTS");
            
            
            var point = new google.maps.LatLng(
                parseFloat(BESTLAT),
                parseFloat(BESTLON));
            
            
            var BSSIDFunctionFriendly = '"' + BSSID + '"';
            var SSIDFunctionFriendly = '"' + SSID + '"';
            
            
            //This is the pop-up window that appears when clicking on a network
            var html = "<b>" + SSID + "</b> <br>" + BSSID + "<br>" + VENDOR + "<br>" + "<br>" + CAPABILITIES + "<br>" + "Kanal: " + CHANNEL + " (" + FREQUENCY + " MHz)" + "<br>" + "Signal: " + BESTLEVEL + " dBm" + "<br>" + "Sist sett: " + LASTSEEN + "<br>" + "<br>" + "Connected clients: " + "<b>" + CONNECTED_CLIENTS + "</b>" + "<br>" + "Probing clients: " + "<b>" + PROBING_CLIENTS + "</b>" + "<br>" + "<input type='button' onclick='getLocation(" + BSSIDFunctionFriendly + ");' value='Precise location' class='infoWindowSearchButton'>";
            
            marker = new google.maps.Marker({
                map: map,
                position: point,
                icon: ICON
            });
            
            
            bindInfoWindow(marker, map, infoWindow, html);
            markersarray.push(marker);
            
            
        } //END FOR LOOP
     
        
    }); //END of downloadUrl_networkdata
        
        
    }; 
//------------------------------------------------
// END getNetworkData function (not actual function
// but launching, from within clientdata)
//------------------------------------------------





//------------------------------------------------
//bindInfoWindow function
//------------------------------------------------

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

//------------------------------------------------
//END bindInfoWindow function
//------------------------------------------------


//------------------------------------------------
//downloadUrl_clientdata function
//------------------------------------------------

    function downloadUrl_clientdata(url, callback) {

        var request = new XMLHttpRequest();
            
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };
        
 
        request.open('POST', url, true);
        request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        request.send("searchinput="+searchinput);
        
    }
	
//------------------------------------------------
//END downloadUrl_clientdata function
//------------------------------------------------


//------------------------------------------------
//downloadUrl_networkdata function
//------------------------------------------------

    function downloadUrl_networkdata(url, callback) {

        var request = new XMLHttpRequest();
            
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };
        
 
        request.open('POST', url, true);
        request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        request.send("connected_to_bssid="+connected_to_bssid+"&"+"probed_essid="+probed_essid+"&"+"show_connected="+show_connected+"&"+"show_probing="+show_probing+"&"+"dont_show_probe_matching_connected="+dont_show_probe_matching_connected);
        
    }
	
//------------------------------------------------
//END downloadUrl_networkdata function
//------------------------------------------------


//------------------------------------------------
// getLocation function
// 
// opens a new tab with location of network
//------------------------------------------------
function getLocation (BSSIDFunctionFriendly) {
    
    bssid = BSSIDFunctionFriendly;
    locationWindow = window.open(locationPageAddress);
}
//------------------------------------------------
// END getLocation function
//------------------------------------------------

    function doNothing() {}