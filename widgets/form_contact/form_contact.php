<?php

	defined('DACCESS') or die;

	function mwidget_form_contact($username) {

		if ($username) {

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

						$.ajax({
							type: 'POST',
							url: pathname + 'MailSend.php',
							data: {
								recipient: '<?PHP echo $username; ?>',
								name: form_name,
								email: form_email,
								message: form_message
							},
							success: function (data) {
								if (data == 'sent') {
									$('#mapi_mail_form').html('Your message successfully sent, thank you.');
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