//////////////////
//				//
//	  Routes	//
//				//
//////////////////

//Get !ROUTE! information with PHP idiorm query
<?php


$theroutes = ORM::for_table('contents')->select_many('id', 'title', 'address', 'text', 'route')->where('type', 'route')->where('enabled', '1')->find_array(); 

$QueryString = "'external_id'=";
foreach($theroutes as $route){
	if(strpos($QueryString,$route['id']) == false){
		$QueryString .= "'".$route['id']."' OR ";
	}
}
$QueryString = '('.rtrim($QueryString, ' OR ').')';

$route_meta = ORM::for_table('content_meta')->select_many('external_id', 'name', 'value')->where_raw($QueryString)->find_array();
$route_media = ORM::for_table('content_media')->select_many('external_id', 'url', 'default_media')->where_raw($QueryString)->find_array();

foreach($theroutes as &$route){
	$i = 0;
	foreach($route_meta as $meta){
		if($meta['external_id'] == $route['id']){
			$route['meta'][$i] = $meta;
			$i++;
		}
	}
	$i = 0;
	foreach($route_media as $media){
		if($media['external_id'] == $route['id']){
			$route['media'][$i] = $media;
			$i++;
		}
	}
}

?>


//Add route information from php variable to JS variable
var route_info = <?php echo json_encode($theroutes); ?>;
console.log(route_info);
//Declare an object for later use as Layer
var routeOverlays = new Object();
var polyOverlays = new Object();

