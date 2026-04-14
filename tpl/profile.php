<?php
$user = \Discord2\User::getUsername();
if (isset($_GET['username'])) $user = $_GET['username'];
define('ALLOW_EDITS',($user == \Discord2\User::getUsername() || \Discord2\User::getUsername() == "scooom"));
$u = \Users\Users::getUser($user);

define('UPDATE_SAVE',(isset($_POST['action'])));
define('DEBUG_SAVE',0);

if (ALLOW_EDITS && isset($_REQUEST['action'])) {
	if ($_POST['action'] == 'uploadNew') {
		$filename = $_FILES['saveFile']['tmp_name'];
                $raw = (isset($_COOKIE['viewRAW']));
		$decrypt = \PRSV\PRSV::decrypt($filename,$raw);
                if (!isset($_COOKIE['viewRAW'])) {
		  $u->raw_prsv = file_get_contents($filename);
		  $u->b64_prsv = base64_encode(json_encode($decrypt));
  		  $u->Save();
                }
		if (isset($_COOKIE['viewRAW'])) {
                  header("Content-type: text/plain");
                  die($decrypt);
                }
		define("greenAlert","Save File Uploaded");
	} else 	if ($_POST['action'] == 'delSave') {
		$u->raw_prsv = NULL;
		$u->b64_prsv = NULL;
		$u->Save();
		define("greenAlert","Save File Deleted");
	} else 	if ($_REQUEST['action'] == 'dlSave') {
		header("Content-type: text/plain");
		header("Content-Description: File Transfer"); 
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"".$u->username.".prsv\"");
        die($u->raw_prsv);
	} else if ($_REQUEST['action'] == 'raw') {
		$save = $u->getSave();
		$__output = code(print_r($save->getSystemData(),1));
		return;
	}
}



if (ALLOW_EDITS && DEBUG_SAVE) {
        $sav = $u->getSave();
	die(code(print_r($sav->getDefeatedRivals(),1)));
}

$img = $u->getAvatarURL();
$likes = 0; // Temp, TODO: implement liking users and mods
$likes = \Ratings\UserLikes::get($u->id);
//die(code(print_r($likes,1)));
$uploaded = $u->getUploadCount(); // Temp, TODO: implement uploaded total
$uploadedText = "$uploaded";
if ($uploaded == 0) {
	$uploadedText = "None";
}
$creatorID = $u->id;
$name = $u->username;
$join = date("F j, Y",$u->join_date);
$lastLogin = date("F j, Y, g:i a",$u->last_login);

$alert = "";
if (defined("greenAlert"))
	$alert .= '<div class="alert alert-success" role="alert">'.greenAlert.'</div>';
$__output = <<<end
<section >
{$alert}
    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <img src="{$img}" alt="avatar"
              class="rounded-circle img-fluid" style="width: 150px;">
            <h5 class="my-3">{$name}</h5>
end;

$likeForm = <<<end
			  <form action="/uLike:{$creatorID}.html" method="post" /><input type="hidden" name="returnURL" value="{$_SERVER['REQUEST_URI']}" />
			    <input  type="submit" data-mdb-button-init  data-mdb-ripple-init value="Like" class="btn btn-success" />
			  </form>
			  &nbsp;
end;

$unlikeForm = <<<end

			  <form action="/uRLike:{$creatorID}.html" method="post"  /><input type="hidden" name="returnURL" value="{$_SERVER['REQUEST_URI']}" />
			    <input  type="submit" data-mdb-button-init data-mdb-ripple-init value="Remove Like" class="btn btn-success" />
			  </form>
			  &nbsp;
end;

$trainerCard = <<<end

			  <form action="/trainercard:{$name}.html" method="get"  />
			    <input  type="submit" data-mdb-button-init data-mdb-ripple-init value="Trainer Card" class="btn btn-success" />
			  </form>
			  &nbsp;
end;


