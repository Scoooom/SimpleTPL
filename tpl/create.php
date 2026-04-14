<?php
if (!\Discord2\User::isLoggedIn()) {
	redirect("/index.html");
	die;
}
$__output .= <<<end
<h1>Upload a glitch to share!</h1>
<form action="upload.html" method="post" enctype="multipart/form-data">
<div class="custom-file">
  <input type="file" class="custom-file-input" name="pokeData" id="customFile">
  <label class="custom-file-label" for="customFile">Choose file</label>
    <button type="submit" class="btn btn-primary">Submit</button>
	
</div>
</form> 
end;
if (!is_null($ERR))
	$__output .= $ERR;
