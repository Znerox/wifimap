function loadSettings() {


  // In addition to these settings, you need to set an api key
  // Find line 9 in \wifimap\index.html (and every index.html in the "wifimap" folder)
  // In the URL, replace "YOUR_API_KEY" with your own Google Maps API key
  // https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key


  //------------------------------------------------
  // Change settings below here
  //------------------------------------------------


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

  // Default zoom for the bluetooth view
  defaultZoomLevelBluetooth = 12;


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

  // Default maptype for the bluetooth view
  mapTypeBluetooth = 'roadmap';


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

  // Map theme for the bluetooth view
  mapThemeBluetooth = blueWater;


  // Where is the "location" webpage located?
  // Example for site available on your local network: http://192.168.1.31/wifimap/location
  // Example for site available on the public internet: http://wifimap.mydomain.net/location

  locationPageAddress = "http://SERVER_IP/wifimap/location";


  // Where is the "clients" webpage located?
  // Example for site available on your local network: http://192.168.1.31/wifimap/clients
  // Example for site available on the public internet: http://wifimap.mydomain.net/clients

  clientsPageAddress = "http://SERVER_IP/wifimap/clients";


  // Where is the "bluetooth" webpage located?
  // Example for site available on your local network: http://192.168.1.31/wifimap/bluetooth
  // Example for site available on the public internet: http://wifimap.mydomain.net/bluetooth

  bluetoothPageAddress = "http://SERVER_IP/wifimap/bluetooth";



  // If this is set, any location data with an accuracy higher than this (less accurate) doesn't display in the location view
  // If your phone captures accurate data, a setting of 5 will probably work good
  // If you press "Prescise location", and get a message saying there is no location for the network, try setting this higher
  // Default = 0 (all data will be shown, no matter how inaccurate)
  location_data_accuracy_cutoff = 0;


  //------------------------------------------------
  // Change settings above here
  //------------------------------------------------


  // this runs on the "location" site
  if (activeSite == "location") {

    if (location_data_accuracy_cutoff == 0) {
      location_data_accuracy_cutoff = 10000;
    }
  }

  loadMap();
}
