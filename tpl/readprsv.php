<?php

$loggedIn = false;
if (\Discord2\User::isLoggedIn()) {
  $user = \Users\Users::getUser();
  //if ($user->username == "scooom")
  $loggedIn = true;
}
if (!$loggedIn) {
  include "404.php";
  return;
}
define('STORED',0);
if (!isset($_POST['uploadSave']) && !STORED) {
$__output .= <<<end
<h1>Upload a glitch to share!</h1>
<form action="readprsv.html" method="post" enctype="multipart/form-data">
<div class="custom-file">
  <input type="file" class="custom-file-input" name="pokeData" id="customFile">
  <input type="hidden" class="custom-file-input" name="uploadSave" id="customFile">
  <label class="custom-file-label" for="customFile">Choose file</label>
    <button type="submit" class="btn btn-primary">Submit</button>
	
</div>
</form> 
end;
  if (!is_null($ERR))
	$__output .= $ERR;
  return;
}
$filename = $_FILES['pokeData']['tmp_name'];
if (STORED)
  $filename = "/var/www/void.scooom.xyz/tpl/save.prsv";

$user = \Users\Users::getUser();
$user->prsv = file_get_contents($filename);
$user->Save();


$save = $user->getSave();
/* */

$file = $filename;//
header("Content-type: text/plain");
$file = new PRSV\PRSV($file);

/* */
$data = $save->getDefeatedRivals();


die(print_r($data,1));
