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

- Usage code example::

    <?php M_Template::widget('address'); ?>

This widget have no parameters, creating search box for map, the widget centering map for the search address.
The search string must be real name (for example city name) to get real latitude and longitude.

Bottom menu
------------

- Usage code example::

    <?php M_Template::widget('bottommenu', array($ID)); ?>

Display bottom menu items. This widget have 1 parameter, the menu ID.

Allmeta box
-------------

- Usage code example::

    <?php $this->widget('box_allmeta'); ?>

This widget have no parameters, creating list (table) of all meta data of content.
This widget is ideal for right column. The disabled meta names is on the row 13 on the code.

Box
-----

- Usage code example::

    <?php M_Template::widget('box', array($image, $title, $desc, $link)); ?>

This widget display image box, using four parameters.

Collabrators box
--------------------

- Usage code example::

    <?php $this->widget('box_collabrators' array(n)); ?>

This widget have one parameters "n", what is the maximum number of collabotators article based on the selected content. 
The collaborator's e-mail must be saved to the meta value with name "collaborator".

Cookie box
------------

- Usage code example::

    <?PHP $this->widget('box_cookie'); ?>

This widget have no parameters, creating alert box for cookie usage.

Distance box
---------------

- Usage code example::

    <?PHP $this->widget('box_distance'); ?>

This widget have no parameters, creating list (table) of related articles not far from the current content.
The distance is fixed on code, the radius is 1 km.

Events box
-----------

- Usage code example::

    <?PHP $this->widget('box_events'); ?>

This widget have no parameters, creating list (table) of events not far from the current content.
The distance is fixed on code, the radius is 1 km.

Instagram box
----------------

- Usage code example::

    <?PHP $this->widget('box_instagram', NULL); ?>

This widget have one parameter what is the hashtag for images.
If this parameter missing or NULL, the default hashtag is 'tourism'.
With meta name 'hashtag-instagram' can be overwite the deafult hashtag to anything else.

Onemeta box
------------

- Usage code example::

    <?PHP $this->widget('box_onemeta', '[meta_name]'); ?>

This widget have one parameter what is the meta name to get the value of only oane meta data.
This widget can be used on the column of main content.

Youtube box
--------------

- Usage code example::

    <?php $this->widget('box_youtube', array('[developer key]', '[channel id]', [maximum content])); ?>

This widget have 3 parameters. Developer key, youtube channel id, and the maximum number of youtube content.
This widget can be inserted to the left column, and creating scrollable carousel of selected channel content.

Allmeta
----------

- Usage code example::

    <?PHP $this->widget('content_allmeta'); ?>

This widget have no parameters, creating list (table) of meta data from the current content.
This widget created for list or table of standard schemantic data if available.

Slideshow
-----------

- Usage code example::

    <?PHP $this->widget('content_slideshow'); ?>

This widget have no parameters, creating slideshow on the content column from all images included to the current content.

Divided menu
--------------

- Usage code example::

    <?php M_Template::widget('dividedmenu', array($ID)); ?>

Display divided menu. This widget have 1 parameter, the menu ID.

Dropdown menu
--------------

- Usage code example::

    <?php M_Template::widget('dropdownmenu', array($ID)); ?>

Display dropdown menu. This widget have 1 parameter, the menu ID.

Intro
---------

- Usage code example::

    <?PHP $this->widget('intro'); ?>

This widget have no parameters, display intro image.

Headline
---------

- Usage code example::

    <?PHP $this->widget('content_headline'); ?>

This widget have no parameters, creating group of some data and metadata which are rewired on content column between title and content text.

Flickr
--------

- Usage code example::

    <?PHP $this->widget('flickr'); ?>

This widget have no parameters, creating flickr image groups on the map by visible box of map.

Form contact
---------------

- Usage code example::

    <?PHP $this->widget('form_contact', array('[registered username]')); ?>

This widget have one parameter, the parameter must be the username of registered Mappiamo user.
This widget creating form with input fileds for sending simple message with server side validation. 

Gravatar
----------

