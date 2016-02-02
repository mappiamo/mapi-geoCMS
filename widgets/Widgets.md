� Berross (www.berross.com)
license GPL v2.1
Author Perj�s L�szl� (perjeslaszlo@gmail.com)

---------------------------------------------

#Address
##0.0.6

Widget name: Address
Usage code example:

## 	<?php M_Template::widget('address'); ?>


This widget have no parameters, creating search box for map, the widget centering map for the search address.
The search string must be real name (for example city name) to get real latitude and longitude.

#box_allmeta
##0.0.6

Widget name: box_allmeta
Usage code example:

## <?php $this->widget('box_allmeta'); ?>

This widget have no parameters, creating list (table) of all meta data of content.
This widget is ideal for right column. The disabled meta names is on the row 13 on the code.

#box_collabrators
##0.0.6

Widget name: box_collabrators
Usage code example:

## <?php $this->widget('box_collabrators' array(n)); ?>

This widget have one parameters "n", what is the maximum number of collabotators article based on the selected content. 
The collaborator's e-mail must be saved to the meta value with name "collaborator".

#box_cookie
##0.0.6

Widget name: box_cookie
Usage code example:

## <?PHP $this->widget('box_cookie'); ?>

This widget have no parameters, creating alert for cookie usage.

#box_distance
##0.0.6

Widget name: box_distance
Usage code example:

## <?PHP $this->widget('box_distance'); ?>

This widget have no parameters, creating list (table) of related articles not far from the current content.
The distance is fixed on code, the radius is 1 km.

#box_events
##0.0.6

Widget name: box_events
Usage code example:

## <?PHP $this->widget('box_events'); ?>

This widget have no parameters, creating list (table) of events not far from the current content.
The distance is fixed on code, the radius is 1 km.


#box_instagram
##0.0.6

Widget name: box_instagram
Usage code example:

## <?PHP $this->widget('box_instagram', NULL); ?>

This widget have one parameter what is the hashtag for images.
If this parameter missing or NULL, the default hashtag is 'tourism'.
With meta name 'hashtag-instagram' can be overwite the deafult hashtag to anything else.


#box_onemeta
##0.0.6

Widget name: box_onemeta
Usage code example:

##<?PHP $this->widget('box_onemeta', '[meta_name]'); ?>

This widget have one parameter what is the meta name to get the value of only oane meta data.
This widget can be used on the column of main content.

#box_youtube
##0.0.6

Widget name: box_youtube
Usage code example:

## <?php $this->widget('box_youtube', array('[developer key]', '[channel id]', [maximum content])); ?>

This widget have 3 parameters. Developer key, youtube channel id, and the maximum number of youtube content.
This widget can be inserted to the left column, and creating scrollable carousel of selected channel content.


#content_allmeta
##0.0.6

Widget name: content_allmeta
Usage code example:

## <?PHP $this->widget('content_allmeta'); ?>

This widget have no parameters, creating list (table) of meta data from the current content.
This widget created for vretaing list or table of standard schemantic data if available.

#content_headline
##0.0.6

Widget name: content_headline
Usage code example:

## <?PHP $this->widget('content_headline'); ?>

This widget have no parameters, creating group of some data and metadata which are rewuired on content column between title and content text.

#flickr
##0.0.6

Widget name: flickr
Usage code example:

## <?PHP $this->widget('flickr'); ?>

This widget have no parameters, creating flickr image groups on the map by visible box of map.

#form_contact
##0.0.6

Widget name: form_contact
Usage code example:

## <?PHP $this->widget('form_contact', array('[registered username]')); ?>

This widget have one parameter, the parameter must be the username of registered Mappiamo user.
This widget creating form with input fileds for sending simple message with server side validation. 


#gravatar
##0.0.6

Widget name: gravatar
Usage code example:

## <img src="<?PHP M_Template::widget('gravatar', array(NULL)); ?>" style="height: 42px; border-radius: 21px; position: relative; top: -8px;" />

This widget included to the content module, cannot use on the template or view.
The widget fetting gravatar icon by the user's e-mail address, if the user registered on this service.


#jplayer
##0.0.6

Widget name: jplayer
Usage code example:

