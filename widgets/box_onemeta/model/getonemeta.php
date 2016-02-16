<?PHP
	defined( 'DACCESS' ) or die;

	class getonemeta {

		function getmetadata($id, $name) {

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

			$meta_info = ORM::for_table('content_meta')->select_many('value')->where('name', $name)->where('external_id', $id)->find_one();

			if ($meta_info['value']) {
				return $meta_info['value'];
			} else {
				return FALSE;
			}
		}

	}
?>