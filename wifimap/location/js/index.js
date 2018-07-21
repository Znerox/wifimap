//------------------------------------------------
// setVariables
// Is called whenpage is first loaded
//------------------------------------------------
function setVariables() {
  bssid = window.opener.bssid;
  bestLevel = "-1000";
  bestLat = window.opener.mapCenterLatitude;
  bestLon = window.opener.mapCenterLongitude;
  activeSite = "location";
  loadMapThemes();
}

//------------------------------------------------
// deleteMarkers
// Is called when search button is clicked.
// It deletes existing markers, sets variable,
// then calls 'loadMap'
//------------------------------------------------
function deleteMarkers() {
  for (i = 0; i < markersarray.length; i++) {
    markersarray[i].setMap(null);
  }

  bssid = document.getElementById("searchinput").value;
  loadMap();
}

//This runs when page is loaded, after variables are set
function loadMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: new google.maps.LatLng(mapCenterLatitude, mapCenterLongitude),
    mapTypeId: mapTypeLocation,
    zoom: defaultZoomLevelLocation,
    zoomControlOptions: {
      position: google.maps.ControlPosition.LEFT_BOTTOM
    },
    fullscreenControl: false,
    streetViewControl: false
  });

  map.setOptions({
    styles: mapThemeLocation
  });
  var infoWindow = new google.maps.InfoWindow;

  downloadUrl("php/genxml.php", function(data) {
    var xml = data.responseXML;
    markers = xml.documentElement.getElementsByTagName("marker");

    markersarray = [];

    if (markers.length == 0) {
      alert("No location data found for network " + bssid);
    }

    //This is done on each line from db
    for (var i = 0; i < markers.length; i++) {
      var BSSID = markers[i].getAttribute("BSSID");
      var LEVEL = markers[i].getAttribute("LEVEL");
      var LAT = markers[i].getAttribute("LAT");
      var LON = markers[i].getAttribute("LON");
      var ACCURACY = markers[i].getAttribute("ACCURACY");
      var DATE = markers[i].getAttribute("DATE");

      if (LEVEL > bestLevel) {
        bestLevel = LEVEL;
        bestLat = LAT;
        bestLon = LON;
      }

      if (LEVEL > -80) {
        icon = "../images/green.png"
      } else if (LEVEL >= -90) {
        icon = "../images/yellow.png"
      } else {
        icon = "../images/red.png"
      };

      var point = new google.maps.LatLng(
        parseFloat(LAT),
        parseFloat(LON));

      //This is the pop-up window that appears when clicking on a network
      var html = "AP: " + BSSID + "<br>" + "Signalstregth: " + LEVEL + " dBm" + "<br>" + "Accuracy: " + ACCURACY + " meters" + "<br>" + "Date: " + DATE;

      var marker = new google.maps.Marker({
        map: map,
        position: point,
        icon: icon
      });

      bindInfoWindow(marker, map, infoWindow, html);
      markersarray.push(marker);

    } //END FOR LOOP

    map.setCenter(new google.maps.LatLng(bestLat, bestLon));

  }); //END downloadUrl

} //END loadMap

function bindInfoWindow(marker, map, infoWindow, html) {
  google.maps.event.addListener(marker, 'click', function() {
    infoWindow.setContent(html);
    infoWindow.open(map, marker);
  });
}

//------------------------------------------------
// downloadUrl
// sends form data to server and receives xml file
// with network data in return
//------------------------------------------------
function downloadUrl(url, callback) {
  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      request.onreadystatechange = doNothing;
      callback(request, request.status);
    }
  };

  request.open('POST', url, true);
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.send("bssid=" + bssid + "&location_data_accuracy_cutoff=" + location_data_accuracy_cutoff);
}

function doNothing() {}
