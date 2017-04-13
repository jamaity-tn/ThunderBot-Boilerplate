<?php 
use pimax\Messages\SenderAction;


function remove_emoji($text){
	return preg_replace('/([0-9|#][\x{20E3}])|[\x{00ae}|\x{00a9}|\x{203C}|\x{2047}|\x{2048}|\x{2049}|\x{3030}|\x{303D}|\x{2139}|\x{2122}|\x{3297}|\x{3299}][\x{FE00}-\x{FEFF}]?|[\x{2190}-\x{21FF}][\x{FE00}-\x{FEFF}]?|[\x{2300}-\x{23FF}][\x{FE00}-\x{FEFF}]?|[\x{2460}-\x{24FF}][\x{FE00}-\x{FEFF}]?|[\x{25A0}-\x{25FF}][\x{FE00}-\x{FEFF}]?|[\x{2600}-\x{27BF}][\x{FE00}-\x{FEFF}]?|[\x{2900}-\x{297F}][\x{FE00}-\x{FEFF}]?|[\x{2B00}-\x{2BF0}][\x{FE00}-\x{FEFF}]?|[\x{1F000}-\x{1F6FF}][\x{FE00}-\x{FEFF}]?/u', '', $text);
}

function remove_accents($str, $charset='utf-8')
{
	$str = htmlentities($str, ENT_NOQUOTES, $charset);

	$str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
    
    return $str;
}

function logInput($sender, $message=[]){

	$file = 'log-'.date('Y').date('m').date('d').'.txt';

	$opencreate = fopen($file, 'a+');
	$current = file_get_contents($file);

	$gotContent = "FALSE";
	$content = "FALSE";
	$payload = "FALSE";

	if (!empty($message['message'])) {
		$content = $message['message']['text'];
	}

	if (!empty($content)) {
		$gotContent = strtolower(remove_accents(remove_emoji($content)));
	}

	if (!empty($message['postback'])) {
		$payload = $message['postback']['payload'];
	}

	$current .= "------------------------------\n";
	$current .= "[New input - ". date('H').":".date('i').":".date('s') ." - " .$sender."] RawContent:: ".$content." | gotContent:: ".$gotContent." | payload:: ".$payload."\n";
	$current .= "------------------------------\n";

	// var_dump($current);
	file_put_contents($file, $current);

}


function getBadWordAnswers($string=""){

	return array(
		'-1',
		'Nous sommes beaucoup trop polis pour vous répondre',
		'Take it easy',
		"Ce n'est pas le bon endroit pour ça",
		);
}

function haveBadWords($string=""){
	if (empty($string)) {
		return false;
	}

	$badWordsArray = array(
		'3asba',
		'zib',
		'zibbi',
		'ziby',
		'zibby',
		'nayek',
		'nayik',
		'nayyik',
		'nayyek',
		'nayek',
		'nayik',
		'nayyik',
		'nayyek',
		'nik',
		);

	$haveBadWords = false;
	foreach ($badWordsArray as $bad) {
		if (strpos($string, $bad) !== false) {
			$haveBadWords = true;
		}
	}

	return $haveBadWords;
}


function typing(){
	global $bot;
	global $message;

	$bot->send(new SenderAction($message['sender']['id'], SenderAction::ACTION_TYPING_ON));
}


