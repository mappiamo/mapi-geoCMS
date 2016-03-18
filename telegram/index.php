<?php

	$bot_id = "168043776:AAECiuRuj4lkai1LClUX5rySniZ_wR8e-qc";
	$SiteURL = 'http://dev.mappiamo.org';
	$ApiKey = 'dfasdqw435reg4e5ytbxfsdfh';
	$ReturnDataNum = 10;
	$Radius = 10;

	$telegram = "../lib/telegram/Telegram.php";

	if (is_file($telegram) && is_readable($telegram)) {
		include($telegram);
	} else {
		die();
	}

	$telegram = new Telegram($bot_id);

	$text = strtolower($telegram->Text());
	$chat_id = $telegram->ChatID();
	$result = $telegram->getData();

	$text = str_replace(' ', '_', $text);

	if ((isset($result['message']['location']['longitude'])) && (isset($Radius)) && (isset($result['message']['location']['latitude']))) {
		$Lat = $result['message']['location']['latitude'];
		$Lon = $result['message']['location']['longitude'];

		$reply = "Collecting data from database using location and radius...";
		$content = array('chat_id' => $chat_id, 'text' => $reply);
		$telegram->sendMessage($content);

		$GetData =
		$SiteURL.'/index.php?module=api&task=telegram&ApiKey='.$ApiKey.'&ReturnDataNum='.$ReturnDataNum.'&text='.$text.
		'&lat='.$Lat.'&lng='.$Lon.'&radius='.$Radius.'&id='.$chat_id;

		$reply = file_get_contents($GetData);
		$content =
		array('chat_id' => $chat_id, 'text' => $reply, 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE);
		$telegram->sendMessage($content);
	}

	if (strlen($text) > 2) {

		if ($text == "/start" || $text == "start") {
			$option = array(array("Start", "Help", "About", "Rules"), array("Category:show", "Setting:show", "Setting:reset"), array("Location:reset", "Search"), array("radius:reset", "language:reset"), array("type:reset", "returndata:reset"), array("radius:5", "radius:20", "radius:50", "radius:200"), array("type:place", "type:event", "type:post"), array("returndata:5", "returndata:10", "returndata:15"), array("language:en", "language:it", "language:de", "language:fr"));
			$keyb = $telegram->buildKeyBoard($option, $onetime=false);
			$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Welcome to MapiBot \n\nThis Telegram bot reads content from $SiteURL \nPlease type command /help or click the button below!");
			$telegram->sendMessage($content);

		} else {

			$GetData =
			$SiteURL.'/index.php?module=api&task=telegram&ApiKey='.$ApiKey.'&ReturnDataNum='.$ReturnDataNum.'&text='.$text.
			'&id='.$chat_id;

			$reply = file_get_contents($GetData);
			$content = array('chat_id' => $chat_id, 'text' => $reply, 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE);
			$telegram->sendMessage($content);
		}
	}

	/* $reply = print_r($result, 1);
	$content = array('chat_id' => $chat_id, 'text' => $reply);
	$telegram->sendMessage($content); */
?>