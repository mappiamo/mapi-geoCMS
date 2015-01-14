<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<body>
        <nav>
                <?php include( 'nav.php' ); ?>
        </nav>

        <section class="map" id="mapbanner">
                <?php $this->widget( 'map', array( 9, 10 ) ); ?>
        </section>

        <div class="container marketing">

                <div class="row">
                        <div class="col-lg-4">
                                <?php $this->widget( 'content_market', 245 ); ?>
                        </div>
                        <div class="col-lg-4">
                                <?php $this->widget( 'content_market', 243 ); ?>
                        </div>
                        <div class="col-lg-4">
                                <?php $this->widget( 'content_market', 244 ); ?>
                        </div>
                </div>

                <hr class="featurette-divider">

                <div class="row featurette">
                        <div class="col-md-7">
                                <?php $this->widget( 'content', 246 ); ?>
                        </div>
                        <div class="col-md-5">
                                <?php $this->widget( 'content_image', 246 ); ?>
                        </div>
                </div>

                <hr class="featurette-divider">

                <div class="row featurette">
                        <div class="col-md-5">
                                <?php $this->widget( 'content_image', 247 ); ?>
                        </div>
                        <div class="col-md-7">
                                <?php $this->widget( 'content', 247 ); ?>
                        </div>
                </div>

                <hr class="featurette-divider">

                <div class="row featurette">
                        <div class="col-md-7">
                                <?php $this->widget( 'content', 248 ); ?>
                        </div>
                        <div class="col-md-5">
                                <?php $this->widget( 'content_image', 248 ); ?>
                        </div>
                </div>

                <hr class="featurette-divider">

                <footer>
                    <p class="pull-right"><a href="#">Back to top</a></p>
                    <p>&copy; 2014 #mappiamo</p>
                </footer>

        </div>

</body>