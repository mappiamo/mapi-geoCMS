<?php

	// no direct access to this file
	defined('DACCESS') or die;

	function mwidget_events($cat_id = NULL) {
		$events = array();

		$lang = new M_Language;
		$language = $lang->getLanguage();

		$DateFilter = "`end` >= now()";
		if ($cat_id) {

		} else {
			$events = ORM::for_table('contents')->select_many('id', 'title', 'start', 'end', 'address')->where('language', $language)->where('enabled', 1)->where_null('parent')->where('type', 'event')->where_raw($DateFilter)->order_by_asc('end')->limit(3)->find_array();
		}

		/* if ($cat_id) {
			$category = MObject::get('category', $cat_id);

			if ($category) {
				$contents = $category->get_contents();

				if (sizeof($contents) > 0) {
					foreach ($contents as $content) {
						if ($content->get_start()) {
							$now = new DateTime('now');
							$content_start = new DateTime($content->get_start());

							if ($content_start > $now) {
								$events[$content->get_start()] =
								array($content->get_id(), $content->get_title(), $content->get_address());
							}
						}
					}
				}
			}
		} */

		if (count($events) > 0) {
			?>
			<div class="col-md-4">
				<div class="tabs-block">
					<div class="tabs-block-head">
						<span class="glyphicon glyphicon-time"></span> <span class="title">Eventi in zona</span>
					</div>
					<div class="tabs-block-body">
						<?php
							/* ksort($events);

							$i = 1;
							foreach ($events as $key => $value) {
								$year = substr($key, 0, 4);
								$month = substr($key, 5, 2);
								$day = substr($key, 8, 2);

								if ('0' == substr($day, 0, 1)) {
									$day = substr($day, 1, 1);
								}

								switch ($month) {
									case '01':
										$month = 'Gennaio';
										break;
									case '02':
										$month = 'Febbraio';
										break;
									case '03':
										$month = 'Marzo';
										break;
									case '04':
										$month = 'Aprile';
										break;
									case '05':
										$month = 'Maggio';
										break;
									case '06':
										$month = 'Giugno';
										break;
									case '07':
										$month = 'Luglio';
										break;
									case '08':
										$month = 'Agosto';
										break;
									case '09':
										$month = 'Settembre';
										break;
									case '10':
										$month = 'Ottobre';
										break;
									case '11':
										$month = 'Novembre';
										break;
									case '12':
										$month = 'Dicembre';
										break;
								} */

							foreach ($events as $key => $value) { ?>

								<a href="index.php?module=content&object=<?php echo intval($value['id']); ?>"
									 title="<?php echo strip_tags($value['title']); ?>">
									<div>
										<span class="date"><?php echo date('d-m-Y', strtotime($value['end'])); ?></span> - <span class="address"><?php echo strip_tags($value['address']); ?></span><br>
										<span class="title"><?php echo strip_tags($value['title']); ?></span>
									</div>
								</a>

								<?php
							}
						?>
					</div>
				</div>
			</div>
			<?php
		}

	}

?>