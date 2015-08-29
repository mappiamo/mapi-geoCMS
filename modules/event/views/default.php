<?php

	// no direct access to this file
	defined('DACCESS') or die;

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title><?PHP echo $data[1]; ?></title>

	<link href="./templates/<?PHP echo $data[2]; ?>/css/<?PHP echo $data[2]; ?>.css" rel="stylesheet">
	<link rel="stylesheet" href="./assets/css/bootstrap/bootstrap.min.css"/>
	<link rel="stylesheet" href="./assets/css/bootstrap/bootstrap-theme.min.css"/>
	<link href="./modules/event/views/events.css" rel="stylesheet" type="text/css" media="screen">
	<script src="./assets/js/jquery/jquery-1.8.0.js" type="text/javascript"></script>
	<script src="./assets/js/autocomplete/jquery.autocomplete.js" type="text/javascript"></script>
	<link href="./assets/js/autocomplete/jquery.autocomplete.css" rel="stylesheet" type="text/css" media="screen">


	<link href="./templates/<?PHP echo $data[2]; ?>/css/style.css" rel="stylesheet">
	<link href="./templates/<?PHP echo $data[2]; ?>/css/responsive.css" rel="stylesheet">

	<link rel="stylesheet" href="./assets/css/datetimepicker/bootstrap-datetimepicker.min.css"/>
	<script type="text/javascript" src="./assets/js/pikaday/moment.js"></script>
	<script type="text/javascript" src="./assets/js/moment-with-locales.js"></script>
	<script type="text/javascript" src="./assets/js/datetimepicker/bootstrap-datetimepicker.js"></script>
</head>

<body>

<?php

	$_GET = array_filter($_GET);

	$GetArray = $_GET;	$GetArray['sort'] = 'created';	$SortCreated = http_build_query($GetArray);
	$GetArray = $_GET;	$GetArray['sort'] = 'modified';	$SortModified = http_build_query($GetArray);
	$GetArray = $_GET;	$GetArray['sort'] = 'start';	$SortStart = http_build_query($GetArray);
	$GetArray = $_GET;	$GetArray['sort'] = 'end';	$SortEnd = http_build_query($GetArray);
	$GetArray = $_GET;	$GetArray['sort'] = 'title';	$SortTitle = http_build_query($GetArray);
	$GetArray = $_GET;	$GetArray['sort'] = 'address';	$SortAddress = http_build_query($GetArray);

	$GetArray = $_GET;	$GetArray['reverse_order'] = 'yes';	$SortReverse = http_build_query($GetArray);
	$GetArray = $_GET;	$GetArray['reverse_order'] = 'no';	$SortOriginal = http_build_query($GetArray);

	$GetArray = $_GET;	$GetArray['filter'] = 'today';	$FilterToday = http_build_query($GetArray);
	$GetArray = $_GET;	$GetArray['filter'] = 'week';	$FilterWeek = http_build_query($GetArray);
	$GetArray = $_GET;	$GetArray['filter'] = 'month';	$FilterMonth = http_build_query($GetArray);
	$GetArray = $_GET;	$GetArray['filter'] = 'quarter';	$FilterQuarter = http_build_query($GetArray);
	$GetArray = $_GET;	$GetArray['filter'] = 'year';	$FilterYear = http_build_query($GetArray);
	$GetArray = $_GET;	$GetArray['filter'] = 'all';	$FilterAll = http_build_query($GetArray);
	$GetArray = $_GET;	$GetArray['filter'] = 'inprogress';	$GetArray['filterby'] = 'start';
	$FilterByPer = http_build_query($GetArray);

	$GetArray = $_GET;	$GetArray['filterby'] = 'modified';	$FilterByMod = http_build_query($GetArray);
	$GetArray = $_GET;	$GetArray['filterby'] = 'created';	$FilterByCre = http_build_query($GetArray);
	$GetArray = $_GET;	$GetArray['filterby'] = 'start';	$FilterByStart = http_build_query($GetArray);
	$GetArray = $_GET;	$GetArray['filterby'] = 'end';	$FilterByEnd = http_build_query($GetArray);

	$GetArray = $_GET;
	if (isset($GetArray['filter'])) {
		$GetArray['PrevFilt'] = $GetArray['filter'];
		unset($GetArray['filter']);
		$GetArray['filter_start'] = date('Y-m-d', strtotime('-1 Week'));
		$GetArray['filter_end'] = date('Y-m-d', strtotime('+1 Week'));
		$FixDateFilter = http_build_query($GetArray);
	} else {
		if (isset($GetArray['filter_start'])) { unset($GetArray['filter_start']);	}
		if (isset($GetArray['filter_end'])) { unset($GetArray['filter_end']);	}
		if (isset($GetArray['PrevFilt'])) {
			$GetArray['filter'] = $GetArray['PrevFilt'];
		} else {
			$GetArray['filter'] = 'all';
		}
		$ActiveDateFilter = http_build_query($GetArray);
	}

	$GetArray = $_GET;
	if (isset($GetArray['address'])) {
		unset($GetArray['address']);
		$ClearAddressLink = http_build_query($GetArray);
	}

