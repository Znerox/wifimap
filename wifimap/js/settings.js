function loadSettings() {

  // Changing these settings are optional, however you need to set a Google Maps API key
  // Find the file \wifimap\js\API_key.js
  // In the file, replace "YOUR_API_KEY" with your own Google Maps API key
  // https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key

  //------------------------------------------------
  // Change settings below here
  //------------------------------------------------


  // Set map center coordinates. Go to maps.google.com and click
  // a location to get its coordinates.
  mapCenterLatitude = 30;
  mapCenterLongitude = 0;


  // Default zoom for the main network view
  defaultZoomLevelNetwork = 3;

  // Default zoom for the location view
  defaultZoomLevelLocation = 18;

  // Default zoom for the clients view
  defaultZoomLevelClients = 3;

  // Default zoom for the bluetooth view
  defaultZoomLevelBluetooth = 3;


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


  // At what IP/hostname is the web server running? This option is only included in case the default somehow doesn't work
  // Valid examples are: http://192.168.1.31/wifimap/location OR http://wifimap.mydomain.net/location
  locationPageAddress = "http://" + location.host +"/wifimap/location";
  clientsPageAddress = "http://" + location.host + "/wifimap/clients";
  bluetoothPageAddress = "http://" + location.host + "/wifimap/bluetooth";


  // If this is set, any location data with an accuracy higher than this (less accurate) doesn't display in the location view
  // If your phone captures accurate data, a setting of 5 will probably work good
  // If you press "Prescise location", and get a message saying there is no location for the network, try setting this higher
  // Default = 0 (all data will be shown, no matter how inaccurate)
  location_data_accuracy_cutoff = 0;


  //------------------------------------------------
  // Change settings above here
  //------------------------------------------------


  if (activeSite == "location") {
    if (location_data_accuracy_cutoff == 0) {
      location_data_accuracy_cutoff = 10000;
    }
  }

  loadMap();
}