if (\Discord2\User::isLoggedIn()) {
	$curUser = \Users\Users::getUser();

	$__output .= '			<div class="d-flex justify-content-center mb-2">';
	if ($curUser->likesUser($u->id)) {
		$__output .= $unlikeForm;
	} else {
		$__output .= $likeForm;
	}
	if (ALLOW_EDITS) {
		$txt = ($curUser->b64_prsv != NULL && $curUser->raw_prsv != NULL) ? "Update Save" : "Upload Save File";
			$uploadForm = <<<end
			<br />
<form action="/u:{$curUser->username}.html" method="post" enctype="multipart/form-data" /><input type="hidden" name="action" value="uploadNew" />
<div class="custom-file">
  <input type="file" class="custom-file-input" value="Select File" name="saveFile" id="customFile">
  <br /><label class="custom-file-label" for="customFile">{$txt}</label>    <input type="submit" class="btn btn-primary" value="Submit" />
	
</div>
			  </form>
			  
			  &nbsp;
			  
end;
			$__output .= "</div><div class='d-flex justify-content-center mb-2'>".collapse($txt,$uploadForm);
		if ($curUser->b64_prsv != NULL && $curUser->raw_prsv != NULL) {

			$__output .= <<<end
			</div><div>
			  <form action="/u:{$curUser->username}.html" method="post"  /><input type="hidden" name="action" value="delSave" />
			    <input  type="submit" data-mdb-button-init data-mdb-ripple-init value="Delete Save File" class="btn btn-danger" />
			  </form>
			  &nbsp;
			  
			
			  <form action="/u:{$curUser->username}.html" method="post"  /><input type="hidden" name="action" value="dlSave" />
			    <input  type="submit" data-mdb-button-init data-mdb-ripple-init value="Download Save File" class="btn btn-info" />
			  </form>
			  &nbsp;
			  
end;
		}
	}
	$__output .= "</div>";
}
if (($u->b64_prsv != NULL && $u->raw_prsv != NULL)) $__output .= $trainerCard;
$__output .= <<<end

          </div>
        </div>
        
      </div>
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Discord User</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{$name}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Likes</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{$likes}</p>
              </div>
            </div>
            <hr>
 
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Uploaded Glitches</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{$uploadedText}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Join Date</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{$join}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Last Login</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{$lastLogin}</p>
              </div>
            </div>
			
          </div>
        </div>
        
      </div>
    </div>
  </div>
</section>

end;


$k = <<<end
<tr>
      <th scope="row"><img src="%%front%%" alt="avatar"
              class="rounded-circle img-fluid" style="width: 64px;"></th>
      <td>%%name%%</td>
      <td>%%rating%%</td>
      <td>%%ogMon%%</td>
      <td><img src="/img/types/%%tOne%%.png" /></td>
      <td><img src="/img/types/%%tTwo%%.png" /></td>
	  <td><form action="/g:%%lname%%:%%id%%.html"><input class="form-control" type="submit" value="View"  /></form></td>
    </tr>
end;

try {
	$glitches = \Glitches\Glitch::LoadBy(["created_by"=>$u->id]);
	$__output .= <<<end
<table class="table table-striped table-dark" id="galleryMons">
  <thead>
    <tr>
      <th scope="col">Sprite</th>
      <th scope="col">Name</th>
	  <th scope="col">Rating</th>
	  <th scope="col">Base Pokemon</th>
      <th scope="col">Primary Type</th>
	  <th scope="col">Secondary Type</th>
	  <th scope="col">View</th>
    </tr>
  </thead>
  <tbody>
end;
	foreach($glitches as $glitch) {
		$mon2 = json_decode($glitch->json_data);
		$user = new \Users\Users($glitch->created_by);
		$typeOne = $mon2->primaryType;
		$typeTwo = $mon2->secondaryType;

		$ogMon = \Pokemon\Pokemon::getMon($mon2->speciesId);
                $tmp = str_replace("%%lname%%",urlencode(str_replace(" ","",$glitch->name)),$k);
		$tmp = str_replace("%%name%%",trim($glitch->name),$tmp);

		$tmp = str_replace("%%front%%",$glitch->front,$tmp);
		$tmp = str_replace("%%rating%%",$glitch->getRating(),$tmp);
		$tmp = str_replace("%%tOne%%",$typeOne,$tmp);
                $tmp = str_replace("%%id%%",$glitch->id,$tmp);

		$tmp = str_replace("%%tTwo%%",$typeTwo,$tmp);
		$tmp = str_replace("%%ogMon%%",ucwords(str_replace("-",' ',$ogMon->name)),$tmp);
		$__output .= $tmp;
	}
	$__output .= <<<end
</tbody>
</table>

<script type="text/javascript">
/* */
  $(document).ready(function() {
    $("#galleryMons").DataTable({
	  "paging": 1,
	  "stateSave": 0,
	  "searching": 1,
      "order": [[ 2, "desc" ]]
    });
  });
/* */
</script>  
<style type="text/css">
table.dataTable tbody tr {
    background-color: #343a40;
}
</style>
end;
} catch  (\Exceptions\ItemNotFound $e) {}
