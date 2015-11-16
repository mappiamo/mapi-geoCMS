<?php
/**
 * Created by PhpStorm.
 * User: Laca
 * Date: 2015.07.15.
 * Time: 18:29
 */

	defined('DACCESS') or die;

	function mwidget_routes() {

		$lang = new M_Language;
		$language = $lang->getLanguage();

		?>

		<script>

			$(document).ready(function() {

				var mainmenu = null;
				var PrevClicked = '';
				var routename = null;
				var DistanceString = null;
				var TitleString = null;
				var AddressString = null;
				var GAddressString = null;
				var GTitleString = null;
				var Gdefimage = null;
				var EventString = null;
				var SmallContent = null;
				var GSmallContent = null;
				var CoordsString = null;
				var SubMenuString = null;
				var CategoryString = null;
				var SubCategoryString = null;
				var CategoryID = null;
				var SubCategoryID = null;
				var DefaultImage = null;
				var ContentLink = null;
				var CategoryLink = null;
				var SubCategoryLink = null;
				var GContentLink = null;
				var MarkersAdded = 0;
				var GeomsAdded = 0;
				var FilterType = null;
				var ContentType = 'place';
				var CategoryChoosed = 0;
				var SearchRequest = null;
				var SearchString = null;

				var pathname = 'widgets/routes/ajax/'
				var routecolor = "#ff00fb";
				var CatMenuON = [];
				var CatMenuFUNCTIONAL = [];

				var Marker_layer = new L.geoJson().addTo(map);
				var Area_Layer = new L.geoJson().addTo(map);
				var Route_Layer = new L.geoJson().addTo(map);

				$(".mainmenu").add(".accordion_main").click(function() {
					mainmenu = $(this).attr("id");
					$("html, body").animate({ scrollTop: 0 }, "slow");

					if (mainmenu == 'Punti' || mainmenu == 'Informazioni' || mainmenu == 'Eventi' || mainmenu == 'Aziende' || mainmenu == 'Itinerari' || mainmenu == 'Epoca' || mainmenu == 'Informazioni' || mainmenu == 'Comuni') {
						var element = $("#Submenu").add("#Accordion").find("div.sub_item");

						$.each (element, function(index, name) {
							var SubContent = $(name).attr("id");
							var index = CatMenuON.indexOf(SubContent);
							if (index != -1) {
								$(name).removeClass("Category_off");
								$(name).addClass("Category_on");
							}
						});
					}
				});

				$('#Submenu').add("#Accordion").delegate('div.sub_item', 'click', function() {
					var submenu = $(this).attr("id");
					SubMenuString = $(this).text();

					if (mainmenu == 'Punti' || mainmenu == 'Aziende' || mainmenu == 'Epoca' || mainmenu == 'Informazioni') { ContentType = 'place'; } else if (mainmenu == 'Eventi') { ContentType = 'event'; }
					if (mainmenu == 'Punti' || mainmenu == 'Eventi' || mainmenu == 'Aziende' || mainmenu == 'Epoca' || mainmenu == 'Informazioni') { CategoryChoosed = 1; }
					if (mainmenu == 'Itinerari' || mainmenu == 'Comuni') { routename = submenu; }

					if ((mainmenu == 'Itinerari') && (submenu != 'remove-route') && (submenu != 'empty-map')) {
						var accordion_element = $("#Accordion #Itinerari").find("div.sub_item");
						$.each (accordion_element, function(index, name) {
							var Irinirary_ID = $(name).attr("id");
							if ((Irinirary_ID != 'remove-route') && (Irinirary_ID != 'empty-map')) {
								if ((Irinirary_ID == routename) && (routename == submenu)) {
									$(name).addClass("Route_on");
								} else {
									$(name).removeClass("Route_on");
								}
							}
						});
					}

					if ($(this).data('content_type')) { ContentType = $(this).data('content_type'); }

					if ((mainmenu == 'Punti' && PrevClicked == 'Eventi') ||
							(PrevClicked == 'Punti' && mainmenu == 'Eventi') ||
							(mainmenu == 'Aziende' && PrevClicked == 'Eventi') ||
							(PrevClicked == 'Aziende' && mainmenu == 'Eventi') ||
							(mainmenu == 'Punti' && PrevClicked == 'Aziende') ||
							(PrevClicked == 'Punti' && mainmenu == 'Aziende') ||
							(mainmenu == 'Punti' && PrevClicked == 'Epoca') ||
							(PrevClicked == 'Punti' && mainmenu == 'Epoca') ||
							(mainmenu == 'Aziende' && PrevClicked == 'Epoca') ||
							(PrevClicked == 'Aziende' && mainmenu == 'Epoca') ||
							(mainmenu == 'Eventi' && PrevClicked == 'Epoca') ||
							(PrevClicked == 'Eventi' && mainmenu == 'Epoca')) {
								CatMenuON = [];
								CatMenuFUNCTIONAL = [];
					}

					if (submenu == 'empty-map') {
						CatMenuON = [];
						CatMenuFUNCTIONAL = [];
						routename = null;
						FilterType = null;
						CategoryChoosed = 0;
						//mainmenu = null;
						PrevClicked = '';
						MarkersAdded = 0;
						GeomsAdded = 0;

						if (map.hasLayer(Area_Layer)) { Area_Layer.clearLayers(); }
						if (map.hasLayer(Marker_layer)) { Marker_layer.clearLayers(); }
						if (map.hasLayer(Route_Layer)) { Route_Layer.clearLayers(); }
						if (map.hasLayer(weather)) { map.removeLayer(weather); }
						if (map.hasLayer(photo_markers)) { map.removeLayer(photo_markers); }

						$("#Accordion .sub_item").removeClass("Category_on");
						$("#Accordion .sub_item").addClass("Category_off");
						$("#Itinerari .sub_item").removeClass("Route_on");
						return;
					}

					if (mainmenu == 'Punti') {
						$("#Accordion #Epoca .sub_item").removeClass("Category_on");
						$("#Accordion #Epoca .sub_item").addClass("Category_off");
					} else if (mainmenu == 'Epoca') {
						$("#Accordion #Punti .sub_item").removeClass("Category_on");
						$("#Accordion #Punti .sub_item").addClass("Category_off");
					}

					if (mainmenu == 'Eventi' || mainmenu == 'Aziende') {
						$("#Accordion .sub_item").removeClass("Category_on");
						$("#Accordion .sub_item").addClass("Category_off");
					}

					if (mainmenu == 'Punti' || mainmenu == 'Eventi' || mainmenu == 'Aziende' || mainmenu == 'Epoca' || mainmenu == 'Informazioni') {
						if ($(this).hasClass("Category_on")) {
							$(this).removeClass("Category_on");
							$(this).addClass("Category_off");
							var index = CatMenuON.indexOf(submenu);
							if (index != -1) { CatMenuON.splice(index, 1); }
							var index_f = CatMenuFUNCTIONAL.indexOf(submenu);
							if (index_f != -1) { CatMenuFUNCTIONAL.splice(index_f, 1); }
						} else {
							$(this).removeClass("Category_off");
							$(this).addClass("Category_on");
							CatMenuON.push(submenu);

							if (submenu != 'filter_' + mainmenu) {
								CatMenuFUNCTIONAL.push(submenu);
							}
						}
					}

					if (mainmenu == 'Eventi') {
						var IsFilterOn = $("#Submenu").add("#Accordion").find("div.sub_item");
						FilterType = null;

						$.each (IsFilterOn, function(findex, fname) {
							var SubContent = $(fname).attr("id");
							if (SubContent == 'filter_' + mainmenu) {
								if ($(fname).hasClass("Category_on")) {
									FilterType = $(fname).data('filter');
								} else {
									FilterType = null;
								}
							}
						});

					} else {
						FilterType = null;
					}

					if (CatMenuFUNCTIONAL.length == 0) {
						if (map.hasLayer(Marker_layer)) { Marker_layer.clearLayers(); }
						MarkersAdded = 0;
					}

					//alert(CatMenuON);
					//alert(submenu);
					if (submenu == 'remove-route' || submenu == 'remove-area') {
						if (map.hasLayer(Route_Layer)) { Route_Layer.clearLayers(); }
						if (map.hasLayer(Area_Layer)) { Area_Layer.clearLayers(); }
						$("#Itinerari .sub_item").removeClass("Route_on");
						GeomsAdded = 0;
						routename = null;
					}

					if (mainmenu == 'Search') {
						$("#Accordion #Search img").click(function() {
							SearchString = $('#SearchInput').val();
							if (SearchString.length >= 3) {

								CatMenuON = [];
								CatMenuFUNCTIONAL = [];
								routename = null;
								FilterType = null;
								CategoryChoosed = 0;
								//mainmenu = null;
								PrevClicked = '';
								MarkersAdded = 0;
								GeomsAdded = 0;

								ContentType = 'Markers';

								$("#Accordion .sub_item").removeClass("Category_on");
								$("#Accordion .sub_item").addClass("Category_off");

								SearchRequest = SearchString;
								//alert(mainmenu + '-' + submenu + '-' + SearchRequest);
							}
						});

						if (SearchRequest.length < 3) {
							return;
						}
					} else {
						SearchRequest = null;
						SearchString = null;
						$('#SearchInput').val('');
					}

					//alert(mainmenu + '-' + submenu + '-' + SearchRequest);
					//alert('cmf: ' + CatMenuFUNCTIONAL + ' main: ' + mainmenu + ' sub: ' + submenu + ' rou: ' + routename + ' cat: ' + CategoryChoosed);
					//alert(pathname + 'ReadMapdata.php');

					$.ajax({
						type: 'POST',
						url: pathname + 'ReadMapdata.php',
						data: {
							menuon: CatMenuFUNCTIONAL,
							routeon: routename,
							contentfilter: ContentType,
							datafilter: FilterType,
							categorystate: CategoryChoosed,
							searchstring: SearchRequest,
							contentlang: '<?PHP echo $language; ?>'
						},
						success: function (data) {
							//alert(mainmenu); return;

							//var x = 0;
							//$.map(MapData['places'], function(value, key) {
								//console.log(key, value);
							//	x++;
							//});

							//if (Object.keys(data).length == 4 && CatMenuFUNCTIONAL.length > 0 && submenu != 'remove-route' && submenu != 'remove-area') {
							if (data == 'null' && CatMenuFUNCTIONAL.length > 0 && submenu != 'remove-route' && submenu != 'remove-area' && mainmenu != 'Informazioni') {
								<?PHP if ($language == 'en') { ?>
									alert('No data uploaded for this filter settings.');
								<?PHP } else { ?>
									alert('La scelta non contiene dati.');
								<?PHP } ?>
								if (map.hasLayer(Marker_layer)) { Marker_layer.clearLayers(); }
								MarkersAdded = 0;
								return;
							}

							if (data == 'null' && mainmenu == 'Search') {
								<?PHP if ($language == 'en') { ?>
								alert('No result for this keyword on database: ' + SearchRequest);
								<?PHP } else { ?>
								alert('La parola cercata non ha prodotto risultati: ' + SearchRequest);
								<?PHP } ?>
								if (map.hasLayer(Marker_layer)) { Marker_layer.clearLayers(); }
								MarkersAdded = 0;
								return;
							}

							if ((mainmenu == 'Itinerari' || mainmenu == 'Comuni') && (data == 'null' && submenu != 'remove-route' && submenu != 'remove-area')) {
								<?PHP if ($language == 'en') { ?>
									alert('No geom content uploaded to selected menu: ' + submenu);
								<?PHP } else { ?>
									alert('Questa area non contiene dati: ' + submenu);
								<?PHP } ?>
								return;
							}

							var MapData = data;
							MapData = $.parseJSON(MapData);

							if (MapData.hasOwnProperty('places')) {
								if ((MapData['places']) != null) {
									if (map.hasLayer(Marker_layer)) { Marker_layer.clearLayers(); }
									MarkersAdded = 0;

									$.each(MapData['places'], function(ContentID, PlaceData) {
										var contentID = PlaceData['id'];

										if ((PlaceData['icondata']) != null) {
											var iconname = PlaceData['icondata'];
											var iconpath = 'media/mapicons/' + iconname;

											var CustomIconOBJ = L.Icon.extend({
												options: {
													iconUrl: iconpath,
													iconAnchor: [13, 27],
													popupAnchor: [1, -40],
													iconSize: [24, 27]
												}
											});

										} else {

											var CustomIconOBJ = L.Icon.extend({
												options: {
													iconUrl: 'assets/js/leaflet/images/marker-icon.png',
													iconAnchor: [13, 27],
													popupAnchor: [-5, -40],
													iconSize: [14, 22]
												}
											});
										}
										var IconOBJECT = new CustomIconOBJ();

										GTitleString = '';
										if (PlaceData.hasOwnProperty('distance')) {
											<?PHP if ($language == 'en') { ?> var DistFrom = 'Distance from:'; <?PHP } else { ?> var DistFrom = 'Vicino a:'; <?PHP } ?>
											if (MapData[0].hasOwnProperty('id')) {
												var R_the_url = './index.php?module=content&object=' + MapData[0]['id'];
												DistanceString = DistFrom + ' <b><a href="' + R_the_url + '">' + routename.toUpperCase() + ':</a></b> ' + PlaceData['distance'] + ' meters.';
											} else {
												DistanceString = DistFrom + ' <b>' + routename.toUpperCase() + ':</b> ' + PlaceData['distance'] + ' meters.';
											}
										} else {
											DistanceString = '';
											if (MapData.hasOwnProperty(0)) {
												if (MapData[0].hasOwnProperty('id')) {
													<?PHP if ($language == 'en') { ?> var GeomType = 'Area/Route:'; <?PHP } else { ?> var GeomType = 'Comuni/Itinerari:'; <?PHP } ?>
													var AREAcontentID = MapData[0]['id'];
													var area_geom_url = './index.php?module=content&object=' + AREAcontentID;
													GTitleString = '<b>' + GeomType + ' <a href="' + area_geom_url + '">' + MapData[0]['title'].toUpperCase() + '</a></b>';
												} else { GTitleString = ''; }
											} else { GTitleString = ''; }
										}

										if (PlaceData.hasOwnProperty('address')) {
											AddressString = PlaceData['address'] + '<br>';
										} else { AddressString = ''; }

										if (PlaceData.hasOwnProperty('cat_id')) {
											CategoryID = PlaceData['cat_id'];
											if (CategoryID != null) {
												CategoryLink = './index.php?module=category&object=' + CategoryID;
											} else { CategoryID = ''; }
										} else { CategoryID = ''; }

										if (PlaceData.hasOwnProperty('cat_name')) {
											if (PlaceData['cat_name'] != null) {
												CategoryString = '<a href="' + CategoryLink + '">' + PlaceData['cat_name'] + '</a>';
											} else { CategoryString = ''; }
										} else { CategoryString = ''; }

										SubCategoryString = '';
										if (PlaceData.hasOwnProperty('subcat_name')) {
											if (PlaceData.hasOwnProperty('subcat_id')) {
												SubCategoryID = PlaceData['subcat_id'];
												if (CategoryID != SubCategoryID) {
													if (SubCategoryID != null) {
														SubCategoryLink = './index.php?module=category&object=' + SubCategoryID;
														if (CategoryID != '') {
															SubCategoryString = ', <a href="' + SubCategoryLink + '">' + PlaceData['subcat_name'] + '</a>';
														} else {
															SubCategoryString = '<a href="' + SubCategoryLink + '">' + PlaceData['subcat_name'] + '</a>';
														}
													}
												}
											}
										}

										if (PlaceData.hasOwnProperty('start_date') && PlaceData.hasOwnProperty('end_date')) {
											<?PHP if ($language == 'en') { ?>
												EventString = '<div class="PopupDates"><b>Start:</b> ' + PlaceData['start_date'] + '&nbsp;|&nbsp;<b>End:</b> ' + PlaceData['end_date'] + '</div>';
											<?PHP } else { ?>
												EventString = '<div class="PopupDates"><b>Inizio:</b> ' + PlaceData['start_date'] + '&nbsp;|&nbsp;<b>Fine:</b> ' + PlaceData['end_date'] + '</div>';
											<?PHP } ?>
										} else { EventString = ''; }

										if (PlaceData.hasOwnProperty('coords_lat') && PlaceData.hasOwnProperty('coords_lon')) {
											CoordsString = '<div class="PopupCoords"><b>Lat: </b>' + PlaceData['coords_lat'] + '&nbsp;|&nbsp;<b>Lon: </b>' + PlaceData['coords_lon'] + '</div>';
										} else { CoordsString = ''; }

										var the_url = './index.php?module=content&object=' + contentID;
										//ContentLink = '<p><a href="' + the_url + '" target="_blank">Read content...</a>';
										ContentLink = '';

										if (PlaceData.hasOwnProperty('content_title')) {
											TitleString = '<a href="' + the_url + '" style="font-size:15px;">' + PlaceData['content_title'] + '</a></b>';
										} else { TitleString = ''; }

										if (PlaceData.hasOwnProperty('content_part')) {
											<?PHP if ($language == 'en') { ?> var ReadFullSTR = 'Open in new window'; <?PHP } else { ?> var ReadFullSTR = 'Apri in nuova finestra'; <?PHP } ?>
											SmallContent = PlaceData['content_part'] + '<br><a href="' + the_url + '" target="_blank"><span class="PopupReadFC external">' + ReadFullSTR + '</span></a>';
										} else { SmallContent = ''; }

										if (PlaceData.hasOwnProperty('default_image')) {
											DefaultImage = '<div class="PopupImageContainer"><a href="' + the_url + '"><img src="' + PlaceData['default_image'] + '" class="PopupImage"></a></div><div class="PopupSmallText">' + SmallContent + '</div><div class="PopupAddress">' + AddressString + '</div>';
										} else { DefaultImage = '<b>' + AddressString + '</b><div class="PopupSmallText">' + SmallContent + '</div>'; }

										var MarkerPopupString = "<b>" +
												contentID + ': ' +
												TitleString +
												' <span class="PopupCat">(' +
												CategoryString +
												SubCategoryString +
												')</span><br>' +
												EventString +
												DefaultImage +
												CoordsString +
												DistanceString +
												GTitleString +
												ContentLink;

										if ((PlaceData['point']) != null) {
											var ThePointData = PlaceData['point'];
											var geoj = $.geo.WKT.parse(ThePointData);

											//var marker = L.geoJson(geoj, {icon: IconOBJECT}).bindPopup("This is popup content 1.");
											var marker = L.geoJson(geoj, {
												pointToLayer: function (feature, latlng) {
													return L.marker(latlng, {icon: IconOBJECT})
													.bindPopup(MarkerPopupString)
													.on('click', function(e) { marker.openPopup(); })
													.on('mouseout', function(e) { marker.closePopup(); })
												}
											});
											marker.addTo(Marker_layer);
											//map.fitBounds(marker.getBounds());
											MarkersAdded++;

										} else if (PlaceData['lat'] != null && PlaceData['lng'] != null) {
											var TheLat = PlaceData['lat'];
											var TheLon = PlaceData['lng'];

											var marker = L.marker([TheLat, TheLon], {icon: IconOBJECT}).bindPopup(MarkerPopupString);
											marker.addTo(Marker_layer);
											MarkersAdded++;
										}
									});
								} else {
									if (map.hasLayer(Marker_layer)) { Marker_layer.clearLayers(); }
									MarkersAdded = 0;
								}
							} else {
								if (map.hasLayer(Marker_layer)) { Marker_layer.clearLayers(); }
								MarkersAdded = 0;
							}

							if (mainmenu == 'Punti' && CatMenuON.length > 0 && MarkersAdded == 0) {
								<?PHP if ($language == 'en') { ?>
									alert('No markers available with this filter.');
								<?PHP } else { ?>
									alert('Questo filtro non produce Punti di interesse.');
								<?PHP } ?>
							}

							if (MapData.hasOwnProperty(0)) {
								if (MapData[0].hasOwnProperty('route')) {
									//GeomsAdded = 0;
									if ((MapData[0]['route']) != null && (MapData[0]['route']) != '[]') {
										var contentID = MapData[0]['id'];

										if (mainmenu == 'Itinerari' || mainmenu == 'Comuni') {
											if (map.hasLayer(Area_Layer)) { Area_Layer.clearLayers(); }
											if (map.hasLayer(Route_Layer)) { Route_Layer.clearLayers(); }
											GeomsAdded = 0;
										}

										var geoj = $.geo.WKT.parse(MapData[0]['route']);
										if ((MapData['TheColor']) != null) { routecolor = MapData['TheColor']; } else { routecolor = "#ff00fb"; }

										var RouteStyle = {
											"color": routecolor,
											"weight": 5,
											"opacity": 0.9
										};

										var the_geom_url = './index.php?module=content&object=' + contentID;
										//GContentLink = '<p><a href="' + the_geom_url + '" target="_blank">Read content...</a>';
										GContentLink = '';

										if (MapData[0].hasOwnProperty('title')) {
											GTitleString = '<b><a href="' + the_geom_url + '">' + MapData[0]['title'].toUpperCase() + '</a></a></b><br>';
										} else { GTitleString = ''; }

										if (MapData[0].hasOwnProperty('address')) {
											GAddressString = MapData[0]['title'].toUpperCase() + ' ' + MapData[0]['address'] + '<br>';
										} else { GAddressString = ''; }

										if (MapData[0].hasOwnProperty('content_part')) {
											<?PHP if ($language == 'en') { ?> var ReadFullSTR = 'Open in new window'; <?PHP } else { ?> var ReadFullSTR = 'Apri in nuova finestra'; <?PHP } ?>
											GSmallContent = MapData[0]['content_part'] + '<br><a href="' + the_geom_url + '" target="_blank"><span class="PopupReadFC external">' + ReadFullSTR + '</span></a>';
										} else { GSmallContent = ''; }

										if (MapData[0].hasOwnProperty('defimage')) {
											Gdefimage = '<div class="PopupImageContainer"><a href="' + the_geom_url + '"><img src="' + MapData[0]['defimage'] + '" class="PopupImage"></a></div><div class="PopupSmallText">' + GSmallContent + '</div><div class="PopupAddress">' + GAddressString + '</div>';
										} else { Gdefimage = '<hr><b>' + GAddressString + ':</b><div class="PopupSmallText">' + GSmallContent + '</div><hr style="clear: both;">'; }

										var GeomPoupString = "<b>" + contentID + ": </b>" +
																					GTitleString +
																					Gdefimage +
																				 	GContentLink;

										var routes = L.geoJson(geoj, { style: RouteStyle })
										//.on('click', function(e) { routes.openPopup(); })
										//.on('mouseout', function(e) { routes.closePopup(); })
										.bindPopup(GeomPoupString, {offset: new L.Point(0, 0)});

										if (mainmenu == 'Itinerari') {
											routes.addTo(Route_Layer); GeomsAdded++; routes.openPopup();
											map.fitBounds(Route_Layer.getBounds(), { padding: [5,5], maxZoom: 11 });
										} else if (mainmenu == 'Comuni') {
											routes.addTo(Area_Layer); GeomsAdded++; routes.openPopup();
											map.fitBounds(Area_Layer.getBounds(), { padding: [5,5], maxZoom: 11 });
										}

									} else {
										if (submenu != 'remove-route' && submenu != 'remove-area' && (mainmenu == 'Itinerari' || mainmenu == 'Comuni')) {
											if (map.hasLayer(Route_Layer)) { Route_Layer.clearLayers(); }
											if (map.hasLayer(Area_Layer)) { Area_Layer.clearLayers(); }
											<?PHP if ($language == 'en') { ?>
												alert('No route or area available in this menu.');
											<?PHP } else { ?>
												alert('Non ci sono itinerari in questo menu.');
											<?PHP } ?>
											GeomsAdded = 0;
										}
									}
								} else {
									if (submenu != 'remove-route' && submenu != 'remove-area' && (mainmenu == 'Itinerari' || mainmenu == 'Comuni')) {
										if (map.hasLayer(Route_Layer)) { Route_Layer.clearLayers(); }
										if (map.hasLayer(Area_Layer)) { Area_Layer.clearLayers(); }
										<?PHP if ($language == 'en') { ?>
											alert('No route or area available in this menu.');
										<?PHP } else { ?>
											alert('Non ci sono itinerari in questo menu.');
										<?PHP } ?>
										GeomsAdded = 0;
									}
								}
							} else {
								if (submenu != 'remove-route' && submenu != 'remove-area' && (mainmenu == 'Itinerari' || mainmenu == 'Comuni')) {
									if (map.hasLayer(Route_Layer)) { Route_Layer.clearLayers(); }
									if (map.hasLayer(Area_Layer)) { Area_Layer.clearLayers(); }
									<?PHP if ($language == 'en') { ?>
										alert('No route or area available in this menu.');
									<?PHP } else { ?>
										alert('Non ci sono itinerari in questo menu.');
									<?PHP } ?>
									GeomsAdded = 0;
								}
							}

							if (GeomsAdded == 0 && MarkersAdded > 0) {
								map.fitBounds(Marker_layer.getBounds(), { padding: [10,10], maxZoom: 11 });
							}

							if ((PrevClicked != mainmenu) && (mainmenu == 'Punti' || mainmenu == 'Eventi' || mainmenu == 'Aziende' || mainmenu == 'Epoca' || mainmenu == 'Search')) {
								PrevClicked = mainmenu;
							}
						}, error: function(request, status, error){
							alert('Ajax problem: ' + request.responseText + ' ' + status + ' ' + error);
						}
					});
					if (map.hasLayer(Circle_Layer)) { Circle_Layer.clearLayers(); }
				});
			});
			
			$(document).ajaxError(
	    function (event, jqXHR, ajaxSettings, thrownError) {
	        alert('[event:' + event + '], [jqXHR:' + jqXHR + '], [ajaxSettings:' + ajaxSettings + '], [thrownError:' + thrownError + '])');
	    });
		</script>
	<?PHP }
?>