//Process gathered route WKT to Leaflet object and add it to the control layer
for(i = 0; i < route_info.length; i++){
			var routecolor = "#ff00fb";
			var photoslide = "";
			var photothumb = "";
			var photomain = "";
			var audiofile = "";
			var videofile = "";
			var panorama = "";		
			var categoria = "";
			var tipologia = "";
			var epoque = "";
			var periodo = "";
			var nome = "";
			var toponimo = "";
			var itinerario = "";
			var proprieta = "";
			var gestore = "";
			var conservazione = "";
			var access = "";
			var contacta = "";
			var contactb = "";
			var attuale = "";
			var storiche = "";
	
	if(route_info[i]['meta'] != undefined){
		for(x = 0; x < route_info[i]['meta'].length; x++){
			if(route_info[i]['meta'][x]['name'] == "audio-file"){
				audiofile = '<source src="'+route_info[i]['meta'][x]['value']+'" type="audio/mpeg">';
			}
			//Check if we found a video data and whether it is youtube/vimeo/rawfiile
			else if(route_info[i]['meta'][x]['name'] == "video-youtube"){
				videofile = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'+route_info[i]['meta'][x]['value']+'" frameborder="0" allowfullscreen></iframe>';
			}
			else if(route_info[i]['meta'][x]['name'] == "video-vimeo"){
				videofile = '<iframe src="https://player.vimeo.com/video/'+route_info[i]['meta'][x]['value']+'" width="560" height="311" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
			}
			else if(route_info[i]['meta'][x]['name'] == "video-file"){
				videofile = '<video width="560" height="315" controls><source src="'+route_info[i]['meta'][x]['value']+'" type="video/mp4">Your browser does not support the video tag.</video>';
			}
			else if(route_info[i]['meta'][x]['name'] == "panorama-source"){
				panorama = '<iframe src="'+route_info[i]['meta'][x]['value']+'" width="560" height="311"frameborder="0"></iframe>';
			}
			else if(route_info[i]['meta'][x]['name'] == "route-color"){
				routecolor = route_info[i]['meta'][x]['value'];
				console.log("color");
			}
			else if(route_info[i]['meta'][x]['name'] == "categoria"){
				categoria = route_info[i]['meta'][x]['value'];
			}
			else if(route_info[i]['meta'][x]['name'] == "tipologia"){
				tipologia = route_info[i]['meta'][x]['value'];
			}
			else if(route_info[i]['meta'][x]['name'] == "epoca"){
				epoque = route_info[i]['meta'][x]['value'];
			}
			else if(route_info[i]['meta'][x]['name'] == "data_periodo_costruzione"){
				periodo = mroute_info[i]['meta'][x]['value'];
			}
			else if(route_info[i]['meta'][x]['name'] == "nome_locale"){
				nome = "Nome locale: "+route_info[i]['meta'][x]['value'];
			}
			else if(route_info[i]['meta'][x]['name'] == "origine_toponimo"){
				toponimo = "Origine del toponimo: "+route_info[i]['meta'][x]['value'];
			}
			else if(route_info[i]['meta'][x]['name'] == "tipo_itine"){
				itinerario = "Itinerario: <br> "+route_info[i]['meta'][x]['value'];
			}
			else if(route_info[i]['meta'][x]['name'] == "proprieta"){
				proprieta = "Proprietá: "+route_info[i]['meta'][x]['value'];
			}
			else if(route_info[i]['meta'][x]['name'] == "ente_gestore"){
				gestore = "Ente gestore: "+route_info[i]['meta'][x]['value'];
			}
			else if(route_info[i]['meta'][x]['name'] == "conservazione"){
				conservazione = "Conservazione: "+route_info[i]['meta'][x]['value'];
			}
			else if(route_info[i]['meta'][x]['name'] == "accesibilita"){
				access = "Accessibilitá: "+route_info[i]['meta'][x]['value'];
			}
			else if(route_info[i]['meta'][x]['name'] == "periodo_orario_apertura"){
				contacta += route_info[i]['meta'][x]['value']+"<br>";
			}
			else if(route_info[i]['meta'][x]['name'] == "prezzi_ingrerro"){
				contacta += route_info[i]['meta'][x]['value']+"<br>";
			}
			else if(route_info[i]['meta'][x]['name'] == "servizi"){
				contacta += route_info[i]['meta'][x]['value']+"<br>";
			}
			else if(route_info[i]['meta'][x]['name'] == "persona_contatto"){
				contactb += "Persona di contatto: "+route_info[i]['meta'][x]['value']+"<br>";
			}
			else if(route_info[i]['meta'][x]['name'] == "telefono"){
				contactb += "Telefono: "+route_info[i]['meta'][x]['value']+"<br>";
			}
			else if(route_info[i]['meta'][x]['name'] == "cellulare"){
				contactb += "Cellulare: "+route_info[i]['meta'][x]['value']+"<br>";
			}
			else if(route_info[i]['meta'][x]['name'] == "fax"){
				contactb += "Fax: "+route_info[i]['meta'][x]['value']+"<br>";
			}
			else if(route_info[i]['meta'][x]['name'] == "email"){
				contactb += "Email: "+route_info[i]['meta'][x]['value']+"<br>";
			}
			else if(route_info[i]['meta'][x]['name'] == "website"){
				contactb += "Site web: "+route_info[i]['meta'][x]['value']+"<br>";
			}
			else if(route_info[i]['meta'][x]['name'] == "utilizzo_attuale"){
				attuale += "<b>Utilizzo attuale:</b> "+route_info[i]['meta'][x]['value']+"<br>";
			}
			else if(route_info[i]['meta'][x]['name'] == "vincoli"){
				attuale += "<b>Vincoli:</b> "+route_info[i]['meta'][x]['value']+"<br>";
			}
			else if(route_info[i]['meta'][x]['name'] == "bibliografia_fonti"){
				attuale += "<b>Bibliografia:</b> "+route_info[i]['meta'][x]['value']+"<br>";
			}
			else if(route_info[i]['meta'][x]['name'] == "notizie_storiche"){
				storiche += "<b>Notizie storiche</b>: "+route_info[i]['meta'][x]['value']+"<br>";
			}
		}
	}

	
	if(route_info[i]['media'] != undefined){
		for(x = 0; x < route_info[i]['media'].length; x++){
			if(route_info[i]['meta'][x]['default_media'] == 1){
				photomain = '<img width="560" height="315" src="'+route_info[i]['meta'][x]['url']+'" alt="" /><h2><span>'+route_info[i]["address"]+'</span></h2>';
			}
			photoslide = '<li id="#'+x+'"><a href="'+route_info[i]['meta'][x]['url']+'" data-lightbox="roadtrip"><img src="'+route_info[i]['meta'][x]['url']+'" style="position:relative; width:100%;"/></a></li>';
			photothumb += '<li><a href="'+route_info[i]['meta'][x]['url']+'" data-lightbox="roadtrip"><img src="'+route_info[i]['meta'][x]['url']+'" width="50" height="50" class="hoverZoomLink"/></a></li>';
		}
	}

	var geoj = $.geo.WKT.parse(route_info[i]["route"]);
	var routeobj = L.geoJson(geoj,{"color":routecolor, "opacity": 0.9});
		routeobj.content = new Object();
		routeobj.content.title = route_info[i]["title"];
		routeobj.content.category = 'Route';
		routeobj.content.text = route_info[i]["text"];
		routeobj.content.audio = audiofile;
		routeobj.content.video = videofile;
		routeobj.content.panorama = panorama;
		routeobj.content.poiphoto = photomain;
		routeobj.content.photoslide = photoslide;
		routeobj.content.photothumb = photothumb;
		routeobj.content.nome = nome;
		routeobj.content.epoque = epoque;
		routeobj.content.toponimo = toponimo;
		routeobj.content.proprieta = proprieta+"<br>"+gestore;
		routeobj.content.conservazione = conservazione+"<br>"+access;
		routeobj.content.contact = contacta+"<hr width='99%' style='border-style:inset; border-width:1px; border-color:black;'>"+contactb;
		routeobj.content.attuale = attuale;
		routeobj.content.storiche = storiche;				
		
	routeobj.on( 'click', function( e ) {
			$( '#mmap_modal_title' ).html( this.content.title );
			$( '#mmap_modal_body' ).html( this.content.text );
			$( '#sub_poipic' ).html( this.content.poiphoto );
			$( '#slide_slider' ).html( this.content.photoslide );
			$( '#slide_thumb' ).html( this.content.photothumb );
			$( '#sub_category' ).html( this.content.category );
			$( '#sub_epoque' ).html( this.content.epoque );
			$( '#sub_origin_nome' ).html( this.content.nome );
			$( '#sub_origin_toponimo' ).html( this.content.toponimo );
			$( '#sub_itinerario' ).html( this.content.itinerario );
			$( '#sub_proprieta' ).html( this.content.proprieta );
			$( '#sub_conservazione' ).html( this.content.conservazione );
			$( '#mmap_modal_contact' ).html( this.content.contact );
			$( '#sub_others_attuale' ).html( this.content.attuale );
			$( '#sub_others_storiche' ).html( this.content.storiche );
			$( '#mmap_modal_audiosource' ).html( this.content.audio );
			$( '#mmap_modal_panorama' ).html( this.content.panorama );
			$( '#mmap_modal_video' ).html( this.content.video );
			$( '#mmap_modal' ).modal( 'show' );
		} );
				
	var n = route_info[i]["title"];
	if(route_info[i]["route"].indexOf("LINE") == -1){
		polyOverlays[n] = routeobj;
	}else{
		routeOverlays[n] = routeobj;
	}
	
}