?>

<nav>
	<?php include('./templates/' . $data[2] . '/nav.php'); ?>
</nav>

<div class="container">

<div class="col-md-12">
<div class="row main-title">
	<div class="col-xs-12">
		<h1 class="content-title"><span itemprop="name"><?PHP echo $data[1]; ?></span></h1>


		<?PHP if (isset($_GET['user_filter'])) { ?>
			<?PHP if (strtolower($_GET['user_filter']) == 'yes') { ?>
				<div class="col-md-12">
					<div class="filterbox">

						<!-- <a href="#" class="title">Content sort and filters</a> -->

						<div class="sort_and_filters">
							<div class="rows_on_filterbox filter">
								<!-- <span class="func_label">Date:</span> -->
								<?PHP if (isset($_GET['filter'])) { ?>
									<a href="?<?PHP echo $FilterToday; ?>" class="<?PHP if ($_GET['filter'] == 'today') {
										echo 'selected'; } else { echo 'deselected'; } ?>"><img src="./modules/event/Images/1day.png"></a>

									<a href="?<?PHP echo $FilterWeek; ?>" class="<?PHP if ($_GET['filter'] == 'week') {
										echo 'selected';  } else { echo 'deselected'; } ?>"><img src="./modules/event/Images/1week.png"></a>

									<a href="?<?PHP echo $FilterMonth; ?>" class="<?PHP if ($_GET['filter'] == 'month') {
										echo 'selected'; } else { echo 'deselected'; } ?>"><img src="./modules/event/Images/1month.png"></a>

									<a href="?<?PHP echo $FilterQuarter; ?>" class="<?PHP if ($_GET['filter'] == 'quarter') {
										echo 'selected'; } else { echo 'deselected'; } ?>"><img src="./modules/event/Images/1quarter.png"></a>

									<a href="?<?PHP echo $FilterYear; ?>" class="<?PHP if ($_GET['filter'] == 'year') {
										echo 'selected'; } else { echo 'deselected'; } ?>"><img src="./modules/event/Images/1year.png"></a>

									<!-- <a href="?<?PHP echo $FilterAll; ?>" class="<?PHP if ($_GET['filter'] == 'all') {
										echo 'selected'; } else { echo 'deselected'; } ?>">all</a>

									<a href="?<?PHP echo $FilterByPer; ?>" class="<?PHP if ($_GET['filter'] == 'inprogress') {
										echo 'selected'; } else {	echo 'deselected'; } ?>">in progress</a> -->

									<a href="?<?PHP echo $FixDateFilter; ?>"><img src="./modules/event/Images/customdate.png"></a>
								<?PHP } else { ?>
									<form method="get" action="index.php?" id="FixDateFilter">
										<?PHP foreach ($_GET as $GetKey => $GetVal) { ?>
											<input type="hidden" name="<?PHP echo $GetKey; ?>" value="<?PHP echo $GetVal; ?>">
										<?PHP } ?>

										<input type="text" required name="filter_start" id="fix_start"
													 value="<?PHP echo $_GET['filter_start'] ?>"> -
										<input type="text" required name="filter_end" id="fix_end"
													 value="<?PHP echo $_GET['filter_end'] ?>">
										<input type="submit" value="Go!">
										<a href="?<?PHP echo $ActiveDateFilter; ?>"><img class="switch" src="./modules/event/Images/activedate.png"></a>
									</form>
								<?PHP } ?>
							</div>

							<div class="rows_on_filterbox filter">
								<form method="get" action="index.php?" id="AddressFilter">
									<?PHP foreach ($_GET as $GetKey => $GetVal) { ?>
										<input type="hidden" name="<?PHP echo $GetKey; ?>" value="<?PHP echo $GetVal; ?>">
									<?PHP } ?>
									<!-- <span class="func_label">Address:</span> -->
									<input type="text" name="address" id="address_filter"
												 value="<?PHP if (isset($_GET['address'])) { echo $_GET['address']; } ?>" placeholder="Address, City">
												 <input type="submit" value="Go!">

									<?PHP
										/* if (isset($_GET['address'])) {
											echo '<a href="?'.$ClearAddressLink.'"><img src="./modules/event/Images/loc_clear.png"></a>';
										} */
									?>

								</form>
							</div>

							<div class="rows_on_filterbox sort">

								<?PHP
									if (isset($_GET['reverse_order'])) {
										if ($_GET['reverse_order'] == 'yes') {
											$AddDirection = '_asc';
											$RevLink = '&reverse_order=no';
										} else {
											$AddDirection = '_desc';
											$RevLink = '&reverse_order=yes';
										}
									} else {
										$AddDirection = '_desc';
										$RevLink = '&reverse_order=yes';
									}
								?>

								<a href=<?PHP echo '"?' . $SortModified . $RevLink; ?>" class="<?PHP if ($_GET['sort'] == 'modified') {
									echo 'selected">';
									echo '<img src="./modules/event/Images/sort_modi' . $AddDirection . '.png"></a>';
								} else {
									echo 'deselected">';
									echo '<img src="./modules/event/Images/sort_modi.png"></a>';
								} ?>


								<a href=<?PHP echo '"?' . $SortTitle . $RevLink; ?>" class="<?PHP if ($_GET['sort'] == 'title') {
									echo 'selected">';
									echo '<img src="./modules/event/Images/sort_title' . $AddDirection . '.png"></a>';
								} else {
									echo 'deselected">';
									echo '<img src="./modules/event/Images/sort_title.png"></a>';
								} ?>


								<a href=<?PHP echo '"?' . $SortStart . $RevLink; ?>" class="<?PHP if ($_GET['sort'] == 'start') {
									echo 'selected">';
									echo '<img src="./modules/event/Images/sort_start' . $AddDirection . '.png"></a>';
								} else {
									echo 'deselected">';
									echo '<img src="./modules/event/Images/sort_start.png"></a>';
								} ?>


								<a href=<?PHP echo '"?' . $SortEnd . $RevLink; ?>" class="<?PHP if ($_GET['sort'] == 'end') {
									echo 'selected">';
									echo '<img src="./modules/event/Images/sort_end' . $AddDirection . '.png"></a>';
								} else {
									echo 'deselected">';
									echo '<img src="./modules/event/Images/sort_end.png"></a>';
								} ?>


								<a href=<?PHP echo '"?' . $SortAddress . $RevLink; ?>" class="<?PHP if ($_GET['sort'] == 'address') {
									echo 'selected">';
									echo '<img src="./modules/event/Images/sort_loc' . $AddDirection . '.png"></a>';
								} else {
									echo 'deselected">';
									echo '<img src="./modules/event/Images/sort_loc.png"></a>';
								} ?>


								<!-- Order:
								<?PHP if (isset($_GET['reverse_order'])) {
									if ($_GET['reverse_order'] == 'yes') { ?>
										<a href="?<?PHP echo $SortOriginal; ?>" class="deselected"><img src="./modules/event/Images/sort_asc.png"></a>
								<?PHP } else { ?>
										<a href="?<?PHP echo $SortReverse; ?>" class="deselected"><img src="./modules/event/Images/sort_desc.png"></a>
								<?PHP } ?>

								<?PHP } else { ?>
									<a href="?<?PHP echo $SortReverse; ?>" class="deselected"><img src="./modules/event/Images/sort_desc.png"></a>
								<?PHP } ?> -->
							</div>



							<!-- <div class="rows_on_filterbox">
								Filter by date:
								<?PHP if (isset($_GET['filter'])) { ?>
									<?PHP if ($_GET['filter'] == 'inprogress') { ?>
										Events progress today: <?PHP echo date("Y-m-d"); ?>
									<?PHP } elseif ($_GET['filter'] == 'all') { ?>
										All events listed, no date filter available.
									<?PHP } else { ?>
										<a href="?<?PHP echo $FilterByCre; ?>" class="<?PHP if ($_GET['filterby'] == 'created') {
											echo 'selected';
										} else {
											echo 'deselected';
										} ?>">created</a>
										<a href="?<?PHP echo $FilterByMod; ?>" class="<?PHP if ($_GET['filterby'] == 'modified') {
											echo 'selected';
										} else {
											echo 'deselected';
										} ?>">modified</a>
										<a href="?<?PHP echo $FilterByStart; ?>" class="<?PHP if ($_GET['filterby'] == 'start') {
											echo 'selected';
										} else {
											echo 'deselected';
										} ?>">start</a>
										<a href="?<?PHP echo $FilterByEnd; ?>" class="<?PHP if ($_GET['filterby'] == 'end') {
											echo 'selected';
										} else {
											echo 'deselected';
										} ?>">end</a>
									<?PHP } ?>
								<?PHP } else { ?>
									<a href="?<?PHP echo $FilterByCre; ?>" class="<?PHP if ($_GET['filterby'] == 'created') {
										echo 'selected';
									} else {
										echo 'deselected';
									} ?>">created</a>
									<a href="?<?PHP echo $FilterByMod; ?>" class="<?PHP if ($_GET['filterby'] == 'modified') {
										echo 'selected';
									} else {
										echo 'deselected';
									} ?>">modified</a>
									<a href="?<?PHP echo $FilterByStart; ?>" class="<?PHP if ($_GET['filterby'] == 'start') {
										echo 'selected';
									} else {
										echo 'deselected';
									} ?>">start</a>
									<a href="?<?PHP echo $FilterByEnd; ?>" class="<?PHP if ($_GET['filterby'] == 'end') {
										echo 'selected';
									} else {
										echo 'deselected';
									} ?>">end</a>
								<?PHP } ?>
							</div> -->

						</div>
					</div>

					<script type="text/javascript">

						$(document).ready(function () {

							/* $('.sort_and_filters').hide();
							$('.title').click(function () {
								$(this).next().slideToggle();
								return false;
							}); */

							$("#address_filter").autocomplete("./modules/event/ajax/GetAddressList.php", {
								width: 300,
								matchContains: true,
								mustMatch: true,
								//minChars: 0,
								//multiple: true,
								//highlight: false,
								//multipleSeparator: ",",
								selectFirst: false
							});

							var enddate = $('#fix_end').val();
							var startdate = $('#fix_start').val();

							$('#fix_start').datetimepicker({
								format: 'YYYY-MM-DD',
								locale: 'en',
								dayViewHeaderFormat: 'YYYY MMMM',
								minDate: '1990',
								calendarWeeks: true,
								showTodayButton: true,
								showClear: true,
								showClose: true
							});

							$('#fix_end').datetimepicker({
								format: 'YYYY-MM-DD',
								locale: 'en',
								dayViewHeaderFormat: 'YYYY MMMM',
								minDate: '1990',
								calendarWeeks: true,
								showTodayButton: true,
								showClear: true,
								showClose: true
							});

							$('#fix_end').data("DateTimePicker").minDate(startdate);
							$('#fix_start').data("DateTimePicker").maxDate(enddate);

							$("#fix_start").on("dp.change", function (e) {
								$('#fix_end').data("DateTimePicker").minDate(e.date);
							});

							$("#fix_end").on("dp.change", function (e) {
								$('#fix_start').data("DateTimePicker").maxDate(e.date);
							});

						});

					</script>

				</div>
			<?PHP } ?>
		<?PHP } ?>

		<h4>Found <?PHP echo count($data[0]); ?> events:</h4>
	</div>
