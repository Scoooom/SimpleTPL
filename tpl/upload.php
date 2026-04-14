<?php
if (!\Discord2\User::isLoggedIn()) {
	redirect("/index.html");
	die;
}
$filename = $_FILES['pokeData']['tmp_name'];
$filetype = $_FILES['pokeData']['type'];
$filesize = $_FILES['pokeData']['size'];
$ERR = null;
if ($filesize > 300000) { // Less than 300kb
	$ERR .= "<h3>File size too big. Please try again!</h3>";
}
if ($filetype != "application/json") {
	$ERR .= "<h3>Corrupt file. Please try again!</h3>";
}
if (!is_null($ERR)) {
	include "create.php";
} else {
	$glitch_raw = file_get_contents($filename);
	
	$glitch = json_decode($glitch_raw);
	$sprites = $glitch->sprites;
	//unset($glitch->sprites);
	$glitch_raw = json_encode($glitch);

	try {
		$checkExist = \Glitches\Glitch::LoadBy(["name"=>$glitch->formName])[0];
		$user = new \Users\Users($checkExist->created_by);
		$ERR .= "<h3>This Glitch is already uploaded by ".$user->getLink()."!</h3>";
		include "create.php";
	} catch  (\Exceptions\ItemNotFound $e) {
	    $newGlitch = new \Glitches\Glitch();
		$owner = \Users\Users::getUser();
		$newGlitch->json_data = $glitch_raw;
		$newGlitch->created_by = $owner->id;
		$newGlitch->name = $glitch->formName;
		$newGlitch->front = $sprites->front;
		$newGlitch->back = $sprites->back;
		$newGlitch->icon = $sprites->icon;
		$newGlitch->filename = $_FILES['pokeData']['name'];
		
		$newGlitch->Save();
		redirect("/g:".$glitch->formName.":".$newGlitch->id.".html");
		die;
	}
}
//phpinfo();
