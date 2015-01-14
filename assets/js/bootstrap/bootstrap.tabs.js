//http://stackoverflow.com/questions/10523433/how-do-i-keep-the-current-tab-active-with-twitter-bootstrap-after-a-page-reload/16016592#16016592

$( function() { 
        $( 'a[data-toggle="tab"]' ).on( 'shown.bs.tab', function( e ) {
                //save the latest tab using a cookie:
                $.cookie( 'last_tab', $( e.target ).attr( 'href' ) );

                //update the map for geo tabs
                if ( $( e.target ).attr( 'href' ) === '#geo' && mmap.map !== 'undefined' ) {
                        mmap.map.invalidateSize( false );
                }
        });
        
        //activate latest tab, if it exists:
        var lastTab = $.cookie( 'last_tab' );
        if ( lastTab && $( 'a[href=' + lastTab + ']' ).length ) {
                $( 'a[href=' + lastTab + ']' ).tab( 'show' );
        } else {
                // Set the first tab if cookie do not exist
                $( 'a[data-toggle="tab"]:first' ).tab( 'show' );
        }
});