</div>

<?php

	if (sizeof($data) > 0) {
		foreach ($data[0] as $content) {
			$text_wrap = wordwrap(strip_tags($content['text']), 800, "%|%");
			$text_array = explode('%|%', $text_wrap);
			?>

			<div class="row main-header">
				<div class="row content-title">
					<div class="col-md-12">
						<h3><a href="index.php?module=content&object=<?php echo intval($content['id']); ?>"
									 title="<?php echo $content['title']; ?>"><?php echo $content['title']; ?></a></h3>

						<h5>
							<strong>
								<!-- Created: <?php echo $content['created']; ?>
														Modified: <?php echo $content['modified']; ?> -->

								<span class="glyphicon glyphicon-circle-arrow-right"></span>
								<?php echo date("d-m-Y H:m", strtotime($content['start'])); ?>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-circle-arrow-left"></span>
								<?php echo date("d-m-Y H:m", strtotime($content['end'])); ?>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Location: <?php echo trim($content['address']); ?>
							</strong>
						</h5>
					</div>
				</div>
				<div class="row content-text">
					<div class="col-md-12">
						<p><?php echo $text_array[0]; ?> ... </p>
					</div>
				</div>
				<hr>
				<!-- <div class="row content-text">
												<div class="col-md-12">
													<a href="index.php?module=content&object=<?php echo intval($content['id']); ?>"><?php __('Leggi tutto'); ?>&nbsp;&gt;</a>
												</div>
											</div> -->
			</div>
		<?PHP
		}
	} else {
		?>
		<div class="row main-header">
			<div class="row content-title">
				<div class="col-md-12">
					<h3><?php __('Contenuto in lingua non trovato'); ?></h3>
				</div>
			</div>
		</div>
	<?php
	}
?>

</div>
</div>

</body>
</html>