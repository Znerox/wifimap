//------------------------------------------------
// setVariables function, is called when
// page is first loaded
//------------------------------------------------
  function setVariables() {
    bssid = window.opener.bssid;
    bestLevel = "-100";
    bestLat = "69.665";
    bestLon = "18.955";
      
    activeSite = "location";
    loadSettings();
  }
//------------------------------------------------
// END setVariables function
//------------------------------------------------
        

//------------------------------------------------
// deleteMarkers function
//
// Is called when search button is clicked.
// It deletes existing markers, sets variable,
// then calls 'load'
//------------------------------------------------
  function deleteMarkers() {
      for(i = 0; i < markersarray.length; i++) {
          markersarray[i].setMap(null);
      }
      
      bssid=document.getElementById("searchinput").value;
      
      load();
  }
//------------------------------------------------
// END deleteMarkers function
//------------------------------------------------
        
        
//This runs when page is loaded, after variables are set
    function load() {
      map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(mapCenterLatitude,mapCenterLongitude),
        zoom: 18,
        mapTypeId: 'hybrid'
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
        
        var infoWindow = new google.maps.InfoWindow;  
        
        
downloadUrl("php/genxml.php", function(data) {
  var xml = data.responseXML;
  markers = xml.documentElement.getElementsByTagName("marker");
    
  markersarray = [];
    
  for (var i = 0; i < markers.length; i++) {
    var BSSID = markers[i].getAttribute("BSSID");
	var LEVEL = markers[i].getAttribute("LEVEL");
	var LAT = markers[i].getAttribute("LAT");
	var LON = markers[i].getAttribute("LON");
	var ACCURACY = markers[i].getAttribute("ACCURACY");
	var MONTH_SEEN = markers[i].getAttribute("MONTH_SEEN");
    
    if (LEVEL > bestLevel) {
        bestLevel = LEVEL;
        bestLat = LAT;
        bestLon = LON; }
      
    
    if (LEVEL > -80)
    {icon = "http://www.google.com/mapfiles/ms/micons/green.png"}
	else if (LEVEL >= -90)
    {icon = "http://www.google.com/mapfiles/ms/micons/yellow.png"}
    else
    {icon = "http://www.google.com/mapfiles/ms/micons/red.png"};
	
	var point = new google.maps.LatLng(
        parseFloat(LAT),
        parseFloat(LON));
	
//This is the pop-up window that appears when clicking on a network
	var html = "Router: " + BSSID + "<br>"  + "Signalstregth: " + LEVEL + " dBm" + "<br>" +"Accuracy: " + ACCURACY + " meters" + "<br>" + "Date: " + MONTH_SEEN;
	
	
    var marker = new google.maps.Marker({
        map: map,
        position: point,
        icon: icon
    });
	
	
    bindInfoWindow(marker, map, infoWindow, html);
	markersarray.push(marker);
      
  } //END OF FOR LOOP
    
    map.setCenter(new google.maps.LatLng(bestLat,bestLon));

  }); //END OF downloadUrl
 
	} //END OF LOAD
 
        
//------------------------------------------------
// MISC FUNCTIONS BELOW HERE
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
//downloadUrl function
//------------------------------------------------
    function downloadUrl(url, callback) {
      /*var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;*/

        var request = new XMLHttpRequest();
            
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };
        
 
        request.open('POST', url, true);
        request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        request.send("bssid="+bssid);
    }
//------------------------------------------------
//END downloadUrl function
//------------------------------------------------

    function doNothing() {}