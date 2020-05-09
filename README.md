![](https://i.imgur.com/cbqbdQe.png)
[Live version](https://wifikart.net)

![](https://i.imgur.com/fAeToNM.png)

Put data captured by the WiGLE Android app in a self-hosted database, overlay it on Google Maps with extensive filtering options.
Import data captured by airodump-ng, connect it with the data from WiGLE, and see which clients have been connected to or probed networks in your database.
### Setup
The easiest way to run the system is in self-contained Docker containers.
If you are already using Docker:
````
$ curl -sSL https://raw.githubusercontent.com/Znerox/wifimap/master/docker-compose.yml > docker-compose.yml
$ docker-compose up -d
````
Docker setup is explained in more [detail here](https://github.com/Znerox/wifimap/wiki/Running-in-Docker-(recommended)).  
If you want to run the system in a more traditional way, by install a web server and database yourself, that's [no problem](https://github.com/Znerox/wifimap/wiki/Installation-without-Docker).
### How to use  
If your Docker host is on 192.168.1.10, the various webpages will now be available on these ports/addresses:  
* Map of WiFi networks: 192.168.1.10
* Tools for uploading data:  192.168.1.10/tools
* Bluetooth clients: 192.168.1.10/bluetooth
* Database management: 192.168.1.10:8080 (login is root/password)  
  
For more details and screenshots, take a look at the [Wiki](https://github.com/Znerox/wifimap/wiki).