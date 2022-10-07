//------------------------------------------------
// setVariables
// This is called when the page is first loaded
// and sets different variables required to do
// a predefined search when the page is opened.
//------------------------------------------------
function setVariables() {
  search_input = "";
  selected_fromtime = "";
  selected_totime = "";
  vendor_input = "";
  capabilities_input = "";
  activeSite = "bluetooth";
  loadMapThemes();
}

//------------------------------------------------
// deleteMarkers
// This first deletes already existing markers on
// the map, then makes sure new data is loaded
// correctly. Calls 'loadMap'
//------------------------------------------------
function deleteMarkers() {
  var markersarrayLength = markersarray.length;
  for (i = 0; i < markersarrayLength; i++) {
    markersarray[i].setMap(null);
  }

  search_input = document.getElementById("search_input").value;
  selected_fromtime = document.getElementById("selected_fromtime").value;
  selected_totime = document.getElementById("selected_totime").value;
  vendor_input = document.getElementById("vendor_input").value;
  capabilities_input = document.getElementById("capabilities_input").value;

  loadMap();
}

//This runs when page is loaded, after variables are set
function loadMap() {
  var map = new google.maps.Map(document.getElementById("map"), {
    center: new google.maps.LatLng(mapCenterLatitude, mapCenterLongitude),
    mapTypeId: mapTypeBluetooth,
    zoom: defaultZoomLevelBluetooth,
    zoomControlOptions: {
      position: google.maps.ControlPosition.LEFT_BOTTOM
    },
    fullscreenControl: false,
    streetViewControl: false
  });

  map.setOptions({
    styles: mapThemeBluetooth
  });

  var mcOptions = {
    gridSize: 70,
    maxZoom: 16
  };

  infoWindow = new google.maps.InfoWindow;

  //Close info bubble when pressing escape
  window.addEventListener("keydown", function (event) {
    if (event.key == "Escape") {
      infoWindow.close();
    }
  })

  downloadUrl("php/genxml.php", function(data) {
    var xml = data.responseXML;
    markers = xml.documentElement.getElementsByTagName("marker");

    markersarray = [];

    //Overlapping Marker Spiderfier
    //This is splitting of networks on identical coordinates
    var oms = new OverlappingMarkerSpiderfier(map, {});

    var markersLength = markers.length;

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
      var BESTLEVEL = markers[i].getAttribute("BESTLEVEL");
      var BESTLAT = markers[i].getAttribute("BESTLAT");
      var BESTLON = markers[i].getAttribute("BESTLON");

      var point = new google.maps.LatLng(
        parseFloat(BESTLAT),
        parseFloat(BESTLON));

      var BSSIDFunctionFriendly = '"' + BSSID + '"';
      var SSIDFunctionFriendly = '"' + SSID + '"';

      //This is the pop-up window that appears when clicking on a network
      var html = "<b>Name: </b>" + SSID + "<br><b>BD_ADDR: </b>" + BSSID + "<br><b>Vendor: </b>" + VENDOR + "<br><br><b>Capabilities: </b>" + CAPABILITIES + "<br><b>Signal: </b>" + BESTLEVEL + " dBm<br><b>Last seen: </b>" + LASTSEEN + "<br><input type='button' onclick='getLocation(" + BSSIDFunctionFriendly + ");' value='Precise location' class='infoWindowSearchButton'>";

      var marker = new google.maps.Marker({
        map: map,
        position: point,
        icon: ICON
      });

      bindInfoWindow(marker, map, infoWindow, html);
      markersarray.push(marker);
      oms.addMarker(marker);

    } //END FOR LOOP

    //This is grouping of networks that are close together
    mc = new MarkerClusterer(map, markersarray, mcOptions);

  }); //END downloadUrl

} //END loadMap

function bindInfoWindow(marker, map, infoWindow, html) {
  google.maps.event.addListener(marker, 'spider_click', function() {
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
  request.send("search_input=" + search_input + "&selected_fromtime=" + selected_fromtime + "&selected_totime=" + selected_totime + "&vendor_input=" + vendor_input + "&capabilities_input=" + capabilities_input);
}

//------------------------------------------------
// getLocation
// opens a new tab with location of network
//------------------------------------------------
function getLocation(BSSIDFunctionFriendly) {
  bssid = BSSIDFunctionFriendly;
  var locationWindow = window.open(locationPageAddress);
}

function showVendors() {
  vendorList = [];
  downloadUrl("php/getvendors.php", function(data) {
    var xml = data.responseXML;
    var vendors = xml.documentElement.getElementsByTagName("vendor");

    for (var i = 0; i < vendors.length; i++) {
      var vendor = vendors[i].getAttribute("vendor");
      vendorList.push(vendor);
    }

    alert('Unique vendors in database: ' + vendors.length + '\n\n' + vendorList.join('\n'));

  });
}

function showCapabilities() {
  capabilityList = [];
  downloadUrl("php/getcapabilities.php", function(data) {
    var xml = data.responseXML;
    var capabilities = xml.documentElement.getElementsByTagName("capabilities");

    for (var i = 0; i < capabilities.length; i++) {
      var capability = capabilities[i].getAttribute("capabilities");
      capabilityList.push(capability);
    }

    alert('Unique capabilities in database: ' + capabilities.length + '\n\n' + capabilityList.join('\n'));

  });
}

function doNothing() {}
