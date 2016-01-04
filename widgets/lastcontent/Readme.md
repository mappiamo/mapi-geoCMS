© Berross (www.berross.com)
license GPL v2.1
Author Perjés László (perjeslaszlo@gmail.com)

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