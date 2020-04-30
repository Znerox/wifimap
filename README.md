![](https://i.imgur.com/cbqbdQe.png)
[Live version](https://wifikart.net)

![](https://i.imgur.com/fAeToNM.png)

Put collected network data by the WiGLE Android app in a self-hosted database, overlay it on Google Maps with extensive filtering options.
It's also possible to import data captured by airodump-ng on Linux, connect it with the data from WiGLE, and see which clients have been connected to or probed networks in your database.

It's now possible to run in Docker, see [Wiki](https://github.com/Znerox/wifimap/wiki/Running-in-Docker-(recommended)) for details.  
If you are already using Docker:
````
$ curl -sSL https://raw.githubusercontent.com/Znerox/wifimap/master/docker-compose.yml > docker-compose.yml
$ docker-compose up -d
````
