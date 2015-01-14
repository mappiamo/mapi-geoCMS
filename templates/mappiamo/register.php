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
        </div>

</body>