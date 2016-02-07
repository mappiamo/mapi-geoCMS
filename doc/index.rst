Mappiamo
========

This is the Mappiamo documentation.


Introduction
============

`#mappiamo <http://www.mappiamo.org/>`_ is a CMS that allows you to create and leverage content through the use of OpenData, the geo-location and microformats. It can be used for processing the data produced by public administrations, collecting content (crowdsourcing), civic hacking and providing a basis for the portal of a smart city. 

Installation
=====================

Download #mappiamo package from GIT, and copy all files to your web host by FTP. Copy files to subdirectory if required. Login to your control panel or phpMyadmin to create database user and database. Give all access rights to your database user. When you copied all files to your host, access to the #mappiamo root by your browser. Setup process will be started. Fill all fields. If the process done witohot error, you can access to the content manager on the URL: http://[your_host]/manager/

Widgets on your template
===========================

You can insert several widgets to your own #mappiamo template. You have to edit tamplete files only with your favorite IDE / text editor.

Address
---------

Usage code example:
<?php M_Template::widget('address'); ?>

This widget have no parameters, creating search box for map, the widget centering map for the search address.
The search string must be real name (for example city name) to get real latitude and longitude.

Allmeta box
-------------

Usage code example:
<?php $this->widget('box_allmeta'); ?>

This widget have no parameters, creating list (table) of all meta data of content.
This widget is ideal for right column. The disabled meta names is on the row 13 on the code.

Collabrators box
--------------------

Usage code example:
<?php $this->widget('box_collabrators' array(n)); ?>

This widget have one parameters "n", what is the maximum number of collabotators article based on the selected content. 
The collaborator's e-mail must be saved to the meta value with name "collaborator".