//////////////////
//				//
//	Categories	//
//				//
//////////////////

//Get !CATEGORIES! information with PHP idiorm query
<?php
//Fetch the specific categories
$thecats = ORM::for_table('categories')->select_many('name', 'title', 'contents')->find_array();
//Parse categories content into object (php array of array)

$QueryString = "'id'=";

//Prepare query string for gathering POI information but form and decode JSON first to get the POI IDs.
foreach($thecats as &$cat_value){
		//Convert the contents of the categories (pois, events) into an array from {} JSON
		$cat_value['contents'] = str_replace(";",",",$cat_value['contents']);
		$cat_value['contents'] = str_replace("{","",$cat_value['contents']);
		$cat_value['contents'] = str_replace("}","",$cat_value['contents']);
		$cut = "[";
		$cut .= $cat_value['contents'];
		$cut .= "]";
		$cat_value['contents'] = json_decode($cut);
		//Prepare the query string for gathering all the pois and their meta
		foreach($cat_value['contents'] as $poi_data){
			if(strpos($QueryString,$poi_data) == false){
				$QueryString .= "'".$poi_data."' OR ";
			}
		}
}
//Finalize query string
$QueryString = '('.rtrim($QueryString, ' OR ').')';

//Gather POI information
$poi_data = ORM::for_table('contents')->select_many('id', 'type', 'title', 'address', 'lng', 'lat', 'text', 'start', 'end', 'language', 'parent')->where_raw($QueryString)->where('enabled', '1')->find_array();

$QueryString = str_replace('id','external_id',$QueryString);
$poi_meta = ORM::for_table('content_meta')->select_many('external_id', 'name', 'value')->where_raw($QueryString)->find_array();		
$poi_media = ORM::for_table('content_media')->select_many('external_id', 'url', 'default_media')->where_raw($QueryString)->find_array();

