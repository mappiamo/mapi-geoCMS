<?php

	// no direct access to this file
	defined('DACCESS') or die;

	class MModel_MPage {

		static function get_pages() {
			return mapi_list('pages');
		}

		static function get_page($id) {
			$page = MObject::get('page', $id);

			if ($page && is_numeric($page->get_id())) {
				return $page;
			} else {
				return NULL;
			}
		}

		static function add_page() {
			$page = MObject::create('page');
			$page->set_type(MGet::string('page_type'));
			$page->set_title(MGet::string('page_title'));
			$page->set_url(MGet::string('page_url'));

			if (1 == MGet::int('page_on_blank')) {
				$page->set_on_blank(1);
			} else {
				$page->set_on_blank(0);
			}

			$page->add();

			if (0 == (MMessaging::any_errors() + MMessaging::any_warnings())) {
				return $page;
			} else {
				return FALSE;
			}

		}

		static function update_page($id) {
			$page = self::get_page($id);

			if ($page) {
				$page->set_type(MGet::string('page_type'));
				$page->set_title(MGet::string('page_title'));
				$page->set_url(MGet::string('page_url'));

				if (1 == MGet::int('page_on_blank')) {
					$page->set_on_blank(1);
				} else {
					$page->set_on_blank(0);
				}
				if (1 == MGet::int('page_enabled')) {
					$page->set_enabled(1);
				} else {
					$page->set_enabled(0);
				}

				$page->update();
			}
		}

		static function delete_page($id) {
			$page = self::get_page($id);

			if ($page) {
				$page->delete();
			}
		}

		static function add_menu($page_id) {
			$id = MGet::get('menu_id');

			if (filter_var($id, FILTER_VALIDATE_INT)) {
				$menu = MObject::get('menu', $id);
				if ($menu) {
					$menu->add_page($page_id);
					$menu->update(FALSE);
				}
			} else {
				$MenuArray = explode('_', $id);
				if (count($MenuArray) >= 2) {
					//$TheLastID = array_pop($MenuArray);
					//$CurrPageId = $_GET['object'];

					$CurrentParentID = ORM::for_table('pages')->select('parent_id')
																->where_raw('(`enabled` = ? AND `id` = ?)', array(1, $page_id))
																->find_one();

					if ($CurrentParentID) {
						if ($CurrentParentID->parent_id != NULL) {
							if (strpos($CurrentParentID->parent_id, $id) === false) {
								$newid = $CurrentParentID->parent_id . '|' . $id;

								$submenu = ORM::for_table('pages')->find_one($page_id);
								$submenu->parent_id = $newid;
								$submenu->save();
							}
						} else {
							$submenu = ORM::for_table('pages')->find_one($page_id);
							$submenu->parent_id = $id;
							$submenu->save();
						}
					} else {
						$submenu = ORM::for_table('pages')->find_one($page_id);
						$submenu->parent_id = $id;
						$submenu->save();
					}
				}
			}
		}

		static function remove_menu($page_id) {
			$id = MGet::get('menu_id');

			if (filter_var($id, FILTER_VALIDATE_INT)) {
				$menu = MObject::get('menu', $id);

				if ($menu) {
					$menu->remove_page($page_id);
					$menu->update(FALSE);
				}
			} else {
				$MenuArray = explode('_', $id);
				if (count($MenuArray) >= 2) {

					$CurrentParentID = ORM::for_table('pages')->select('parent_id')
																->where_raw('(`enabled` = ? AND `id` = ?)', array(1, $page_id))
																->find_one();

					if ($CurrentParentID) {
						if ($CurrentParentID->parent_id != NULL) {
							$MenuPath = $CurrentParentID->parent_id;
							$MenuPathArray = explode('|', $MenuPath);
							$MenuPathArray = array_filter($MenuPathArray);

							if (in_array($id, $MenuPathArray)) {
								$MenuPathArray = array_diff($MenuPathArray, array($id));
								$MenuPathString = implode('|', $MenuPathArray);

								$submenu = ORM::for_table('pages')->find_one($page_id);
								$submenu->parent_id = $MenuPathString;
								$submenu->save();
							}
						}
					}
				}
			}
		}

		static function data_object($object = NULL) {
			$data = new stdClass();

			$inputs =
			array('title' => 'page_title', 'url' => 'page_url', 'blank' => 'page_on_blank', 'enabled' => 'page_enabled');

			$data->id = 0;
			if ($object && method_exists($object, 'get_id')) {
				$data->id = $object->get_id();
			}

			$data->title = '';
			if (MGet::string($inputs['title'])) {
				$data->title = MGet::string($inputs['title']);
			} elseif ($object && method_exists($object, 'get_title')) {
				$data->title = $object->get_title();
			}

			$data->url = '';
			if (MGet::string($inputs['url'])) {
				$data->url = MGet::string($inputs['url']);
			} elseif ($object && method_exists($object, 'get_url')) {
				$data->url = $object->get_url();
			}

			$data->blank = FALSE;
			if (MGet::int($inputs['blank']) && 1 == MGet::int($inputs['blank'])) {
				$data->blank = TRUE;
			} elseif ($object && method_exists($object, 'page_on_blank') && $object->page_on_blank()) {
				$data->blank = TRUE;
			}

			$data->enabled = FALSE;
			if (MGet::int($inputs['enabled']) && 1 == MGet::int($inputs['enabled'])) {
				$data->enabled = TRUE;
			} elseif ($object && method_exists($object, 'is_enabled') && $object->is_enabled()) {
				$data->enabled = TRUE;
			}

			$data->menus = array();
			if ($object && method_exists($object, 'get_menus')) {
				$data->menus = $object->get_menus();
			}

			$data->created = array();
			if ($object && method_exists($object, 'created')) {
				$data->created = $object->created();
			}

			$data->modified = array();
			if ($object && method_exists($object, 'modified')) {
				$data->modified = $object->modified();
			}

			return $data;
		}

	}

?>