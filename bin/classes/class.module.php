<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class M_Module extends M_Extension {

		private $task;
		private $object;

		private $output;

		private $ajaxrun = false;

		public function __construct() {
				$this->set_type();
		}

		public function instance( $name = null, $task = null, $object = null ) {
				if ( ! $name || ! $this->valid( $name ) ) {
						if ( 'manager' == ENV ) $name = 'dashboard';
						else {
								$name = $this->get_default();

								if ( ! $name ) $name = 'page404';
						}
				}

				if ( $task && MValidate::task( $task ) ) $this->task = $task;
	 			if ( $object && MValidate::object( $object ) ) $this->object = $object;

				if ( $this->get_details( $name ) ) return $this->run();
				else die( 'M_ERROR (00201): Cannot load module: Module not found' );
		}

		public function model( $function, $parms = array(), $model = null ) {
				if ( ! MValidate::varname( $function ) ) return null;

				if ( ! $model || ! MValidate::varname( $model ) ) $model = $this->get_name();
				
				$init = 'models:' . $model;
				$model = 'MModel_' . $model;

				mapi_include_abs_path( $init, $this->get_wdir() );

				if ( ! class_exists( $model ) ) die( 'M_ERROR (00206): Cannot run model: Model class for ' . $model . ' not found' );
				if ( ! method_exists( $model, $function ) ) die( 'M_ERROR (00207): Cannot run model: Model method ' . $function . ' not found' );

				if ( ! is_array( $parms ) ) $parms = array( $parms );

				if ( isset( $parms ) && is_array( $parms ) ) return call_user_func_array( $model . '::' . $function, $parms );
				elseif ( isset( $parms ) && ! is_array( $parms ) ) return call_user_func( $model . '::' . $function, $parms );
				else return call_user_func( $model . '::' . $function );
		}

		public function view( $view = null, $data = null ) {
				if ( ! $view || ! MValidate::varname( $view ) ) $view = 'default';

				$init = 'views:' . $view;
				$viewfile = mapi_abs_path( $init, $this->get_wdir() );

				if ( is_file( $viewfile ) && is_readable( $viewfile ) ) include_once( $viewfile );
		}

		public function get_task() {
				return $this->task;
		}

		public function get_object() {
				return $this->object;
		}

		public function get_output() {
				return $this->output;
		}

		public function is_ajax() {
				return $this->ajaxrun;
		}

		public function set_as_ajax( $ajax = true ) {
				//if ( ! MValidate::is_ajax() ) {
				//		header( 'Location: index.php' );
				//		exit( 0 );
				//}

				if ( $ajax ) $this->ajaxrun = true; 
		}

		private function run() {
				if ( ! $this->get_wdir() || ! $this->get_name() ) die( 'M_ERROR (00202): Cannot load module: Module details are missing' );

				if( ! mapi_include_abs_path( $this->get_name(), $this->get_wdir() ) ) die( 'M_ERROR (00203): Cannot load module: Init file missing or not readable' );

				$controller_class = 'MModule_' . $this->get_name();

				if ( ! class_exists( $controller_class ) ) die( 'M_ERROR (00204): Cannot load module: Controller is missing' );

				$default_function = $this->get_name();

				if ( ! method_exists( $controller_class, $default_function ) ) die( 'M_ERROR (00205): Cannot load module: Controller function is missing' );

				$module = new $controller_class();
				$this->set_child_details( $module );

				ob_start();

						$module->prerun();

						if ( isset( $this->task ) ) $module->task = $this->task;
						if ( isset( $this->object ) ) $module->object = $this->object;

						$module->$default_function();

						$this->run_task( $module, $controller_class );

						$module->output = ob_get_contents();

				ob_end_clean();

				return $module;
		}

		private function run_task( $module, $controller ) {
				if ( ! is_object( $module ) ) return null;

				$task = null;

				if ( $this->task && $controller ) {
						if ( method_exists( $controller, $this->task ) ) $task = $this->task;
				}

				if ( $task ) $module->$task();
		}

}

?>