<?php

	defined('DACCESS') or die;

	function mwidget_flickr() {

		?>

		<script>
			var pathname = "widgets/flickr/ajax/";
			var photo_markers = new L.LayerGroup();

			function StartFlickr() {
				$.ajax({
					type: 'POST',
					url: pathname + 'ReadFlickrdata.php',
					data: {
						ident: "flickr"
					},

					success: function (data) {

						var flinfo = data;
						flinfo = $.parseJSON(flinfo);
						if (flinfo != undefined) {
							for (i = 0; i < flinfo.length; i++) {
								if (flinfo[i].name == "flickr_apikey") {
									fl_apikey = flinfo[i].value;
								}
								else if (flinfo[i].name == "flickr_bbox") {
									fl_bbox = flinfo[i].value;
								}
								else if (flinfo[i].name == "flickr_numofpics") {
									fl_num = flinfo[i].value;
								}
							}
							//Get the Flickr picture with Flickr API
							if (flinfo.length == 3) {
								$.getJSON('https://api.flickr.com/services/rest/?jsoncallback=?', {
									method: 'flickr.photos.search',
									api_key: fl_apikey,
									//user_id: fl_user,
									bbox: fl_bbox,
									per_page: fl_num,
									extras: 'description, license, date_upload, date_taken, owner_name, icon_server, original_format, last_update, geo, tags, machine_tags, o_dims, views, media, path_alias, url_sq, url_t, url_s, url_q, url_m, url_n, url_z, url_c, url_l, url_o',
									format: 'json'
								}, displayflickr);
							}
						}
					}
				});
			}

			// Display the flickr photos
			function displayflickr(resp) {
				if (resp.photos && resp.photos.photo) {
					$.each(resp.photos.photo, function (k, photo) {
						// Create a photo marker
						var photo_marker = L.photoMarker([photo.latitude, photo.longitude], {
							src: photo.url_t,
							size: [photo.width_t, photo.height_t] });
						
						var poptext = '<div align="center"><b>' +
						photo.title +
						'</b><br/><a href="' +
						photo.url_c +
						'" data-lightbox="roadtrip"><img src="' +
						photo.url_m +
						'" alt="' +
						photo.title +
						'" width="240px"/></a><br/>Visit on <a id="' +
						photo.id + '" title="' +
						photo.title +
						'" href="http://www.flickr.com/photos/' +
						photo.owner + '/' + photo.id +
						'/" target="_new">Flickr</a> | Views: ' +
						photo.views + '<br/><br/>' +
						'&copy;&nbsp;<a href="http://www.flickr.com/people/' +
						photo.owner + '/" target="_new">' +
						photo.ownername +
						'</a><br/></div>';

						photo_marker.bindPopup(poptext);
						var image = L.DomUtil.create('img');
						image.onload = function () {
							photo_marker.addTo(photo_markers);
						};
						image.src = photo.url_t;
					});
				}
			}

			$(document).ready(function () {
				$('#Submenu').delegate('div.sub_item', 'click', function () {
					var submenu = $(this).attr("id");
					if (submenu == 'foto') {
						//console.log(photo_markers);
						if (map.hasLayer(photo_markers)) {
							map.removeLayer(photo_markers);
							map.removeLayer(photo_markers);
						} else {
							StartFlickr();
							map.addLayer(photo_markers);
						}
					}
				});
			});

			//alert('itt már nem');

		</script>


	<?PHP } ?>