<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<body>
        <nav>
                <?php include( 'nav.php' ); ?>
        </nav>

        <div class="container">
                <?php echo $this->content; ?>

                <div style="clear: both;"></div>

                <div id="mapcontent">
                        <?php $this->widget( 'map', array( 9, 10 ) ); ?>
                </div>
        </div>

        <div class="container">
                <footer>
                        <p class="pull-right"><a href="#">Back to top</a></p>
                        <p>&copy; 2014 #mappiamo</p>
                </footer>
        </div>
</body>