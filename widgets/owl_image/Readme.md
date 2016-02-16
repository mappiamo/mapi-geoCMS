© Berross (www.berross.com)
license GPL v2.1
Author Perjés László (perjeslaszlo@gmail.com)

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