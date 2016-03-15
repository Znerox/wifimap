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
            
            
        }
        
        
    }// END activeSite = location
    
    
    // this runs on the clients site
    if (activeSite == "clients") {
        
        
        if (language == "norwegian") {
            
            
        }
        
        if (language == "english") {
            
            
        }
        
        
    }// END activeSite = clients
    
    
    

    
    load();
      
}