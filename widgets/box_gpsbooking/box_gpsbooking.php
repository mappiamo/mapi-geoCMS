<?php

	defined('DACCESS') or die;

	include_once('model/getdata.php');

	function mwidget_box_gpsbooking($CID = 2002, $BOOKING_ID = 345678, $INITALIA_ID = 1459, $Limit = 10) {
		global $coords;

		if (!isset($_GET["object"])) { return; }

		$bookingdata = new gpsbooking();

		if ((MValidate::coord($coords['lat']) && MValidate::coord($coords['lng'])) && (($coords['lat'] != 0) && ($coords['lng'] != 0)) && (isset($_GET['module']) && $_GET['module'] == 'content')) {

			$lat = $coords['lat'];
			$lon = $coords['lng'];
			//$TheGEOMData = 'POINT(' . $lon . ' ' . $lat . ')';

			$bookingresult = $bookingdata->getbookingdata($lat, $lon, $CID);

				if ($bookingresult) { ?>

				<div class="box_container">

					<?PHP
						$id = intval($_GET['object']);

						$meta_data_Ci =
						ORM::for_table('content_meta')->select_many('value')->where('name', 'CityName')->where('external_id', $id)
							 ->find_one();

						if ($meta_data_Ci) {
					?>
							<span class="box_title">Hotels around <?PHP echo $meta_data_Ci['value']; ?></span>
					<?PHP } else { ?>
						<span class="box_title">Hotel reservation</span>
					<?PHP } ?>

					<div class="scrollable">
						<div class="DataTable">

				<?PHP

					$Resnum = 0;
					$schema_data = array();
					$FullURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; //rtrim(((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']), '/\\');
					$schema_data['@context'] = 'http://schema.org';
					$schema_data['@type'] = 'hotel';
					$schema_data['url'] = $FullURL;

					$schema_data['address']['@type'] = 'Place';
					$schema_data['geo']['@type'] = 'GeoCoordinates';

					foreach ($bookingresult as $array_key => $OneData) if (isset($OneData->name)) {
					$Resnum++;
					if ($Resnum > $Limit) { break; }
					?>

					<div class="DataRow">
						<div class="DataCell"><div class="image">
								<?PHP if (isset($OneData->logo)) { ?>
									<img src="<?PHP echo $OneData->logo; ?>">
								<?PHP } elseif (isset($OneData->icon)) { ?>
									<img src="<?PHP echo $OneData->icon; ?>">
								<?PHP } ?>
						</div></div>

						<div class="DataCell"><div class="namerow">

						<?PHP if (isset($OneData->url)) {
							$HotelURL = parse_url($OneData->url);

							if (strpos(strtoupper($HotelURL['host']),'BOOKING') !== false) {
								$OneData->url = $OneData->url . '?aid=' . $BOOKING_ID;
							}

							if (strpos(strtoupper($HotelURL['host']),'INITALIA') !== false) {
								parse_str(parse_url($OneData->url, PHP_URL_QUERY), $result_array);
								$result_array['ida'] = $INITALIA_ID;

								$QuerySTR = NULL;
								foreach ($result_array as $Key => $Value) {
									$QuerySTR .= $Key . '=' . $Value . '&';
								}
								$QuerySTR = rtrim($QuerySTR, '&');
								$OneData->url = $HotelURL['scheme'] . '://' . $HotelURL['host'] . $HotelURL['path'] . '?' . $QuerySTR;
							}

						?>
							<a href="<?PHP echo $OneData->url; ?>" target="_blank" rel="nofollow">
						<?PHP } ?>

						<?PHP if (isset($OneData->name)) { ?>
							<?PHP echo $OneData->name; ?><?PHP }
						?>

						<?PHP if (isset($OneData->url)) { ?>
							</a>
						<?PHP } ?>

						<?PHP if (isset($OneData->rating)) { $ratstars = NULL; ?>
								<span class="rating">
									<?PHP for ($i = 1; $i <= $OneData->rating; $i++) { $ratstars .= '*'; ?>*<?PHP } ?>
								</span>
						<?PHP } ?>

						<?PHP if (isset($OneData->price)) {
							if (strtoupper($OneData->currency) == 'EUR') {
								echo '&euro;'.$OneData->price;
							} else {
								echo $OneData->currency.' '.$OneData->price;
							}
						} ?>

						</div>
						<div class="addressrow">

						<?PHP
							if (isset($OneData->Distance)) {
								if (intval($OneData->Distance) < 1000) {
									echo intval($OneData->Distance).' m -> ';
								} else {
									echo intval($OneData->Distance / 1000).' km -> ';
								}
							}
						?>

						<?PHP if (isset($OneData->address)) { ?>
							<?PHP echo $OneData->address; ?><?PHP }
						?>

						<?PHP if (isset($OneData->city)) { ?>
							<?PHP echo $OneData->city; ?><?PHP }
						?>

						<?PHP if (isset($OneData->country)) { ?>
							(<?PHP echo $OneData->country; ?>)<?PHP }
						?>
						</div>
						</div>
					</div>

					<?PHP
						$schema_data['legalName'] = $OneData->name . ' ' . $ratstars;
						$schema_data['address'] = $OneData->address . ' ' . $OneData->city . ' ' . $OneData->country;
						$schema_data['geo']['latitude'] = $OneData->lat;
						$schema_data['geo']['longitude'] = $OneData->lng;
						$schema_data['logo'] = $OneData->logo;
						$schema_data['currenciesAccepted'] = $OneData->currency;
						$schema_data['priceRange'] = $OneData->price;
					?>

					<div class="microformat">
						<script type="application/ld+json">

						[<?PHP print_r(json_encode($schema_data)); //print_r(($schema_data)); die(); ?>]

						</script>
					</div>

				<?PHP } ?>

				</div></div></div>

			<?PHP
			}
		}

	}
