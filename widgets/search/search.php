<?php

    defined('DACCESS') or die;

    function mwidget_search() {?>
        <div class="search">
            <form action="index.php" method="get">
                <input type="hidden" name="module" value="finder" />
                <input type="text" name="search" class="text" value="" />
                <input type="submit" name="action" class="button" value="Search" />
            </form>
        </div>
    <?PHP } ?>