//Get the current site language
$language = new M_Language;
$lang = $language->getLanguage();
$lang_def = ORM::for_table('preferences')->select('value')->where('name', 'default_language')->find_array();

//Merge the queried information into an object
$poi_data_length = count($poi_data,0);

foreach($thecats as &$cat_value){
	//Go through the contents and add the correct POI information (check language and event date also)
	foreach($cat_value['contents'] as &$content){	 
		$i = 0;
		$found = 0;
		while(($i < $poi_data_length) && ($found < 1)){
			$eventended = false;
			if($poi_data[$i]['type'] == "event"){
				$eventend = new DateTime($poi_data[$i]['end']);
				$now = new DateTime();
				if($eventend < $now){
					$eventended = true;
				}
			}
			if(!($eventended)){
				if(($poi_data[$i]['id'] == $content) && ($poi_data[$i]['language'] == $lang)){
					$content = $poi_data[$i];
					$found = 2;
				}
				if(($poi_data[$i]['id'] == $content) && ($poi_data[$i]['language'] == $lang_def[0]["value"])){
					$found = 1;
					$ident = $i;
				}
			}
			$i++;
		}
		//If we found the POI stated in categories but only in default language
		if($found == 1){
			$content = $poi_data[$ident];
		}
		//Add meta information to our new content object
		$j = 0;
		foreach($poi_meta as $metadata){
			if($content['id'] == $metadata['external_id']){
				$content['meta'][$j] = $metadata;
				$j++;
			}
		}
		$j = 0;
		foreach($poi_media as $mediadata){
			if($content['id'] == $mediadata['external_id']){
				$content['media'][$j] = $mediadata;
				$j++;
			}
		}
	}
}


?>

//Add route information from php variable to JS variable
var thecats = <?php echo json_encode($thecats); ?>;

/*
thecats is a 3 dimensional associative array.
It varies on the vector of 'x', 'y', 'z' and every element on these vectors have their own unique sub-element
'x' stands for the Categories in the object e.g.: [x].title = category title
'y' stands for the contents, there for it used like: [x]['contents'][y].id <-- place of POI data / id of POI
'z' stands for meta information for POI: [x]['contents'][y]['meta'][z].name <-- identifire of the meta information no.z
*/

var global_lang = <?php echo json_encode($lang); ?>;
console.log('Language is currently set to: '+global_lang);

//Declare an object for later use as Layer for categories
var catsOverlays = new Object();