## <?PHP $this->widget('jplayer'); ?>

This widget have no parameters, creating javascript player for audio (or video) content.
The required meta name is 'audio' and the meta value must be the full url of audio or video file.

#videobox
##0.0.6

Widget name: videobox
Usage code example:

## <?PHP $this->widget('videobox'); ?>

This widget have no parameters, creating embedd iframe player for youtube content by full url.
The required meta name is 'videobox' and the meta value must be the full url of youtube video.

#lastcontent
##0.0.6

Widget name: lastcontent
Usage code example:

## <?php $this->widget('lastcontent', array(5)); ?>
## <?php $this->widget('lastcontent', array(5, 'event', 'start', 'from_now')); ?>
## <?php $this->widget('lastcontent', array(5, 'post', 'created')); ?>

This widget have parameters. The first is the maximum number of content, this is required.
All other paramteres are optional: [content type], [ordering column name], 
and if the content type is 'event', the last parameter 'from_now' shows only current and future events.

#leaflet_panel
##0.0.6

Widget name: leaflet_panel
Usage code example:

## <?PHP $this->widget('leaflet_panel'); ?>

This widget have no parameters, creating four icons on the map for search box and menus.
This custom project widget without setup or parameters.


#menu_full
##0.0.6

Widget name: menu_full
Usage code example:

## <?php M_Template::widget('menu_full', array('[category name]', '[treemenu|popmenu]', '09', 'check')); ?>

This widget have parameters. Creating custom menu system by Mappiamo "pages" and "menus", and display
selected categories on the map.

the parameters: 
1, The category name
2, Menu type: 'treemenu' or 'popmenu'
3, Template number of menu only. Menus have 15 templates.
4, How menu display the selected catorgory contents: 
    'link' - the category opens new page with content list
    'check' - the category displays as marker on the map
    
    
#owl_image
##0.0.6

Widget name: owl_image
Usage code example:

## <?PHP $this->widget('owl_image', array('category', 4, 60)); ?>
## <?PHP $this->widget('owl_image', array('path', 6, 'templates/soccorso/images/partners', 'index.php?module=category&object=59')); ?>

This widget have parameters, creating image carousel to the content column.
The source images can get from two different source: 'category' or 'path'. This is the first parameter.
If the image source is 'path', the 3rd parameter must be the relative path to the directory contains images.
If the image source is 'category', the 3rd parameter must be the id number of category where the widget reads all images from content.
The second parameter is the maximum number of items to show.
The 4th parameter is the link to open when user click on image. This is optional. If the source is 'category', the link
will open the document contains clicked image.


#owl_video
##0.0.6

Widget name: owl_video
Usage code example:

## $TubeID = array('jkovdYV0qm0', 'dw6wZQkfsn0', 'CqdSzVXkhmY', 'km3JiaPqWMI', 'NyCwOdyhZco', 'YJTxnhjpF3U', 'HOVYTZkvjH8', '2Tlou1Vdg6Y', '0_rtwI_nUlI', 'LCtp7D0uCjA');
## $this->widget('owl_video', array($TubeID, 3));

This widget have parameters, creating video carousel to the content column.
The first parameter must be an array, contains all youtube video id required for the carousel.
The second parameter is how many videos display at once by the carousel.


#routes
##0.0.6

Widget name: routes
Usage code example:

## <?php $this->widget('routes'); ?>

This widget created for custom project only.
Display all possible data on the map by customized menu system.

#togglemenu
##0.0.6

Widget name: togglemenu
Usage code example:

## <?php $this->widget('togglemenu'); ?>

This widget created for custom project only.
Display customized menu on the map.
The menu code reads from the template by language setting.

#weather
##0.0.6

Widget name: weather
Usage code example:

## <?PHP $this->widget('weather'); ?>

This widget have no parameters, creating weather report on the map.

© Berross (www.berross.com)
license GPL v2.1
Author Perjés László (perjeslaszlo@gmail.com)

#disqus
##0.0.6

Widget name: disqus
Usage code example:

## <?php M_Template::widget('disqus'); ?>

This widget have no parameters. Creating comment section on content page.
Disqus account and disqus site name required for preferences.