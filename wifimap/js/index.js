function help_click(div, txt) {
    if (div.innerHTML == "") div.innerHTML = "<br/>   " + txt; else div.innerHTML = "";
}


//------------------------------------------------
// setVariables function
//
// This is called when the page is first loaded
// and sets different variables required to do
// a predefined search when the page is opened.
// It then calls 'loadSettings'
//------------------------------------------------

//This runs when page is loaded
function setVariables() {

    searchinput = "";
    open_network = "yes";
    wep_network = "yes";
    wpa_wps_network = "yes";
    wpa_no_wps_network = "yes";
    from_time = "0000000000000";
    to_time = "32503679995000";
    band = "%";
    connected_clients = "%";
    probing_clients = "%";
    predefined_search = "%";


    activeSite = "overview";
    loadSettings();
  }

//------------------------------------------------
// END setVariables function
//------------------------------------------------




//------------------------------------------------
// deleteMarkers function
//
// This first deletes already existing markers on
// the map, then makes sure new data is loaded
// correctly.
//------------------------------------------------


function deleteMarkers() {

    var markersarrayLength = markersarray.length;

    for (i = 0; i < markersarrayLength; i++) {
        markersarray[i].setMap(null);
    }

    if (document.getElementById("open").checked)
    {open_network = "yes"; }
    else
    {open_network = "no"; }

    if (document.getElementById("wep").checked)
    {wep_network = "yes"; }
    else
    {wep_network = "no"; }


    if (document.getElementById("wpa_wps").checked)
    {wpa_wps_network = "yes"; }
    else
    {wpa_wps_network = "no"; }

    if (document.getElementById("wpa_no_wps").checked)
    {wpa_no_wps_network = "yes"; }
    else
    {wpa_no_wps_network = "no"; }

    searchinput=document.getElementById("searchinput").value;
    from_month=document.getElementById("from_month").value;
    from_year=document.getElementById("from_year").value;
    to_month=document.getElementById("to_month").value;
    to_year=document.getElementById("to_year").value;


    //Sets "band", which bands to show
    if (document.getElementById("2.4ghz_band").checked)
    {band="2.4ghz"; }
    else if (document.getElementById("5ghz_band").checked)
    {band="5ghz"; }
    else
    {band="%"; }


    if (document.getElementById("connected_clients").checked)
    {connected_clients=":"; }
    else
    {connected_clients="%"; }

    if (document.getElementById("probing_clients").checked)
    {probing_clients=":"; }
    else
    {probing_clients="%"; }


    predefined_search=document.getElementById("predefined_search").value;


    //Sets "from_time" (GMT)

    if (from_year == "any")
    {from_time = "0000000000000"}

    else if (from_month == "january" & from_year == "2017")
    {from_time = "1483228800000";}
    else if (from_month == "february" & from_year == "2017")
    {from_time = "1485907200000";}
    else if (from_month == "march" & from_year == "2017")
    {from_time = "1488326400000";}
    else if (from_month == "april" & from_year == "2017")
    {from_time = "1491004800000";}
    else if (from_month == "may" & from_year == "2017")
    {from_time = "1493596800000";}
    else if (from_month == "june" & from_year == "2017")
    {from_time = "1496275200000";}
    else if (from_month == "july" & from_year == "2017")
    {from_time = "1498867200000";}
    else if (from_month == "august" & from_year == "2017")
    {from_time = "1501545600000";}
    else if (from_month == "september" & from_year == "2017")
    {from_time = "1504224000000";}
    else if (from_month == "october" & from_year == "2017")
    {from_time = "1506816000000";}
    else if (from_month == "november" & from_year == "2017")
    {from_time = "1509494400000";}
    else if (from_month == "december" & from_year == "2017")
    {from_time = "1512086400000";}


    else if (from_month == "january" & from_year == "2016")
    {from_time = "1451606400000";}
    else if (from_month == "february" & from_year == "2016")
    {from_time = "1454284800000";}
    else if (from_month == "march" & from_year == "2016")
    {from_time = "1456790400000";}
    else if (from_month == "april" & from_year == "2016")
    {from_time = "1459468800000";}
    else if (from_month == "may" & from_year == "2016")
    {from_time = "1462060800000";}
    else if (from_month == "june" & from_year == "2016")
    {from_time = "1464739200000";}
    else if (from_month == "july" & from_year == "2016")
    {from_time = "1467331200000";}
    else if (from_month == "august" & from_year == "2016")
    {from_time = "1470009600000";}
    else if (from_month == "september" & from_year == "2016")
    {from_time = "1472688000000";}
    else if (from_month == "october" & from_year == "2016")
    {from_time = "1475280000000";}
    else if (from_month == "november" & from_year == "2016")
    {from_time = "1477958400000";}
    else if (from_month == "december" & from_year == "2016")
    {from_time = "1480550400000";}


    else if (from_month == "january" & from_year == "2015")
    {from_time = "1420070400000";}
    else if (from_month == "february" & from_year == "2015")
    {from_time = "1422748800000";}
    else if (from_month == "march" & from_year == "2015")
    {from_time = "1425168000000";}
    else if (from_month == "april" & from_year == "2015")
    {from_time = "1427846400000";}
    else if (from_month == "may" & from_year == "2015")
    {from_time = "1430438400000";}
    else if (from_month == "june" & from_year == "2015")
    {from_time = "1433116800000";}
    else if (from_month == "july" & from_year == "2015")
    {from_time = "1435708800000";}
    else if (from_month == "august" & from_year == "2015")
    {from_time = "1438387200000";}
    else if (from_month == "september" & from_year == "2015")
    {from_time = "1441065600000";}
    else if (from_month == "october" & from_year == "2015")
    {from_time = "1443657600000";}
    else if (from_month == "november" & from_year == "2015")
    {from_time = "1446336000000";}
    else if (from_month == "december" & from_year == "2015")
    {from_time = "1448928000000";}


    else {from_time = "0000000000000"};


    //Sets "to_time" (GMT)

    if (to_year == "any")
    {to_time = "32503679995000"}


    else if (to_month == "december" & to_year == "2017")
    {to_time = "1514764799000";}

    else if (to_month == "january" & to_year == "2017")
    {to_time = "1485907199000";}
    else if (to_month == "february" & to_year == "2017")
    {to_time = "1214883263990003";}
    else if (to_month == "march" & to_year == "2017")
    {to_time = "1491004799000";}
    else if (to_month == "april" & to_year == "2017")
    {to_time = "1493596799000";}
    else if (to_month == "may" & to_year == "2017")
    {to_time = "1496275199000";}
    else if (to_month == "june" & to_year == "2017")
    {to_time = "1498867199000";}
    else if (to_month == "july" & to_year == "2017")
    {to_time = "1501459199000";}
    else if (to_month == "august" & to_year == "2017")
    {to_time = "1504223999000";}
    else if (to_month == "september" & to_year == "2017")
    {to_time = "1506815999000";}
    else if (to_month == "october" & to_year == "2017")
    {to_time = "1509494399000";}
    else if (to_month == "november" & to_year == "2017")
    {to_time = "1512086399000";}


    else if (to_month == "december" & to_year == "2016")
    {to_time = "1483228799000";}

    else if (to_month == "january" & to_year == "2016")
    {to_time = "1454284799000";}
    else if (to_month == "february" & to_year == "2016")
    {to_time = "1456790399000";}
    else if (to_month == "march" & to_year == "2016")
    {to_time = "1459468799000";}
    else if (to_month == "april" & to_year == "2016")
    {to_time = "1462060799000";}
    else if (to_month == "may" & to_year == "2016")
    {to_time = "1464739199000";}
    else if (to_month == "june" & to_year == "2016")
    {to_time = "1467331199000";}
    else if (to_month == "july" & to_year == "2016")
    {to_time = "1470009599000";}
    else if (to_month == "august" & to_year == "2016")
    {to_time = "1472687999000";}
    else if (to_month == "september" & to_year == "2016")
    {to_time = "1475279999000";}
    else if (to_month == "october" & to_year == "2016")
    {to_time = "1477958399000";}
    else if (to_month == "november" & to_year == "2016")
    {to_time = "1480550399000";}


    else if (to_month == "december" & to_year == "2015")
    {to_time = "1451606399000";}

    else if (to_month == "january" & to_year == "2015")
    {to_time = "1422748799000";}
    else if (to_month == "february" & to_year == "2015")
    {to_time = "1425167999000";}
    else if (to_month == "march" & to_year == "2015")
    {to_time = "1427846399000";}
    else if (to_month == "april" & to_year == "2015")
    {to_time = "1430438399000";}
    else if (to_month == "may" & to_year == "2015")
    {to_time = "1433116799000";}
    else if (to_month == "june" & to_year == "2015")
    {to_time = "1435708799000";}
    else if (to_month == "july" & to_year == "2015")
    {to_time = "1438387199000";}
    else if (to_month == "august" & to_year == "2015")
    {to_time = "1441065599000";}
    else if (to_month == "september" & to_year == "2015")
    {to_time = "1443657599000";}
    else if (to_month == "october" & to_year == "2015")
    {to_time = "1446335999000";}
    else if (to_month == "november" & to_year == "2015")
    {to_time = "1448927999000";}


    else {to_time = "32503679995000"};


      load();
  }