//Process all the categories one-by-one for each element.
for(x = 0; x < thecats.length; x++){
	var catx = thecats[x].title;
	catsOverlays[catx] = L.layerGroup();
	
	for(y = 0; y < thecats[x]['contents'].length; y++){
		if(thecats[x]['contents'][y].id != undefined){
			var iconfound = 0;
			var photoslide = "";
			var photothumb = "";
			var photomain = "";
			var audiofile = "";
			var videofile = "";
			var panorama = "";
			var categoria = "";
			var tipologia = "";
			var epoque = "";
			var periodo = "";
			var nome = "";
			var toponimo = "";
			var itinerario = "";
			var proprieta = "";
			var gestore = "";
			var conservazione = "";
			var access = "";
			var contacta = "";
			var contactb = "";
			var attuale = "";
			var storiche = "";
				
			//Go through meta information
			if(thecats[x]['contents'][y]['meta'] != undefined){
				for(z = 0; z < thecats[x]['contents'][y]['meta'].length; z++){
					var metadata = thecats[x]['contents'][y]['meta'][z];
					//Check if we found an icon-file
					if(metadata.name == "icon-file"){
						iconfound = 1;
						var caticon = "media/mapicons/"+thecats[x]['contents'][y]['meta'][z].value;
						var micon = L.icon({
							iconUrl: caticon,
							iconSize: [32,37]
						});
					}
					//Check if we found and audio file
					else if(metadata.name == "audio-file"){
						var audiofile = 'media/audio/'+metadata.value;
					}
					//Check if we found a video data and whether it is youtube/vimeo/rawfiile
					else if(metadata.name == "video-youtube"){
						videofile = '<iframe style="width:100%; height:25vw;" src="https://www.youtube.com/embed/'+metadata.value+'" frameborder="0" allowfullscreen></iframe>';
					}
					else if(metadata.name == "video-vimeo"){
						videofile = '<iframe src="https://player.vimeo.com/video/'+metadata.value+'" style="width:100%; height:25vw;" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
					}
					else if(metadata.name == "video-file"){
						videofile = '<video style="width:100%; height:25vw;" controls><source src="'+metadata.value+'" type="video/mp4">Your browser does not support the video tag.</video>';
					}
					else if(metadata.name == "panorama-source"){
						panorama = '<iframe src="media/panorama/'+metadata.value+'" style="width:100%; height:25vw;" frameborder="0"></iframe>';
					}
					else if(metadata.name == "categoria"){
						categoria = metadata.value;
					}
					else if(metadata.name == "tipologia"){
						tipologia = metadata.value;
					}
					else if(metadata.name == "epoca"){
						epoque = metadata.value;
					}
					else if(metadata.name == "data_periodo_costruzione"){
						periodo = metadata.value;
					}
					else if(metadata.name == "nome_locale"){
						nome = "<b>Nome locale:</b> "+metadata.value+"<br>";
					}
					else if(metadata.name == "origine_toponimo"){
						toponimo = "Origine del toponimo: "+metadata.value;
					}
					else if(metadata.name == "tipo_itine"){
						itinerario = "Itinerario: <br> "+metadata.value;
					}
					else if(metadata.name == "proprieta"){
						proprieta = "<b>Proprietá:</b> "+metadata.value;
					}
					else if(metadata.name == "ente_gestore"){
						gestore = "<b>Ente gestore:</b> "+metadata.value;
					}
					else if(metadata.name == "conservazione"){
						conservazione = "<b>Conservazione:</b> "+metadata.value;
					}
					else if(metadata.name == "accesibilita"){
						access = "<b>Accessibilitá:</b> "+metadata.value;
					}
					else if(metadata.name == "periodo_orario_apertura"){
						contacta += metadata.value+"<br>";
					}
					else if(metadata.name == "prezzi_ingrerro"){
						contacta += metadata.value+"<br>";
					}
					else if(metadata.name == "servizi"){
						contacta += metadata.value+"<br>";
					}
					else if(metadata.name == "persona_contatto"){
						contactb += "<b>Persona di contatto:</b> "+metadata.value+"<br>";
					}
					else if(metadata.name == "telefono"){
						contactb += "<b>Telefono:</b> "+metadata.value+"<br>";
					}
					else if(metadata.name == "cellulare"){
						contactb += "<b>Cellulare:</b> "+metadata.value+"<br>";
					}
					else if(metadata.name == "fax"){
						contactb += "<b>Fax:</b> "+metadata.value+"<br>";
					}
					else if(metadata.name == "email"){
						contactb += "<b>Email:</b> "+metadata.value+"<br>";
					}
					else if(metadata.name == "website"){
						contactb += "<b>Site web:</b> "+metadata.value+"<br>";
					}
					else if(metadata.name == "utilizzo_attuale"){
						attuale += "<b>Utilizzo attuale:</b> "+metadata.value+"<br>";
					}
					else if(metadata.name == "vincoli"){
						attuale += "<b>Vincoli:</b> "+metadata.value+"<br>";
					}
					else if(metadata.name == "bibliografia_fonti"){
						attuale += "<b>Bibliografia:</b> "+metadata.value+"<br>";
					}
					else if(metadata.name == "notizie_storiche"){
						storiche += "<b>Notizie storiche</b>: "+metadata.value+"<br>";
					}
				}
			}
			//Claim pictures for the POI
			if(thecats[x]['contents'][y]['media'] != undefined){
				var lth = thecats[x]['contents'][y]['media'].length;
				lth--;
				for(z = lth; z >= 0; z--){
					var mediadata = thecats[x]['contents'][y]['media'][z];
					if(mediadata.default_media == 1){
						photomain = '<img src="'+mediadata.url+'" alt="" style="width:100%; height:auto;" /><h2><span>'+thecats[x]['contents'][y].address+'</span></h2>';
					}
					photoslide = '<li id="#'+z+'"><a href="'+mediadata.url+'" data-lightbox="roadtrip"><img src="'+mediadata.url+'" style="position:relative; width:100%;"/></a></li>';
					photothumb += '<li><a href="'+mediadata.url+'" data-lightbox="roadtrip"><img src="'+mediadata.url+'" width="50" height="50" class="hoverZoomLink"/></a></li>';
				}
			}

			//If no custom icon file, take the icon of the category
			if(iconfound != 1){
				var caticon = 'media/mapicons/'+thecats[x].name+'.png';
				var micon = L.icon({
					iconUrl: caticon,
					iconSize: [32,37]
				});
			}
			
			//Build the markers for the map
			var lt = thecats[x]['contents'][y]['lat'];
			var ln = thecats[x]['contents'][y]['lng'];
			marker = L.marker([lt,ln],{icon: micon});
			marker.content = new Object();
				//Set up the content for each marker
				marker.content.title = thecats[x]['contents'][y].title;
				marker.content.category ='<img style="float:left;" src="'+caticon+'" width="32" height="37"/> <b>'+categoria+'</b><br>'+tipologia;
				marker.content.epoque = "<b>"+epoque+"</b><br>"+periodo;
				marker.content.text = thecats[x]['contents'][y].text;
				marker.content.audio = '<source src="'+audiofile+'" type="audio/mpeg">';
				marker.content.panorama = panorama;
				marker.content.video = videofile;
				marker.content.poiphoto = photomain;
				marker.content.itinerario = itinerario;
				marker.content.photoslide = photoslide;
				marker.content.photothumb = photothumb;
				marker.content.nome = nome;
				marker.content.toponimo = toponimo;
				marker.content.proprieta = proprieta+"<br>"+gestore;
				marker.content.conservazione = conservazione+"<br>"+access;
				marker.content.contact = contacta+"<hr width='99%' style='border-style:inset; border-width:1px; border-color:black;'>"+contactb;
				marker.content.attuale = attuale;
				marker.content.storiche = storiche;
				
				//Set up the marker to open modal on click with the content
				marker.on( 'click', function( e ) {
					$( '#mmap_modal_title' ).html( this.content.title );
					$( '#mmap_modal_body' ).html( this.content.text );
					$( '#sub_poipic' ).html( this.content.poiphoto );
					$( '#slide_slider' ).html( this.content.photoslide );
					$( '#slide_thumb' ).html( this.content.photothumb );
					$( '#sub_category' ).html( this.content.category );
					$( '#sub_epoque' ).html( this.content.epoque );
					$( '#sub_origin_nome' ).html( this.content.nome );
					$( '#sub_origin_toponimo' ).html( this.content.toponimo );
					$( '#sub_itinerario' ).html( this.content.itinerario );
					$( '#sub_proprieta' ).html( this.content.proprieta );
					$( '#sub_conservazione' ).html( this.content.conservazione );
					$( '#mmap_modal_audiosource' ).html( this.content.audio );
					$( '#mmap_modal_contact' ).html( this.content.contact );
					$( '#sub_others_attuale' ).html( this.content.attuale );
					$( '#sub_others_storiche' ).html( this.content.storiche );
					$( '#mmap_modal_panorama' ).html( this.content.panorama );
					$( '#mmap_modal_video' ).html( this.content.video );
					$( '#mmap_modal' ).modal( 'show' );
				} );
			
			marker.addTo(catsOverlays[catx]);
		}
	}
}

