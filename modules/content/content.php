<?php

	// no direct access to this file
	defined('DACCESS') or die;

	class MModule_Content extends M_Module {

		private $content;
		private $content_id;

		public function content() {
			$task = $this->get_task();

			if (!$task) {
				//getting language
				$language = new M_Language;
				$lang = $language->getLanguage();

				$this->content = MObject::get('content', $this->get_object());
				//print_r($this->content); die();

				if ($lang == $this->content->get_language()) {
					//var_dump($lang); die();//megfelel a nyelv, kiolvassuk.
					$this->content = MObject::get('content', $this->get_object());
				} else {
					//nem felel meg, megnezzuk van-e olyan nyelvu forditasa
					$this->content_id =
					$this->model('get_translation', array("content" => $this->get_object(), "lang" => strval($lang)));
					$this->content = MObject::get('content', intval($this->content_id));
				}


				if ($this->content) {
					global $content;
					$content = $this->content;

					if ($this->content->is_enabled() == FALSE) {
						header('Location: index.php?module=page404');
						exit(0);
					}

					global $coords;
					$coords['lat'] = $this->content->get_lat();
					$coords['lng'] = $this->content->get_lng();

					$this->set_page_title($this->content->get_title());

					$content_meta = $content->get_meta();
					if (sizeof($content_meta) > 0) {
						foreach ($content_meta as $meta) {
							switch ($meta->name) {
								case 'description':
								case 'keywords':
								case 'author':
								case 'robots':
									$this->add_page_meta($meta->name, $meta->value);
									break;
							}
						}
					}

					$this->model('add_hit', $content->get_id());

					$this->view('default', $content);
				} else {
					header('Location: index.php?module=page404');
					exit(0);
				}
			}
		}

		public function get_category() {
			$this->set_as_ajax();

			$contents = $this->model('add_category', $this->get_object(), 'content_map');
			echo json_encode($contents);
		}

	}

?>