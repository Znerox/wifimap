function loadSettings() {
    
    //------------------------------------------------
    // Change settings below here
    //------------------------------------------------
    
    // Set language. Supported languages are: english, norwegian.
    language = "english";
    
    
    // Set map center coordinates. Go to maps.google.com and click
    // a location to get its coordinates.    
    mapCenterLatitude = 69.665;
    mapCenterLongitude = 18.955;
    
    
    // Default zoom for the main network view
    defaultZoomLevelNetwork = 12;
    
    
    // Default zoom for the location view
    defaultZoomLevelLocation = 18;
    
    
    // Default maptype for the main network view
    // Avialable maptypes are:
    // roadmap
    // satellite
    // hybrid
    // terrain
    mapTypeNetwork = 'roadmap';
    
    
     // Default maptype for the location view
    // Avialable maptypes are:
    // roadmap
    // satellite
    // hybrid
    // terrain
    mapTypeLocation = 'hybrid';
    
    
    // Where is the "location" webpage located?
    // For example for site available on your local network: http://192.168.1.31/wifimap/location
    // For example for site available on the internet: http://wifimap.mydomain.net/location
    
    locationPageAddress = "http://SERVER_IP/wifimap/location";
    
    
    // Where is the "clients" webpage located?
    // For example for site available on your local network: http://192.168.1.31/wifimap/clients
    // For example for site available on the internet: http://wifimap.mydomain.net/clients
    
    clientsPageAddress = "http://SERVER_IP/wifimap/clients";
    
    
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
        
        // text by the icons, explaining what they mean
        $(opentext).html("Typisk gjestenettverk");
        $(weptext).html("Utdatert kryptering");
        $(wpstext).html("Sikker kryptering (WPA med WPS, kan utnyttes)");
        $(wpatext).html("Sikker kryptering (WPA uten WPS)"); 
        
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
            
            // text by the icons, explaining what they mean
            $(opentext).html("Typically a guestnetwork");
            $(weptext).html("Outdated encryption");
            $(wpstext).html("Secure encryption (WPA with WPS, which can be exploited)");
            $(wpatext).html("Secure encryption (WPA without WPS)");
            
            // text inside the popup box that appears when clicking a marker
            popup_channel = "Channel: ";
            popup_lastseen = "Last seen: ";
            popup_connectedclients = "Connected clients: ";
            popup_probingclients = "Probing clients: ";
            popup_location = "Precise location";
            popup_clientinfo = "Client info";
            
        }
        
        
    }// END activeSite = overview
    
    
    // this runs on the "location" site
    if (activeSite == "location") {
        
        
        if (language == "norwegian") {
            
            
        }
        
        if (language == "english") {
            
            //$(signal_info_text_good).html("Signal stregth over -80 dBm");
            //$(signal_info_text_medium).html("Signal stregth -80/-90 dBm");
            //$(signal_info_text_bad).html("Signal stregth under -90 dBm");
            
        }
        
        
    }// END activeSite = location
    
    
    // this runs on the clients site
    if (activeSite == "clients") {
        
        
        if (language == "norwegian") {
            
            $(show_connected_text).html("Vs tilkoblede");
            $(show_probed_text).html("Vis probed");
            $(dont_show_unlikely_probes_text).html("Ikke vis usannsynlige probes");
            
        }
        
        if (language == "english") {
            
            $(show_connected_text).html("Show connected");
            $(show_probed_text).html("Show probed");
            $(dont_show_unlikely_probes_text).html("No unlikely probes");

        }
        
        
    }// END activeSite = clients
    
    
    load();
      
}