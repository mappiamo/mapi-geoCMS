function MMapControl( map ) {
		this.map = map;

		this.auto_on = function( id ) {
				args = { 
							data: { 
									cat_id: id, 
									map: this.map 
							} 
				};
				this.toggle_categories( args );
		}

		this.toggle_categories = function( args ) {
				args.data.map.clear_markers();

				var categories = new Array();

				if ( args.data.cat_id != undefined ) {
                		categories.push( args.data.cat_id );
            	}

                $( 'input[name="mmap_category[]"]:checked').each( function() {
                		var cat_id = parseInt( $( this ).val() );
                		categories.push( cat_id );
                } );

                for ( var i = 0; i < categories.length; i++ ) {
                        args.data.map.create_categories( categories[i] );
                }
		}

		$( 'input[name="mmap_category[]"]').bind( 'change', { map: this.map }, this.toggle_categories );
}