This widget included to the content module, cannot use on the template or view.
The widget fetching gravatar icon by the user's e-mail address, if the user registered on this service.

Jplayer
-------

- Usage code example::

    <?PHP $this->widget('jplayer'); ?>

This widget have no parameters, creating javascript player for audio (or video) content.
The required meta name is 'audio' and the meta value must be the full url of audio or video file.

Map
----

- Usage code example::

    <?PHP $this->widget('map' array($zoom)); ?>

This widget have 1 parameter, the default zoom. This widget display map on the conent page.

Menu
-----

- Usage code example::

    <?PHP $this->widget('menu' array($ID)); ?>

This widget have 1 parameter, the menu id. This widget display menu item.

Video box
-----------

- Usage code example::

    <?PHP $this->widget('videobox'); ?>

This widget have no parameters, creating embedd iframe player for youtube content by full url.
The required meta name is 'videobox' and the meta value must be the full url of youtube video.

Lastcontent
--------------

- Usage code examples::

    <?php $this->widget('lastcontent', array(5)); ?>
    <?php $this->widget('lastcontent', array(5, 'event', 'start', 'from_now')); ?>
    <?php $this->widget('lastcontent', array(5, 'post', 'created')); ?>

This widget have parameters. The first is the maximum number of content, this is required.
All other paramteres are optional: [content type], [ordering column name], 
and if the content type is 'event', the last parameter 'from_now' shows only current and future events.

Full featured menu
----------

- Usage code example::

    <?php M_Template::widget('menu_full', array('[category name]', '[treemenu|popmenu]', '09', 'check')); ?>

This widget have parameters. Creating custom menu system by Mappiamo "pages" and "menus", and display
selected categories on the map.

- Parameters:
1) The category name
2) Menu type: 'treemenu' or 'popmenu'
3) Template number of menu only. Menus have 15 templates.
4) How menu display the selected catorgory contents: 'link' - the category opens new page with content list 'check' - the category displays as marker on the map
    
Owl image
------------

- Usage code example::

    <?PHP $this->widget('owl_image', array('category', 4, 60)); ?>
    <?PHP $this->widget('owl_image', array('path', 6, 'templates/soccorso/images/partners', 'index.php?module=category&object=59')); ?>

This widget have parameters, creating image carousel to the content column.
The source images can get from two different source: 'category' or 'path'. This is the first parameter.
If the image source is 'path', the 3rd parameter must be the relative path to the directory contains images.
If the image source is 'category', the 3rd parameter must be the id number of category where the widget reads all images from content.
The second parameter is the maximum number of items to show.
The 4th parameter is the link to open when user click on image. This is optional. If the source is 'category', the link
will open the document contains clicked image.

Owl video
-------------

- Usage code example::

    $TubeID = array('jkovdYV0qm0', 'dw6wZQkfsn0', 'CqdSzVXkhmY', 'km3JiaPqWMI', 'NyCwOdyhZco', 'YJTxnhjpF3U', 'HOVYTZkvjH8', '2Tlou1Vdg6Y', '0_rtwI_nUlI', 'LCtp7D0uCjA');
    $this->widget('owl_video', array($TubeID, 3));

This widget have parameters, creating video carousel to the content column.
The first parameter must be an array, contains all youtube video id required for the carousel.
The second parameter is how many videos display at once by the carousel.

Share
------

- Usage code example::

    <?PHP $this->widget('share', array($site_id)); ?>

Share content on sicial networks.

Slider
--------

- Usage code example::

    <?PHP $this->widget('slider', array($content_id)); ?>

This widget creating image slider from the content by content ID.

Weather
--------

- Usage code example::

    <?PHP $this->widget('weather'); ?>

This widget have no parameters, creating weather report on the map.

Disqus
----------

- Usage code example::

    $Types = array('post', 'event');
    <?php M_Template::widget('disqus', array($Types)); ?>

This widget have no parameter as array. Creating comment section on content page.
Disqus account and disqus site name required for preferences. The parameter contains types where the disqus available. 
