<?php
	/**
	 * Created by PhpStorm.
	 * User: Laca
	 * Date: 2016.05.18.
	 * Time: 09:09
	 */

	defined( 'DACCESS' ) or die;

	function mwidget_booking() {

		if ((isset($_GET['module'])) && (isset($_GET['object']))) {
			if ($_GET['module'] == 'content') {

				$id = intval($_GET['object']);
				$meta_data = ORM::for_table('content_meta')->select_many('value')->where('name', 'booking_hotelurl')->where('external_id', $id)->find_one();

				if ($meta_data) {

					$url = $meta_data['value'];
					$parse = parse_url($url);
					$BookingDomain = strtolower($parse['host']);

					$meta_ranking = ORM::for_table('content_meta')->select_many('value')->where('name', 'PropertiesRanking')->where('external_id', $id)->find_one();
					$title = ORM::for_table('contents')->select_many('title', 'lat', 'lng', 'address')->where('id', $id)->find_one();

					if (strpos($BookingDomain, 'booking.com') !== false) {

						$lang = new M_Language;
						$language = $lang->getLanguage();

						?>

						<script>
							$(document).ready(function()	{

								var check_in = $('#check_in').val();
								var check_out = $('#check_out').val();
								var today = Date.now();

								$('#check_in').datetimepicker({
									format: 'YYYY-MM-DD',
									locale: '<?PHP echo $language; ?>',
									dayViewHeaderFormat: 'YYYY MMMM',
									minDate: today,
									defaultDate: today,
									calendarWeeks: true,
									showTodayButton: true,
									showClear: true,
									showClose: true
								});

								$('#check_out').datetimepicker({
									format: 'YYYY-MM-DD',
									locale: '<?PHP echo $language; ?>',
									dayViewHeaderFormat: 'YYYY MMMM',
									minDate: today,
									calendarWeeks: true,
									showTodayButton: true,
									showClear: true,
									showClose: true
								});

								if (check_out) {
									$('#check_out').data("DateTimePicker").minDate(check_out);
								}
								$("#check_in").on("dp.change", function (e) {
									$('#check_out').data("DateTimePicker").minDate(e.date);
								});

								if (check_in) {
									$('#check_in').data("DateTimePicker").minDate(check_in);
								}
								$("#check_out").on("dp.change", function (e) {
									$('#check_in').data("DateTimePicker").maxDate(e.date);
								});

								var BookingLink;
								var CI_date;
								var CO_date;
								var ChildCount;
								var AgeString;

								BookingLink = 'aid=1145912';

								CI_date = $("#check_in").val();
								var initdate = CI_date.split(/-/g);
								var inday = initdate[2];
								var inmonth = initdate[1];
								var inyear = initdate[0];

								BookingLink += '&checkin_monthday=' + inday;
								BookingLink += '&checkin_year_month=' + inyear + '-' + inmonth;

								BookingLink += '&group_adults=1';
								BookingLink += '&no_rooms=1#availability_target';

								$('#final_link').attr("href","<?PHP echo $url; ?>?" + BookingLink);

								$("#bc_wrapper input").on('change dp.change', function (e) {
									BookingLink = 'aid=1145912';
									ChildCount = $("#child").val();
									BookingLink += '&group_children=' + ChildCount;

									if (ChildCount > 0) {
										AgeString = '';
										for (i = 0; i < ChildCount; i++) {
											AgeString += '&age=11';
										}
										BookingLink += AgeString;
									}

									BookingLink += '&group_adults=' + $("#persone").val();

									CI_date = $("#check_in").val();
									CO_date = $("#check_out").val();

									if (CI_date.length == 10) {
										var idate = CI_date.split(/-/g);
										var iday = idate[2];
										var imonth = idate[1];
										var iyear = idate[0];

										BookingLink += '&checkin_monthday=' + iday;
										BookingLink += '&checkin_year_month=' + iyear + '-' + imonth;
									}

									if (CO_date.length == 10) {
										var odate = CO_date.split(/-/g);
										var oday = odate[2];
										var omonth = odate[1];
										var oyear = odate[0];

										BookingLink += '&checkout_monthday=' + oday;
										BookingLink += '&checkout_year_month=' + oyear + '-' + omonth;
									}

									BookingLink += '&no_rooms=1#availability_target';
									$('#final_link').attr("href","<?PHP echo $url; ?>?" + BookingLink);
								});

							});
						</script>

						<?PHP
					}

					//http://www.booking.com/hotel/tr/surmeli-adana.html
					//http://www.booking.com/hotel/it/grand-tiziano-e-dei-congressi.it.html?checkin_monthday=10&checkin_year_month=2016-9&checkout_monthday=12&checkout_year_month=2016-9&cid=12345678#availability_target

					//http://www.booking.com/hotel/tr/surmeli-adana.html?checkin_monthday=10&checkin_year_month=2016-9&checkout_monthday=12&checkout_year_month=2016-9&cid=12345678&no_rooms=1&group_adults=2&group_children=0#availability_target
					//http://www.booking.com/hotel/tr/surmeli-adana.html?cid=12345678&group_children=3&group_adults=3&checkin_monthday=06&checkin_year_month=2016-06&checkout_monthday=16&checkout_year_month=2016-06&no_rooms=1#availability_target

					//die();

					?>

					<div class="bc_wrapper" id="bc_wrapper">
						<div class="bc_title">Hotel booking</div>


							<div class="ranking_stars">
								<?PHP echo $title['title']; if ($meta_ranking && intval($meta_ranking['value']) > 0) { ?>
								<div class="stars">
									<?PHP
										$RankingValue = $meta_ranking['value'];
										for ($i = 1; $i <= $RankingValue; $i++) { ?>
											<img src="./widgets/booking/star.png" style="height: 12px">
									<?PHP } ?>
								</div>
								<?PHP } ?>
							</div>
							<div class="ranking_address">
								<?PHP
									$meta_data_Ci =
									ORM::for_table('content_meta')->select_many('value')->where('name', 'CityName')->where('external_id', $id)
										 ->find_one();

									$meta_data_Co =
									ORM::for_table('content_meta')->select_many('value')->where('name', 'CountryName')->where('external_id', $id)
										 ->find_one();

									if (isset($meta_data_Ci) && isset($meta_data_Co)) {
										echo $meta_data_Ci['value'] . ', ' . $meta_data_Co['value'];
									}
								?>
							</div>


						<div class="booking_inputs">
							<table>
								<tr>
									<td>
										<div class='input-group date'>
											<label>Check in:</label>
											<input type="text" name="check_in" id="check_in">
											<span class="glyphicon glyphicon-calendar"></span>
										</div>
									</td>
									<td>
										<div class='input-group date'>
											<label>Check out:</label>
											<input type="text" name="check_out" id="check_out">
											<span class="glyphicon glyphicon-calendar"></span>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<label>Person (>12 yo):</label>
										<input type="number" name="persone" id="persone" value="1" min="1" max="10" step="1">
									</td>
									<td>
										<label>Children (<12 yo):</label>
										<input type="number" name="child" id="child" value="0" min="0" max="10" step="1">
									</td>
								</tr>
							</table>
						</div>

						<?PHP
							$meta_MinRate =
							ORM::for_table('content_meta')->select_many('value')->where('name', 'minrate')->where('external_id', $id)
								 ->find_one();

							if (isset($meta_MinRate)) {
								$ButtonText = 'Rooms from &#8364;' . $meta_MinRate['value'];
							} else {
								$ButtonText = 'Check free room';
							}
						?>

						<a href="" id="final_link" target="_blank"><input type="submit" value="<?PHP echo $ButtonText; ?>"></a>

					</div>

					<?PHP
						$schema_data['legalName'] = $title['title'] . ' ' . $RankingValue;
						$schema_data['address'] = $title['address'];
						$schema_data['geo']['latitude'] = $title['lat'];
						$schema_data['geo']['longitude'] = $title['lng'];
						//$schema_data['logo'] = $OneData->logo;
						$schema_data['currenciesAccepted'] = 'EUR';
						$schema_data['priceRange'] = $meta_MinRate['value'];
					?>

					<div class="microformat">
						<script type="application/ld+json">

						[<?PHP print_r(json_encode($schema_data)); //print_r(($schema_data)); die(); ?>]

						</script>
					</div>

					<?PHP
				}
			}
		}
	}
?>