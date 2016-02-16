<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MTable {

		static $id;
		static $header;
		static $rename_header;
		static $columns;
		static $objects;
		static $radio_select;
		static $radio_select_current = null;
		static $checkbox_select;
		static $checkbox_select_current = null;
		static $actions;
		static $links;
		static $badges;
		static $binaries;

		static $init = null;

		public function __construct(){
		}

		static function init( $objects, $id = null ) {
				if ( ! self::$init ) {
						self::$init = true;
						self::defaults();
						self::objects( $objects );
						if ( $id ) self::id( $id );
				}
		}

		static function defaults() {
				self::$id = 'mapi_table';
				self::$header = true;
				self::$columns = array();
				self::$objects = array();
				self::$radio_select = array();
				self::$checkbox_select = array();
				self::$actions = array();
				self::$links = array();
				self::$badges = array();
				self::$binaries = array();
		}

		static function id( $value ) {
				if ( $id = strval( $value ) ) self::$id = $id;
		}

		static function header( $value ) {
				if ( ! $value ) self::$header = false;
		}

		static function rename_header( $value ) {
				if ( is_array( $value ) ) self::$rename_header = $value;
		}

		static function columns( $columns ) {
				if ( is_array( $columns ) && sizeof( $columns ) > 0 ) self::$columns = $columns;
		}

		static function columns_from_objects() {
				$columns = array();

				if( sizeof( self::$objects ) > 0 ) {
						$columns = get_object_vars( current( self::$objects ) );
						if ( ! $columns ) {
								$columns = array_keys( current( self::$objects )->as_array() );
						}
				}

				self::$columns = $columns;
		}

		static function objects( $objects ) {
				if ( is_array( $objects ) && sizeof( $objects ) > 0 ) self::$objects = $objects;
		}

		static function radio_select( $value, $current ) {
				if ( $radio_select = strval( $value ) ) self::$radio_select = $radio_select;
				if ( $radio_select_current = strval( $current ) ) self::$radio_select_current = $radio_select_current;
		}

		static function checkbox_select( $value, $current ) {
				if ( $checkbox_select = strval( $value ) ) self::$checkbox_select = $checkbox_select;
				if ( $checkbox_select_current = strval( $current ) ) self::$checkbox_select_current = $checkbox_select_current;
		}

		static function actions( $actions ) {
				if ( is_array( $actions ) && sizeof( $actions ) > 0 ) self::$actions = $actions;
		}

		static function links( $links ) {
				if ( is_array( $links ) && sizeof( $links ) > 0 ) self::$links = $links;
		}

		static function badges( $badges ) {
				if ( is_array( $badges ) && sizeof( $badges ) > 0 ) self::$badges = $badges;
		}

		static function binaries( $binaries ) {
				if ( is_array( $binaries ) && sizeof( $binaries ) > 0 ) self::$binaries = $binaries;
		}

		static function show() {
				if ( ! self::$init ) return null;

				self::table_head();
				self::table_body();
				self::table_foot();

				self::$init = null;
		}

		static function table_head() {
				if ( self::$header ) {
						echo '<div class="m-content-list"><div class="panel panel-default"><div class="panel-heading">&nbsp;</div>';
				}

				echo '<table class="table mapi-table" id="' . MPut::html_id( self::$id ) . '">';

				echo '<thead>';

						echo '<tr>';

						if ( self::$radio_select ) {
								echo '<th>&nbsp;</th>';
						}

						if ( self::$checkbox_select ) {
								echo '<th>&nbsp;</th>';
						}

						foreach ( self::$columns as $column ) {
								if ( isset( self::$rename_header[$column] ) ) echo '<th>' . MPut::html( self::$rename_header[$column] ) . '</th>';
								else echo '<th>' . MPut::html( $column ) . '</th>';
						}

						if ( sizeof( self::$actions ) > 0 ) {
								echo '<th></th>';
						}

						echo '</tr>';

				echo '</thead>';
		}

		static function table_body() {
				if ( ! sizeof( self::$objects ) > 0 ) self::nodata();

				if ( ! sizeof( self::$columns ) > 0 ) self::columns_from_objects();

				foreach ( self::$objects as $object ) {
						echo '<tr>';
								if ( self::$radio_select && in_array( self::$radio_select, self::$columns ) ) {
										$r_column = self::$radio_select;
										echo '<td>';
												if ( $object->$r_column == self::$radio_select_current ) {
														echo '<input type="radio" name="' . self::$id . '" value="' . $object->$r_column . '" checked="checked" />';
												} else {
														echo '<input type="radio" name="' . self::$id . '" value="' . $object->$r_column . '" />';
												}
										echo '</td>';
								}

								if ( self::$checkbox_select && in_array( self::$checkbox_select, self::$columns ) ) {
										$c_column = self::$checkbox_select;
										echo '<td>';
										if ( $object->$c_column == self::$checkbox_select_current ) {
												echo '<input type="checkbox" name="' . self::$id . '" value="' . $object->$c_column . '" checked="checked" />';
										} else {
												echo '<input type="checkbox" name="' . self::$id . '" value="' . $object->$c_column . '" />';
										}
										echo '</td>';
								}

								foreach ( self::$columns as $column ) {
										if ( isset( $object->$column ) ) { 
												echo '<td>';
														if ( isset( self::$links[$column] ) ) self::put_data_linked( $object, $object->$column, self::$links[$column] );
														elseif ( in_array( $column, self::$badges ) ) self::put_data_badged( $object->$column );
														elseif ( in_array( $column, self::$binaries ) ) self::put_data_binary( $object->$column );
														else self::put_data( $object->$column );
												echo '</td>';
										}
								}

								if ( sizeof( self::$actions ) > 0 ) {
										echo '<td>';
										foreach ( self::$actions as $key => $value ) {
												self::put_action( $key, $value, $object );
										}
										echo '</td>';
								}
						echo '</tr>';
				}
		}

		static function table_foot() {
				echo '</table>';

				if ( self::$header && sizeof( self::$objects ) > 0 ) {
						echo '<script type="text/javascript">$( document ).ready( function() { $( \'#' . MPut::html_id( self::$id ) . '\' ).dataTable(); } );</script>';
						echo '</div></div>';
				} elseif( self::$header ) {
						echo '</div></div>';
				}
		}

		static function put_data( $data ) {
				MPut::_html( $data );
		}

		static function put_data_linked( $object, $data, $link ) {
				if ( ! is_object( $object ) ) {
						self::put_data( $data );
						return null;
				}

				$link = MHTML::action( $link, $object );

				MHTML::link( $data, $link );
		}

		static function put_data_badged( $data ) {
				MHTML::badge( $data );
		}

		static function put_data_binary( $data ) {
				MHTML::binary( $data );
		}

		static function put_action( $title, $js, $object = null ) {
				if ( $object && ! is_object( $object ) ) return null;

				if ( $object ) $js = MHTML::action( $js, $object );

				echo '<button type="button" class="btn btn-xs" onclick=' . MPut::js( $js ) . ' style="float: right;">' . MPut::html( $title ) . '</button>';
		}
		static function nodata() {
				echo '<tr><td colspan="' . sizeof( self::$columns ) . '">Nothing to display</td></tr>';
		}

}