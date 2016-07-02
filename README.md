# #mappiamo - the geoCMS for rest of us
======

[![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/mappiamo/mapi-geoCMS?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)  [![Documentation Status](https://readthedocs.org/projects/mappiamo/badge/?version=latest)](http://mappiamo.readthedocs.org/en/latest/?badge=latest) 

If you have any question, please drop an email:  info [at] mappiamo.org


### What is #mappiamo?
 #mappiamo, demo http://www.mappiamo.org/, is a suitable tool to build websites and combine the contents ensuring ownership and originality for each of the data providers. It is suitable to marketing 3.0 where it is important to the credibility of the sharing of experiential baggage of both operators and consumers.
 #mappiamo is a CMS that allows you to create and leverage content through the use of OpenData, the geo-location and microformats. It can be used for processing the data produced by public administrations, collect content (crowdsourcing), civic hacking and provide a basis for the portal of a smart city.

 #mappiamo is a CMS that allows you to create and leverage content through the use of OpenData, the geo-location and microformats. It can be used for processing the data produced by public administrations, collect content (crowdsourcing), civic hacking and provide a basis for the portal of a smart city.
 #mappiamo, is a suitable tool to build websites and combine the contents ensuring ownership and originality for each of the data providers. It is suitable to marketing 3.0 where it is important to the credibility of the sharing of experiential baggage of both operators and consumers.

The cms today allows the insertion of text and multimedia contents. The license management, geotagging and the application of schemes for the representation of linked data is the prerogative of external plugins. All plugins are to install and study separately.
 #mappiamo is also able to take advantage of the shared data, peer-to-peer networks from other sites and thus produce content in compliance with the Linked Data 5 star suggested by Tim Berners-Lee.

### Features for potential customers
In addition to the individual websites of public houses, small communities or associations up to the bigger organizations are able to benefit from the use of open data and web data (linked data). While the sites of tour operators, real estate portals and smart cities would have every incentive to take advantage of the verified data produced by smaller sites.
Just think about the usefulness of free parking spaces, timetables of public transport, bike sharing and other services offered by the community.

Want to collaborate or you just want to test #mappiamo? Join to the project.

### Installation

Download #mappiamo package from GIT, and copy all files to your web host by FTP. Copy files to subdirectory if required, or to public_html root. Login to your control panel or phpMyadmin to create database user with password and add database to user. Give all access rights to your database user. When you copied all files to your host, access to the #mappiamo root by your browser by http. Setup process will be started. Fill all required fields. If the process done without error, you can access to the content manager on the URL: http://[your_host]/manager/

If something changed later (for example database password) edit settings.php from the root of installed #mappiamo.

1) Row 7: Fill or modify your sitename

2) Row 8: Fill or modify your domain

The database access storef from row 14 to 19:

1) Row 14: Database name
2) Row 15: Database type
3) Row 16: Database hostname
4) Row 17: Database prefix
5) Row 18: Database username
6) Row 19: Database password

If you need e-mail service, setup your SMTP provider:

1) Row 21: Your e-mail
2) Row 22: Username for SMTP service
3) Row 23: Password for SMTP service
4) Row 24: Hostname for SMTP service

### Manual

The full #mappiamo manual uploaded here: http://mappiamo.readthedocs.io/en/latest/?badge=latest
