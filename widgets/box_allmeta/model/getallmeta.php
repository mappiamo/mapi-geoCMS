<?PHP
	defined( 'DACCESS' ) or die;

	class getallmeta {

		function getmetadata($id) {

			$lang = new M_Language;
			$language = $lang->getLanguage();
			$ContentLang = ORM::for_table('contents')->select_many('language', 'parent')->where('id', $id)->find_one();

			if ($ContentLang['language'] != $language) {
				if ($ContentLang['parent']) {
					$id = $ContentLang['parent'];
				} else {
					$NewID = ORM::for_table('contents')->select_many('id')->where('parent', $id)->find_one();
					if ($NewID['id']) {
						$id = $NewID['id'];
					}
				}
			}

			$meta_info = ORM::for_table('content_meta')->select_many('external_id', 'name', 'value')->where('external_id', $id)->find_array();

			if ($meta_info) {
				if (count($meta_info) > 0) {
					return $meta_info;
				} else {
					return FALSE;
				}
			} else {
				return FALSE;
			}
		}

	}
?>