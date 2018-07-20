function loadSettings() {

  //------------------------------------------------
  // Change settings below here
  //------------------------------------------------

  // Set language. Supported languages are: english, norwegian.
  language = "english";


  // Set map center coordinates. Go to maps.google.com and click
  // a location to get its coordinates.
  mapCenterLatitude = 69.670;
  mapCenterLongitude = 18.955;


  // Default zoom for the main network view
  defaultZoomLevelNetwork = 12;

  // Default zoom for the location view
  defaultZoomLevelLocation = 18;

  // Default zoom for the clients view
  defaultZoomLevelClients = 12;


  // Avialable maptypes are:
  // roadmap
  // satellite
  // hybrid
  // terrain

  // Default maptype for the main network view
  mapTypeNetwork = 'roadmap';

  // Default maptype for the location view
  mapTypeLocation = 'hybrid';

  // Default maptype for the clients view
  mapTypeClients = 'roadmap';


  // Avialable map themes are:
  // blueWater (https://snazzymaps.com/style/25/blue-water)
  // brightColors
  // dark (https://snazzymaps.com/style/1261/dark)
  // googleMapsDefault
  // midnight (modified https://snazzymaps.com/style/2/midnight-commander)
  // multiBrandNetwork (https://snazzymaps.com/style/20053/multi-brand-network)
  // oldDefault

  // Map theme for the main network view
  mapThemeNetwork = blueWater;

  // Map theme for the location view
  mapThemeLocation = oldDefault;

  // Map theme for the clients view
  mapThemeClients = oldDefault;


  // Where is the "location" webpage located?
  // Example for site available on your local network: http://192.168.1.31/wifimap/location
  // Example for site available on the public internet: http://wifimap.mydomain.net/location

  locationPageAddress = "http://SERVER_IP/wifimap/location";


  // Where is the "clients" webpage located?
  // Example for site available on your local network: http://192.168.1.31/wifimap/clients
  // Example for site available on the public internet: http://wifimap.mydomain.net/clients

  clientsPageAddress = "http://SERVER_IP/wifimap/clients";



  // If this is set, any location data with an accuracy higher than this (less accurate) doesn't display in the location view
  // If your phone captures accurate data, a setting of 5 will probably work good
  // If you press "Prescise location", and get a message saying there is no location for the network, try setting this higher
  // Default = 0 (all data will be shown, no matter how inaccurate)
  location_data_accuracy_cutoff = 0;


  //------------------------------------------------
  // Change settings above here
  //------------------------------------------------






  // this runs on the main "overview" site
  if (activeSite == "overview") {

    if (language == "norwegian") {

      // checkboxes to choose encryption
      $(open_checkbox_text).html("Åpen");
      $(wpa_wps_checkbox_text).html("WPA, med WPS");
      $(wep_checkbox_text).html("WEP");
      $(wpa_no_wps_checkbox_text).html("WPA, uten WPS");

      //$(last_seen_text).html("Sist sett:");

      // text under icons, at the bottom if the sidepanel
      $(searchinfoheadline_open).html("<b>Åpen</b>");
      $(searchinfoheadline_wep).html("<b>WEP</b>");
      $(searchinfoheadline_wps).html("<b>WPS</b>");
      $(searchinfoheadline_wpa).html("<b>WPA</b>");

      // radio button, selecting both frequency bands
      $(both_band_text).html("Begge");

      // downmost checkboxes, selecting connected/probing clients
      $(connected_checkbox_text).html("Tilkoblet");
      $(probing_checkbox_text).html("Søkende");

      // text over predefined search menu
      $(predefined_search_header).html("Forhåndsdefinerte søk");

      // text by the icons, explaining what they mean
      $(opentext).html("Typisk gjestenettverk");
      $(weptext).html("Utdatert kryptering");
      $(wpstext).html("Kan være usikker <br> (WPA med WPS)");
      $(wpatext).html("Sikker kryptering <br> (WPA uten WPS)");

      // text inside the popup box that appears when clicking a marker
      popup_channel = "Kanal: ";
      popup_lastseen = "Sist sett: ";
      popup_connectedclients = "Tilkoblede klienter: ";
      popup_probingclients = "Søkende klienter: ";
      popup_location = "Nøyaktig plassering";
      popup_clientinfo = "Klient info";

    }

    if (language == "english") {

      // checkboxes to choose encryption
      $(open_checkbox_text).html("Open");
      $(wpa_wps_checkbox_text).html("WPA, with WPS");
      $(wep_checkbox_text).html("WEP");
      $(wpa_no_wps_checkbox_text).html("WPA, without WPS");

      //$(last_seen_text).html("Last seen:");

      // text under icons, at the bottom if the sidepanel
      $(searchinfoheadline_open).html("<b>Open</b>");
      $(searchinfoheadline_wep).html("<b>WEP</b>");
      $(searchinfoheadline_wps).html("<b>WPS</b>");
      $(searchinfoheadline_wpa).html("<b>WPA</b>");

      $(last_seen_text).html("Last seen:");


      // radio button, selecting both frequency bands
      $(both_band_text).html("Both");

      // downmost checkboxes, selecting connected/probing clients
      $(connected_checkbox_text).html("Connected");
      $(probing_checkbox_text).html("Probing");

      // text over predefined search menu
      $(predefined_search_header).html("Predefined searches");

      // text by the icons, explaining what they mean
      $(opentext).html("Typically a guest network");
      $(weptext).html("Outdated encryption");
      $(wpstext).html("Possibly vulnerable <br> (WPA with WPS)");
      $(wpatext).html("Secure encryption <br> (WPA without WPS)");

      // text inside the popup box that appears when clicking a marker
      popup_channel = "Channel: ";
      popup_lastseen = "Last seen: ";
      popup_connectedclients = "Connected clients: ";
      popup_probingclients = "Probing clients: ";
      popup_location = "Precise location";
      popup_clientinfo = "Client info";

    }


  } // END activeSite = overview


  // this runs on the "location" site
  if (activeSite == "location") {

    if (location_data_accuracy_cutoff == 0) {
      location_data_accuracy_cutoff = 10000;
    }


    if (language == "norwegian") {


    }

    if (language == "english") {

      //$(signal_info_text_good).html("Signal stregth over -80 dBm");
      //$(signal_info_text_medium).html("Signal stregth -80/-90 dBm");
      //$(signal_info_text_bad).html("Signal stregth under -90 dBm");

    }


  } // END activeSite = location


  // this runs on the clients site
  if (activeSite == "clients") {


    if (language == "norwegian") {

      $(show_connected_text).html("Vis tilkoblede");
      $(show_probed_text).html("Vis probed");
      $(dont_show_unlikely_probes_text).html("Ikke vis usannsynlige probes");

    }

    if (language == "english") {

      $(show_connected_text).html("Connected Network");
      $(show_probed_text).html("Probed SSID");
      $(dont_show_unlikely_probes_text).html("Unlikely Network");

    }


  } // END activeSite = clients


  loadMap();

}
