<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Setup mappiamo</title>
	<link href="../assets/css/bootstrap/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="setupform.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="../assets/js/jquery/jquery-1.10.2.min.js"></script>
</head>

<body>

<img src="../templates/mappiamo/images/logo.png">

<h1>#mappiamo setup form:</h1><hr><p></p>

	<form class="form-horizontal" id="setup_form" name="setup_form" enctype="multipart/form-data" action="setup.php" method="post">

		<div class="color1">
			<div class="form-group">
				<label for="sitename" class="control-label col-sm-2">Site name: *</label>
				<div class="col-sm-6">
					<input name="sitename" type="text" required id="sitename" placeholder="Your site" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label for="reg_email" class="control-label col-sm-2">Owner's e-mai address: *</label>
				<div class="col-sm-6">
					<input name="reg_email" type="text" required id="reg_email" placeholder="Your e-mail" class="form-control">
				</div>
			</div>
		</div>

		<div class="color2">
			<div class="form-group">
				<label for="db_user" class="control-label col-sm-2">Database user name: *</label>
				<div class="col-sm-6">
					<input name="db_user" type="text" required id="db_user" class="form-control" placeholder="Mysql user name">
				</div>
			</div>
			<div class="form-group">
				<label for="db_pass" class="control-label col-sm-2">Database user password: *</label>
				<div class="col-sm-6">
					<input name="db_pass" type="password" required id="db_pass" class="form-control" placeholder="Mysql password">
				</div>
			</div>
			<div class="form-group">
				<label for="db" class="control-label col-sm-2">Database name: *</label>
				<div class="col-sm-6">
					<input name="db" type="text" required id="db" class="form-control" placeholder="Mysql database name">
				</div>
			</div>
			<div class="form-group">
				<label for="db_host" class="control-label col-sm-2">Database host: *</label>
				<div class="col-sm-6">
					<input name="db_host" type="text" required id="db_host" value="localhost" placeholder="Mysql host name" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label for="db_prefix" class="control-label col-sm-2">Database prefix:</label>
				<div class="col-sm-6">
					<input type="text" name="db_prefix" id="db_prefix" class="form-control">
				</div>
			</div>
		</div>

		<div class="color3">
			<div class="form-group">
				<label for="reg_email_user" class="control-label col-sm-2">SMTP user name: *</label>
				<div class="col-sm-6">
					<input name="reg_email_user" type="text" required id="reg_email_user" placeholder="SMTP user" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label for="reg_email_pass" class="control-label col-sm-2">SMTP password: *</label>
				<div class="col-sm-6">
					<input name="reg_email_pass" type="password" required id="reg_email_pass" placeholder="SMTP password" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label for="reg_email_host" class="control-label col-sm-2">SMTP host: *</label>
				<div class="col-sm-6">
					<input name="reg_email_host" type="text" required id="reg_email_host" placeholder="SMTP host" class="form-control">
				</div>
			</div>

			<div class="form-group">
				<label for="reg_email_host" class="control-label col-sm-2"></label>
				<div class="col-sm-6">
					<span id="FinalError"></span>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" id="submit" value="Do setup" class="btn btn-default">
					<input type="reset" name="reset" id="reset" value="Reset" class="btn btn-default">
				</div>
			</div>
		</div>

	</form>

	<script>
		$(document).ready(function() {

			$('#setup_form').bind("keyup keypress", function(e) {
				var code = e.keyCode || e.which;
				if (code  == 13) {
					e.preventDefault();
					return false;
				}
			});

			$("#setup_form span#FinalError").hide();

			$("#setup_form input").keyup(function (e) {
				$("#setup_form span#FinalError").html('');
				$("#setup_form span#FinalError").hide();
			});

			var Errors = 1;

			function CheckSetup() {
				var pathname = 'ajax/';

				var sitename = $('#setup_form #sitename').val();
				var reg_email = $('#setup_form #reg_email').val();
				var db_user = $('#setup_form #db_user').val();
				var db_pass = $('#setup_form #db_pass').val();
				var db = $('#setup_form #db').val();
				var db_host = $('#setup_form #db_host').val();
				var reg_email_host = $('#setup_form #reg_email_host').val();

				$.ajax({
					type: 'POST',
					url: pathname + 'setupcheck.php',
					data: {
						sitename: sitename,
						reg_email: reg_email,
						db_user: db_user,
						db_pass: db_pass,
						db: db,
						db_host: db_host,
						reg_email_host: reg_email_host
					},
					success: function (data) {
						if (data == 'PASSED') {
							Errors = 0;
						} else {
							Errors = data;
						}
					}, error: function(request, status, error){
						alert('Ajax problem: ' + request.responseText + ' ' + status + ' ' + error);
					}

				});
			}

			$("#setup_form").submit(function(event) {

				$.ajaxSetup({async: false});

				CheckSetup();

				if (Errors == 0) {
					$("#setup_form #submit").submit();
					return;
				} else {
					$("#setup_form span#FinalError").html(Errors);
					$("#setup_form span#FinalError").show();
					return false;
				}
				return false;
			});

			$('form').on('reset', function(e) {
				$("#setup_form span#FinalError").html('');
				$("#setup_form span#FinalError").hide();
			});

		});
	</script>

</body>
</html>