//------------------------------------------------
// END deleteMarkers function
//------------------------------------------------




//This runs when page is loaded, after variables are set
    function load() {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(mapCenterLatitude,mapCenterLongitude),
        zoom: defaultZoomLevelNetwork,
        mapTypeId: mapTypeNetwork
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

	  var mcOptions = {gridSize: 70, maxZoom: 16};
      var infoWindow = new google.maps.InfoWindow;


downloadUrl("php/genxml.php", function(data) {
  var xml = data.responseXML;
  markers = xml.documentElement.getElementsByTagName("marker");

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
      var html = "<b>" + SSID + "</b> <br>" + BSSID + "<br>" + VENDOR + "<br>" + "<br>" + CAPABILITIES + "<br>" + popup_channel + CHANNEL + " (" + FREQUENCY + " MHz)" + "<br>" + "Signal: " + BESTLEVEL + " dBm" + "<br>" + popup_lastseen + LASTSEEN + "<br>" + "<br>" + popup_connectedclients + "<b>" + CONNECTED_CLIENTS + "</b>" + "<br>" + popup_probingclients + "<b>" + PROBING_CLIENTS + "</b>" + "<br>" + "<input type='button' onclick='getLocation(" + BSSIDFunctionFriendly + ");' value='Precise location' class='infoWindowSearchButton'>" + "   " + "<input type='button' id='showclients' onclick='openClientTab();' value='Client info' class='infoWindowSearchButton'>";


    marker = new google.maps.Marker({
      map: map,
      position: point,
	  icon: ICON
    });


    bindInfoWindow(marker, map, infoWindow, html);
	markersarray.push(marker);


  } //END OF FOR LOOP


//This is grouping of networks that are close together
  mc = new MarkerClusterer(map, markersarray, mcOptions);

  }); //END OF downloadUrl

	} //END OF LOAD



