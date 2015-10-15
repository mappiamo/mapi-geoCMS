function MMap() {
        this.map = null;
        this.marker = null;
        this.markers = new Array();

        this.proba = 'hello!';

        this.set_lat = function( lat ) {
                if ( typeof( lat ) !== 'number' ) this.lat = 40.36329;
                else this.lat = lat;
        }

        this.set_lng = function( lng ) {
                if ( typeof( lng ) !== 'number' ) this.lng = 18.17278;
                else this.lng = lng;
        }

        this.set_zoom = function( zoom ) {
                if ( typeof( zoom ) !== 'number' || zoom < 1 || zoom > 18 ) this.zoom = 12;
                else this.zoom = zoom;
        }

        this.create_map = function( container ) {
                if ( typeof( this.lat ) === 'undefined' ) this.set_lat();
                if ( typeof( this.lng ) === 'undefined' ) this.set_lng();

                if ( typeof( this.zoom )  === 'undefined' ) this.set_zoom();

                var map_options = { center: new L.LatLng( this.lat, this.lng ), zoom: this.zoom, zoomControl: false, scrollWheelZoom: false };
                this.map = new L.Map( container, map_options );

                L.control.zoom( { position: 'topleft' } ).addTo( this.map );

                L.tileLayer( 
                        'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', 
                        {
                                attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Powered by © <a href="http://dev.mappiamo.org">#Mappiamo</a>',
                                maxZoom: 18
                        }
                ).addTo( this.map );
        }

        this.create_marker = function( drag ) {
                if ( typeof( drag ) === undefined ) var drag = false;

                if ( typeof( this.lat ) === undefined ) this.set_lat();
                if ( typeof( this.lng ) === undefined ) this.set_lng();

                var marker_options = { draggable: drag }
                this.marker = L.marker( [this.lat, this.lng], marker_options ).addTo( this.map );
        }

        this.add_marker = function( lat, lng, category ) {
                if ( typeof( lat ) !== 'number' ) return null;
                if ( typeof( lng ) !== 'number' ) return null;

                var add = true;

                if ( this.marker ) {
                        var position = this.marker.getLatLng();
                        
                        if ( lat == position.lat && lng == position.lng ) add = false;
                }

                if ( add ) {
                        var icon = L.icon( { iconUrl: 'media/mapicons/' + encodeURIComponent( category ) + '.png', iconSize: [32, 37], iconAnchor: [16, 37] } );
                        var marker = L.marker( [lat, lng], { icon: icon } ).addTo( this.map );

                        return marker;
                } else {
                        return null;
                }
        }

        this.clear_markers = function() {
                if ( ! this.markers.length > 0 ) return null;
                
                for ( var i = 0; i < this.markers.length; i++ ) this.map.removeLayer( this.markers[i] );

                this.markers = new Array();
        }

        this.create_categories = function( id ) {
                if ( typeof( id ) !== 'number' ) return null;

                var query = $.ajax( { dataType: "json", context: this, url: 'index.php?module=content&task=get_category&object=' + id } );
                query.done( function( data ) { 
                        if ( data.length > 0 ) {
                                for ( var i = 0; i < data.length; i++ ) {
                                        if ( data[i].lat == undefined ) continue;
                                        if ( data[i].lng == undefined ) continue;
                                        if ( data[i].category == undefined ) continue;

                                        marker = this.add_marker( data[i].lat, data[i].lng, data[i].category );

                                        if ( marker === null ) continue;

                                        var mcontent = "";
                                        mcontent += "</h3>" + data[i].title + "</h3>";
                                        mcontent += "<p>" + data[i].text + "</p>";

                                        marker.bindPopup( mcontent );

                                        this.markers.push( marker );

                                        marker.content = new Object();
                                        if ( data[i].title !== undefined ) marker.content.title = data[i].title;
                                        if ( data[i].text !== undefined ) marker.content.text = data[i].text;

                                        marker.on( 'click', function( e ) {
                                                $( '#mmap_modal_title' ).html( this.content.title );
                                                $( '#mmap_modal_body' ).html( this.content.text );
                                                $( '#mmap_modal' ).modal( 'show' );
                                        } );
                                }
                        }
                } );
        }

        this.update_inputs = function() {
                this.marker.on( 'dragend', function( e ) {
                        var marker_position = e.target.getLatLng();
                        if ( typeof( marker_position.lat ) === 'number' ) $( '#content_lat' ).val( marker_position.lat );
                        if ( typeof( marker_position.lng ) === 'number' ) $( '#content_lng' ).val( marker_position.lng );
                } );
        }

        this.address_search = function() {
                map = this.map;
                marker = this.marker;

                $( '#location' ).focusout( function(){
                        if ( ! $( '#location' ).val() ) return null;

                        var module = 'majax';

                        var url = 'index.php?module=' + module + '&task=geocode';
                        url += '&address=' + $( '#location' ).val();
                        url += '&mapi_csrf=' + encodeURIComponent( $( '#mapi_csrf' ).val() );

                        $.ajax( { url: url, dataType: "json" } ).done( function( result ) {
                                if ( result.status === 'OK' ) {
                                        if ( $( '#DefaultLatitude' ) ) $( '#DefaultLatitude' ).val( result.lat );
                                        if ( $( '#DefaultLongitude' ) ) $( '#DefaultLongitude' ).val( result.lng );
                                } else {
                                        alert( 'Address not found!' );
                                }
                        });

                });

                $( '#content_address' ).focusout( function(){
                        if ( ! $( '#content_address' ).val() ) return null;

                        if( $( '#mapi_mode' ) && 'ajax' == $( '#mapi_mode' ).val() ) var module = 'ajax';
                        else var module = 'majax';

                        var url = 'index.php?module=' + module + '&task=geocode';
                        url += '&address=' + $( '#content_address' ).val();
                        url += '&mapi_csrf=' + encodeURIComponent( $( '#mapi_csrf' ).val() );

                        if ( '#address_button' ) $( '#address_button' ).html( 'Searching ...' );

                                $.ajax( { url: url, dataType: "json" } ).done( function( result ) {
                                        if ( result.status === 'OK' ) {
                                                if ( $( '#content_lat' ) ) $( '#content_lat' ).val( result.lat );
                                                if ( $( '#content_lat' ) ) $( '#content_lng' ).val( result.lng );
                                                map.panTo( [result.lat, result.lng] );
                                                marker.setLatLng( [result.lat, result.lng] );
                                        } else {
                                                alert( 'Address not found!' );
                                        }
                                } ).done( function() {
                                    if ( '#address_button' ) $( '#address_button' ).html( 'Go!' );
                                } );
                } );
        }

        //this.create_map();
        //this.create_marker();
}