//////////////////
//				//
//	 Misc		//
//				//
//////////////////

var miscOverlays = new Object();
var weather = new L.WeatherIconsLayer();
miscOverlays["Weather"] = weather;

//Fetch Flickr preferences from database
<?php 
$fl_info = ORM::for_table('preferences')->select_many('name', 'value')->where_like('name', '%flickr_%')->find_array(); 
?>
	var flinfo = <?php echo json_encode($fl_info); ?>;
	for (i = 0; i < flinfo.length; i++){
		if(flinfo[i].name == "flickr_apikey"){
			fl_apikey = flinfo[i].value; 
		}
		else if(flinfo[i].name == "flickr_bbox"){
			fl_bbox = flinfo[i].value;
		}
		else if(flinfo[i].name == "flickr_numofpics"){
			fl_num = flinfo[i].value;
		}
	}
//Get the Flickr picture with Flickr API
if(flinfo.length == 3){
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

//Make markers and layer with the pictures	
var photo_markers = new L.LayerGroup();
	// Display the flickr photos
	function displayflickr(resp) {
	  if ( resp.photos && resp.photos.photo ) {		
		$.each(resp.photos.photo, function(k, photo) {
		  // Create a photo marker
		  var photo_marker = L.photoMarker([photo.latitude, photo.longitude], {
			src: photo.url_t,
			size: [ photo.width_t, photo.height_t ]
		  });
			var poptext = '<div align="center"><b>'+
				photo.title+'</b><br/><a href="'+photo.url_c+'" data-lightbox="roadtrip"><img src="'+photo.url_m+'" alt="'+photo.title+'" width="240px"/></a><br/>Visit on <a id="'+photo.id+'" title="'+photo.title+'" href="http://www.flickr.com/photos/'+photo.owner+'/'+
				photo.id+'/" target="_new">Flickr</a> | Views: '+photo.views+'<br/><br/>'+
				'&copy;&nbsp;<a href="http://www.flickr.com/people/'+photo.owner+'/" target="_new">'+photo.ownername+'</a><br/></div>';
		  
		  photo_marker.bindPopup(poptext);

			
		  var image = L.DomUtil.create('img');
		  image.onload = function() { photo_marker.addTo(photo_markers); };
		  image.src = photo.url_t;
		});
	  }
	}
miscOverlays["Flickr"] = photo_markers;

//////////////////
//				//
//	 Tiles		//
//				//
//////////////////

var openstreet = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {id: 'MapID', attribution: "OpenStreetMap"}),
    cycle = L.tileLayer('http://{s}.tile.thunderforest.com/cycle/{z}/{x}/{y}.png', {id: 'MapID', attribution: "Thunderforest - Cycle"}),
	outdoor = L.tileLayer('http://{s}.tile.thunderforest.com/outdoors/{z}/{x}/{y}.png', {id: 'MapID', attribution: "Thunderforest - Outdoors"});

