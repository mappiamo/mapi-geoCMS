<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class M_Widget extends M_Extension {

		protected $type = 'widget';

		private $content = '';

		public function __construct( $name, $parms ) {
				if ( 'manager' == ENV ) return null;

				$this->set_type();

				if ( $name && $this->valid( $name ) ) {
						$this->get_details( $name );
						$this->render( $parms );
				}
		}

		public function get_content() {
				return $this->content;
		}

		private function render( $parms ) {
				if ( ! $this->get_wdir() || ! $this->get_name() ) return null;

				if( ! mapi_include_abs_path( $this->get_name(), $this->get_wdir() ) ) return null;

				$function = 'mwidget_' . $this->get_name();

				if ( ! function_exists( $function ) ) return null;

				ob_start();

						if ( is_array( $parms ) ) call_user_func_array( $function, $parms );
						elseif ( ! empty( $parms ) ) $function( $parms );
						else $function();

						if ( isset( $this->object ) ) $module->object = $this->object;

						$this->content = ob_get_contents();

				ob_end_clean();
		}

}

?>