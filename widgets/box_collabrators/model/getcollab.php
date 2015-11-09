<?php
	/**
	 * Created by PhpStorm.
	 * User: Laca
	 * Date: 2015.11.05.
	 * Time: 17:32
	 */

	defined( 'DACCESS' ) or die;

	class getcollab {

		function getcollabadata($id, $Max) {

			$lang = new M_Language;
			$language = $lang->getLanguage();

			$Collaborators = ORM::for_table('content_meta')->select_many('value')->where('name', 'collaborator')->where('external_id', $id)->find_array();

			if ($Collaborators) {
				$CollabDATA = array();

				foreach ($Collaborators as $OneCollab) {
					$SearchEmail = $OneCollab['value'];
					$CollaboratorsID = ORM::for_table('users')->select_many('id')->where('enabled', 1)->where('email', $SearchEmail)->find_one();
					if ($CollaboratorsID) {
						$CollabDATA[] = $CollaboratorsID['id'];
					}
				}

				if (count($CollabDATA) > 0) {
					$CollabString = '`createdby` = ' . implode(' OR `createdby` = ', $CollabDATA);
					$CollaboratorsArticles = ORM::for_table('contents')->select_many('title', 'id', 'text', 'address', 'start', 'end')->where('enabled', 1)->where_raw($CollabString)->limit($Max)->order_by_desc('modified')->find_array();
					return $CollaboratorsArticles;
				} else {
					return FALSE;
				}

			} else {
				return FALSE;
			}
		}
	}