//------------------------------------------------
// MISC FUNCTIONS BELOW HERE
//------------------------------------------------

//------------------------------------------------
// bindInfoWindow function
//------------------------------------------------

function bindInfoWindow(marker, map, infoWindow, html) {
    google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
    });
}

//------------------------------------------------
// END bindInfoWindow function
//------------------------------------------------

//------------------------------------------------
// downloadUrl function
//
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
        request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        request.send("open_network="+open_network+"&"+"wep_network="+wep_network+"&"+"wpa_wps_network="+wpa_wps_network+"&"+"wpa_no_wps_network="+wpa_no_wps_network+"&"+"searchinput="+searchinput+"&"+"from_time="+from_time+"&"+"to_time="+to_time+"&"+"band="+band+"&"+"connected_clients="+connected_clients+"&"+"probing_clients="+probing_clients+"&"+"predefined_search="+predefined_search);

    }

//------------------------------------------------
// END downloadUrl function
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


//------------------------------------------------
// openClientTab function
//
// opens a new tab, for client lookup
//------------------------------------------------
function openClientTab () {

    alert("Copy client MAC from this window, and paste in client window");
    locationWindow = window.open(clientsPageAddress);
}
//------------------------------------------------
// END openClientTab function
//------------------------------------------------


//------------------------------------------------
// doNothing function
//
// this function does, well, nothing
//------------------------------------------------
function doNothing() {}
//------------------------------------------------
// END doNothing function
//------------------------------------------------