//////////////////
//				//
//	 Layers 	//
//				//
//////////////////	
	
/* var baseMaps = {
    "Default": openstreet,
	"Cycle": cycle,
	"Outdoors": outdoor
};	*/
var baseMaps = {
};


var groupedOverlays = {
  "Categories":{
  }
};

$.extend(groupedOverlays["Misc"], miscOverlays);
$.extend(groupedOverlays["Categories"], catsOverlays);

var groupcomOverlays = {
	"Communities":{
	}
}
$.extend(groupcomOverlays["Communities"], polyOverlays);

//Add layers to a controlpanel and then to the map
//Collapse the control panel if viewed by a touch-screen for align reasons
//var coll = L.Browser.touch;

L.control.groupedLayers(baseMaps, groupedOverlays, {collapsed: true, position: 'topleft'}).addTo(map);
L.control.groupedLayers(baseMaps, groupcomOverlays, {collapsed: true, position: 'topleft'}).addTo(map);

//Merge routes with categories so later we can remove them from the control panel listing as they are only signs
var hidenames = new Object;
for (i in routeOverlays){
	for (x in catsOverlays){
		if(x == i){
			hidenames[x] = x;
			$("#leaflet-control-layers-Categories-"+x).hide();
		}
	}
}

//Control of collapsing groups on the layer (dirty solution)
$("body").delegate(".leaflet-control-group-button", "click", function()
{
    var myid = $(this)[0].id
    if ($("#"+myid).html() == "&nbsp;+")
    {
        $("#leaflet-control-"+myid).children().show()
        $("#"+myid).html("&nbsp;-")
		for(x in hidenames){
			$("#leaflet-control-layers-Categories-"+x).hide()
		}
    }
    else
    {
        $("#leaflet-control-"+myid).children().hide()
		$("#leaflet-control-"+myid).children(".leaflet-control-layers-group-name").show()
		$("#leaflet-control-"+myid).children(".leaflet-control-group-button").show()
        $("#"+myid).html("&nbsp;+")
    }
});

//Manage the routes listed in the navigation bar (manu on the top)
function routes_menu(clicked){
	if((map.hasLayer(catsOverlays[clicked])) && (map.hasLayer(routeOverlays[clicked]))){
		map.removeLayer(catsOverlays[clicked])
		map.removeLayer(routeOverlays[clicked])
		$("#leaflet-control-layers-Categories-"+clicked).hide()
	}
	else{
		map.addLayer(catsOverlays[clicked])
		map.addLayer(routeOverlays[clicked])
	}
}
function misc_menu(clicked){
	if((clicked == "Weather") && (map.hasLayer(miscOverlays["Weather"]))){
		map.removeLayer(miscOverlays[clicked]);	
	}else if((clicked == "Flickr") && (map.hasLayer(miscOverlays["Flickr"]))){
		map.removeLayer(miscOverlays[clicked]);
	}else{
		map.addLayer(miscOverlays[clicked]);
	}
}