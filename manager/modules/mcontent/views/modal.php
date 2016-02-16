<?php

	// no direct access to this file
	defined('DACCESS') or die;

?>

<div class="modal fade" id="meta-wizard" tabindex="-1" role="dialog" aria-labelledby="meta-wizard" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Meta wizard form</h4>
			</div>

			<div class="modal-body">
				<p class="text-info">Fill this form for auto content:</p>

				<br>

				<div id="form_title_modal" class="form_title"></div>
				<div id="form_description_modal" class="form_description"></div>
				<hr>

				<form id="meta_wizard">
				<div id="form_content_modal" class="form_content"></div>
					<input type="hidden" name="ContentID" value="">
					<input type="hidden" name="SchemaType" value="">
				</form>

			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="MetaWizardData();">Save data</button>
			</div>

		</div>
	</div>
</div>

<script>
	function MetaWizardData() {
		//alert('aaaaaaaaa');

		var data = $("#meta_wizard :input[value!='']").serializeArray().reduce(function(obj, item) {
			obj[item.name] = item.value;
			return obj;
		}, {});

		//alert(JSON.stringify(data));

		$.ajax({
			type: 'POST',
			url: 'modules/mcontent/models/meta_wizard.php',
			data: data,
			success: function(data){
				//$("#meta_panel").html('You already have schemantic data on meta table.');
				location.reload();
			}
		});

	}
</script>