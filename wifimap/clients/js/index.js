//------------------------------------------------
// setVariables, is called when
// page is first loaded
//------------------------------------------------
function setVariables() {
  searchinput = document.getElementById("searchinput").value;
  connected_to_bssid = "";
  probed_essid = "";
  markersarray = [];
  show_connected = "yes";
  show_probing = "yes";
  show_false_positives = "no";
  activeSite = "clients";
  loadMapThemes();
}

//------------------------------------------------
// deleteMarkers
// Is called when search button is clicked.
// It deletes existing markers, resets variables,
// resets field on the side, then calls 'loadMap'
//------------------------------------------------
function deleteMarkers() {
  for (i = 0; i < markersarray.length; i++) {
    markersarray[i].setMap(null);
  }

  searchinput = document.getElementById("searchinput").value;

  if (document.getElementById("show_connected").checked) {
    show_connected = "yes";
  } else {
    show_connected = "no";
  }

  if (document.getElementById("show_probing").checked) {
    show_probing = "yes";
  } else {
    show_probing = "no";
  }

  if (document.getElementById("show_false_positives").checked) {
    show_false_positives = "yes";
  } else {
    show_false_positives = "no";
  }

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

  loadMap();

}

//This runs when page is loaded, after variables are set
function loadMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: new google.maps.LatLng(mapCenterLatitude, mapCenterLongitude),
    mapTypeId: mapTypeClients,
    zoom: defaultZoomLevelClients,
    zoomControlOptions: {
      position: google.maps.ControlPosition.LEFT_BOTTOM
    },
    fullscreenControl: false,
    streetViewControl: false
  });

  map.setOptions({
    styles: mapThemeClients
  });

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
    // This piece of code first prints the 1st connected router,
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

    getNetworkData();

  }); //END downloadUrl

} //END loadMap

//------------------------------------------------
// START getNetworkData function (not actual
// function, but launching, from within clientdata)
//------------------------------------------------
function getNetworkData() {

  downloadUrl_networkdata("php/genxml_networkdata.php", function(data) {
    var xml_networkdata = data.responseXML;
    markers = xml_networkdata.documentElement.getElementsByTagName("marker");

    markersarray = [];

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
      var html = "<b>" + SSID + "</b> <br>" + BSSID + "<br>" + VENDOR + "<br><br>" + CAPABILITIES + "<br>Channel: " + CHANNEL + " (" + FREQUENCY + " MHz)<br>Signal: " + BESTLEVEL + " dBm<br>Last seen: " + LASTSEEN + "<br><br>Connected clients: <b>" + CONNECTED_CLIENTS + "</b><br>Probing clients: <b>" + PROBING_CLIENTS + "</b><br><input type='button' onclick='getLocation(" + BSSIDFunctionFriendly + ");' value='Precise location' class='infoWindowSearchButton'>";

      marker = new google.maps.Marker({
        map: map,
        position: point,
        icon: ICON
      });

      bindInfoWindow(marker, map, infoWindow, html);
      markersarray.push(marker);

    } //END FOR LOOP

  }); //END downloadUrl_networkdata

}

function bindInfoWindow(marker, map, infoWindow, html) {
  google.maps.event.addListener(marker, 'click', function() {
    infoWindow.setContent(html);
    infoWindow.open(map, marker);
  });
}

function downloadUrl_clientdata(url, callback) {
  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      request.onreadystatechange = doNothing;
      callback(request, request.status);
    }
  };

  request.open('POST', url, true);
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.send("searchinput=" + searchinput);
}

function downloadUrl_networkdata(url, callback) {
  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      request.onreadystatechange = doNothing;
      callback(request, request.status);
    }
  };

  request.open('POST', url, true);
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.send("connected_to_bssid=" + connected_to_bssid + "&probed_essid=" + probed_essid + "&show_connected=" + show_connected + "&show_probing=" + show_probing + "&show_false_positives=" + show_false_positives);
}

//------------------------------------------------
// getLocation
// opens a new tab with location of network
//------------------------------------------------
function getLocation(BSSIDFunctionFriendly) {
  bssid = BSSIDFunctionFriendly;
  locationWindow = window.open(locationPageAddress);
}

function doNothing() {}
