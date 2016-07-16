<?php

	defined('DACCESS') or die;

	function DisableForm() { ?>

		<div id="mapi_mail_form">
			<div class="c_title">Contact info</div>Your message sent to the address. Plase wait for the answer.
		</div>

		<?PHP
	}

	function mwidget_form_contact($username) {

		if ($username) {

			if (isset($_SERVER['REMOTE_ADDR'])) {
				$ClientIP = $_SERVER['REMOTE_ADDR'];
				$validIP = filter_var($ClientIP, FILTER_VALIDATE_IP);
				if ($validIP !== false) {

					if (file_exists('widgets/form_contact/ip_list')) {
						$Addresses = file('widgets/form_contact/ip_list', FILE_IGNORE_NEW_LINES);
						if (in_array($ClientIP, $Addresses)) {
							DisableForm();
							return;
						}
					}

				} else {
					DisableForm();
					return;
				}
			} else {
				DisableForm();
				return;
			}

			if ($username == 'META') {
				$id = intval($_GET['object']);
				$meta_address = ORM::for_table('content_meta')->select_many('value')->where('name', 'Email')->where('external_id', $id)
					 ->find_one();

				$title = ORM::for_table('contents')->select_many('title', 'address')->where('id', $id)->find_one();

				if ($meta_address) {
					$sender_email = $meta_address['value'];
					$sender_email = filter_var($sender_email, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH);
					if (filter_var($sender_email, FILTER_VALIDATE_EMAIL)) {
						$username = $sender_email;
					} else {
						return;
					}
				} else {
					return;
				}

			}

			?>

			<div id="mapi_mail_form">
				<div class="c_title">Contact info</div>

				<?PHP if ($title) { ?>

					<div class="contact_title">
						<?PHP echo $title['title'] ?>
					</div>

					<div class="contact_address">
						<?PHP echo $title['address'] ?>
					</div>

				<?PHP } ?>

				<?PHP
					$MetaSearch = array('telefono', 'localita', 'servizio', 'orario', 'chiusura_settimanale', 'biglietteria_costo', 'prenotazioni_tipo');
					$MetaFilterQuery = 'external_id = ' . $id . ' AND (content_meta.name LIKE \'' . implode('\' OR content_meta.name LIKE \'', $MetaSearch) . '\')';

					$meta_data = ORM::for_table('content_meta')->select_many('value', 'name')->where_raw($MetaFilterQuery)->order_by_asc('name')->find_array();

					if (isset($meta_data) && count($meta_data) > 0) { ?>
						<div class="contact_address">

							<?PHP
								$TheValue = NULL;
								$TheValue_collection = NULL;
								foreach ($meta_data as $MKey => $OneMeta) {
									$regex = '/((?<=[a-z])[A-Z]|[A-Z](?=[a-z]))/';
									$OneMeta['name'] = preg_replace($regex, ' $1', ucfirst($OneMeta['name']));
									$TheName = str_replace('_', ' ', $OneMeta['name']);
									//echo '<strong>' . $TheName . ':</strong> ' . $OneMeta['value'] . '<br>';
									if (isset($meta_data[($MKey + 1)])) {
										$NextName = $meta_data[($MKey + 1)]['name'];
										$NextName = preg_replace($regex, ' $1', ucfirst($NextName));
										$NextName = str_replace('_', ' ', $NextName);
										if ($NextName == $TheName) {
											$TheValue_collection .= $OneMeta['value'] . ', ';
										} else {
											if ($TheValue_collection) {
												$TheValue = $TheValue_collection . $OneMeta['value'];
											} else {
												$TheValue = $OneMeta['value'];
											}
											echo '<strong>' . $TheName . ':</strong> ' . $TheValue . '<br>';
											$TheValue_collection = NULL;
										}
									} else {
										$TheValue = $OneMeta['value'];
										echo '<strong>' . $TheName . ':</strong> ' . $TheValue . '<br>';
										$TheValue_collection = NULL;
									}
								}
							?>

						</div>
					<?PHP }
				?>

				<div class="row">
					<div class="col-lg-6">
						<input type="text" placeholder="Name" id="form_name" name="name">
					</div>
					<div class="col-lg-6">
						<input type="text" placeholder="E-mail" id="form_email" name="email">
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12">
						<textarea name="message" id="form_message" placeholder="Message"></textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12">
						<input type="submit" value="Submit" id="formmail_submit">
					</div>
				</div>
			</div>

			<script>

				$(document).ready(function() {

					$("#formmail_submit").click(function() {

						$.ajaxSetup({async: false});

						if (!$('#form_name').val()) {
							alert('Name field required');
							return null;
						}

						if (!$('#form_email').val()) {
							alert('E-mail field required');
							return null;
						}

						if (!$('#form_message').val()) {
							alert('Message field required');
							return null;
						}

						var pathname = 'widgets/form_contact/ajax/';
						var form_name = $('#form_name').val();
						var form_email = $('#form_email').val();
						var form_message = $('#form_message').val();

						$('#mapi_mail_form').html('<div class="c_title">Contact info</div>Sending your mail to the recipient, please wait...');

						$.ajax({
							type: 'POST',
							url: pathname + 'MailSend.php',
							data: {
								recipient: '<?PHP echo $username; ?>',
								name: form_name,
								email: form_email,
								message: form_message,
								sentfrom: '<?PHP echo ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>'
							},
							success: function (data) {
								if (data == 'sent') {
									$('#mapi_mail_form').html('<div class="c_title">Contact info</div>Your message sent to the address. Plase wait for the answer.');
								} else {
									alert(data);
								}
							}, error: function(request, status, error){
								alert('Ajax problem: ' + request.responseText + ' ' + status + ' ' + error);
							}

						});
					});
				});

			</script>

		<?PHP
		}
	}