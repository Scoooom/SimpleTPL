<?php
$user = \Users\Users::getUser($_GET['id']);
if ($user === false) {
	$__output = "<small>Trainer Card Error [0001]<br />Please DM ".DTAG."on Discord if you encoutered this page in error.</small>"; // No Trainer On file
	return;
}
$save = $user->getSave();
if ($_GET['l'] ==  '1') die(code(print_r($save->getSystemData(),1)));
$__output = <<<end
<section >
<style type="text/css">
img.gray {
  filter: gray; /* IE6-9 */
  -webkit-filter: grayscale(1); /* Google Chrome, Safari 6+ & Opera 15+ */
  filter: grayscale(1); /* Microsoft Edge and Firefox 35+ */
}
.overlayIMG {
  position: absolute;
  bottom: 0px;
  right: 0px;
  opacity: 0.15;
}

p.overlayIMG {
  font-size: 2vw; 
  opacity: 1;
  color: black !important;
}

div.rivalImg {
  position: relative;
  overflow: hidden;
  width: 75px;
  height: 75px;
  display: block;
}

p.rivalName {
  left: -20%;
  position: relative;
}
</style>
{$alert}
    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <img src="{$user->getAvatarURL()}" alt="avatar"
              class="rounded-circle img-fluid" style="width: 150px;">
            <h5 class="my-3">{$user->username}</h5>
		  </div>
		</div>
	  </div>
      <div class="col-lg">
        <div class="card mb	">
          <div class="card-body text-center">
		  <h3>Rivals Defeated</h3>
			<div class="row">
			
end;

$rival = $save->getDefeatedRivals();
for ($i = 0; $i<28; $i++) {	
    $newLine = ($i % 7 == 0);
	if ($newLine && $i != 0) $__output .= "\n          </div>\n          <div class='row'>";
	$gray = ($rival[$i]['defeated'] === 'true') ? "" : " gray";
	$imgURL = ($rival[$i]['defeated'] === 'true') ? '<img class="overlayIMG rounded-circle img-fluid" style="width: 100%; height: 100%;" src="/img/green.png" />' : '<img class="overlayIMG rounded-circle img-fluid" style="width: 100%; height: 100%;" src="/img/red.png" />';

    $tpl = <<<end
	  
            <div class="col text-center">
              <div class="row rivalImg">
			    <img class="rounded-circle img-fluid " style="height: 75px; width: 75px; background-color: gray" src='/rivals/{%%rname%%}.png'/>
				{$imgURL}
			  </div>
			  <p class="rivalName">{%%rnameN%%}</p>

            </div>
end;
	// $__output .= "\n\t\t\t  <li>\n\t\t\t    <table class='table table-dark table-sm'>\n\t\t\t      <tr>\n\t\t\t        <td colspan='3' style='text-align: left'>".$rival[$i]['name']."</td>\n\t\t\t        <td colspan='1'><img src='".$imgURL."'/></td>\n\t\t\t      </tr>\n\t\t\t    </table>\n\t\t\t  </li>";	
	$__output .= str_replace("{%%rname%%}",str_replace(" ","_",strtolower($rival[$i]['name'])),str_replace("{%%rnameN%%}",$rival[$i]['name'],$tpl));
	
}

$__output .= <<<end

		  </div>
		</div>
	  </div>
	</div>
  </div>
end;

// Unlock Core Glitch Forms
$d = $save->getGlitchUnlocks();
$__output .= <<<end

  <!-- Start Core Glitch Unlocked -->
  <div>&nbsp;</div>
  <div class="row">
	<div class="col-lg-4"></div>
	<div class="col-lg">
      <div class="card mb">
        <div class="card-body text-center"><h3>Unlocked Core Glitch</h3>
          <div class="row">
end;
$counterForms = 1;
foreach($d as $un) {
	try {
	  $tpl = <<<end
	  
            <div class="col">
              <img class="rounded-circle img-fluid" style="max-height: 150px; background-color: gray" src='/cFront:{%%gname%%}.png'/>
              <br />
              <a href='/core:{%%gname%%}.html'>{%%gnameraw%%}</a>
            </div>
end;
      $tpl = str_replace("{%%gid%%}",$un->id,$tpl);
	  $tpl = str_replace("{%%gname%%}",urlencode($un->name),$tpl);
	  $tpl = str_replace("{%%gnameraw%%}",($un->name),$tpl);
	  $__output .= $tpl;
	  $counterForms++;; 
	  if ($counterForms == 5) {
        $__output .= "\n          </div>\n          <div class='row'>";
		$counterForms = 1;
	  }

	  
	} catch (\Exceptions\ItemNotFound $e){}
}

$__output .= <<<end

          </div>
		</div>
      </div>
    </div>
  </div>
  <!-- End Core Glitch Unlocked -->
end;
// End Core Glitch Forms

// Unlock Glitch Forms
$d = $save->getFormUnlocks();
$__output .= <<<end

  <!-- Start Mods Unlocked -->
  <div>&nbsp;</div>
  <div class="row">
	<div class="col-lg-4"></div>
	<div class="col-lg">
      <div class="card mb">
        <div class="card-body text-center"><h3>Unlocked ModGlitches</h3>
          <div class="row">
end;
$counterForms = 1;
foreach($d['modFormsUnlocked'] as $unlock) {
	try {
	  $name = preg_replace("/(.*)_(.*)/","$2",$unlock);
	  $name = str_replace(" ","",$name);
	  $un = \Glitches\Glitch::getGlitch($name);


	  $tpl = <<<end
	  
            <div class="col">
              <img class="rounded-circle img-fluid" style="max-height: 150px; background-color: gray" src='/front:{%%gid%%}.png'/>
              <br />
              <a href='/g:{%%gname%%}:{%%gid%%}.html'>{%%gnameraw%%}</a>
            </div>
end;
      $tpl = str_replace("{%%gid%%}",$un->id,$tpl);
	  $tpl = str_replace("{%%gname%%}",urlencode($un->name),$tpl);
	  $tpl = str_replace("{%%gnameraw%%}",($un->name),$tpl);
	  $__output .= $tpl;
	  $counterForms++;; 
	  if ($counterForms == 5) {
        $__output .= "\n          </div>\n          <div class='row'>";
		$counterForms = 1;
	  }

	  
	} catch (\Exceptions\ItemNotFound $e){}
}

$__output .= <<<end

          </div>
		</div>
      </div>
    </div>
  </div>
  <!-- End Mods Unlocked -->
end;
// End Unlock Glitch Forms

// Start Smitty Forms
$d = $save->getSmittyUnlocks();
$__output .= <<<end

  <!-- Start Smitty Forms -->
  <div>&nbsp;</div>
  <div class="row">
	<div class="col-lg-4"></div>
	<div class="col-lg">
      <div class="card mb">
        <div class="card-body text-center"><h3>Unlocked Smitty Forms</h3>
          <div class="row">
end;
$counterForms = 1;
foreach($d as $un) {
	try {
	  $tpl = <<<end
	        <!--
{%%raw%%}
            -->
            <div class="col">
              <img class="rounded-circle img-fluid" style="max-height: 150px; background-color: gray" src='/cFront:{%%gname%%}.png'/>
              <br />
              <a href='/smittyForm:{%%gname%%}.html'>{%%gnameraw%%}</a>
            </div>
end;
      $tpl = str_replace("{%%gid%%}",$un->id,$tpl);
	  $tpl = str_replace("{%%gname%%}",urlencode($un->name),$tpl);
	  $tpl = str_replace("{%%gnameraw%%}",($un->name),$tpl);
	  $tpl = str_replace("{%%raw%%}",print_r($un,1),$tpl);
	  $__output .= $tpl;
	  $counterForms++;; 
	  if ($counterForms == 5) {
        $__output .= "\n          </div>\n          <div class='row'>";
		$counterForms = 1;
	  }

	  
	} catch (\Exceptions\ItemNotFound $e){}
}

$__output .= <<<end

          </div>
		</div>
      </div>
    </div>
  </div>
  <!-- End Smitty Forms Unlocked -->
end;
// End Smitty Forms

// Unlock Smitty Universal Forms
$d = $save->getFormUnlocks();
$__output .= <<<end

  <!-- Start Smitty UniForm Unlocked -->
  <div>&nbsp;</div>
  <div class="row">
	<div class="col-lg-4"></div>
	<div class="col-lg">
      <div class="card mb">
        <div class="card-body text-center"><h3>Unlocked UniSMITTY Forms</h3>
          <div class="row">
end;
$counter = 0;
echo "<!-- KKK \n".print_r($d['uniSmittyUnlocks'],1)."\n\n-->";
foreach($d['uniSmittyUnlocks'] as $unlock) {
	if (empty($unlock)) continue;
	try {
	  $name = preg_replace("/(.*?)_(.*)/","$2",$unlock);
	  $name = str_replace(" ","",$name);
	  $un = \Glitches\BuiltIn::LoadSmitty($name);
	  $tpl = <<<end
	        <!--
{%%raw%%}
            -->
            <div class="col">
              <img class="rounded-circle img-fluid" style="max-height: 150px" background-color: gray" src='/cFront:{%%name%%}.png'/>
              <br />
              <a href='/smitty:{%%name%%}.html'>{%%name%%}</a>
            </div>
end;
      $tpl = str_replace("{%%name%%}",$un->name,$tpl);
	  $tpl = str_replace("{%%raw%%}",print_r($un,1),$tpl);

	  $__output .= $tpl;
	  $counter++;; 
	  if ($counter == 5) {
        $__output .= "\n          </div>\n          <div class='row'>";
		$counter = 1;
	  }
//	  	$__output .= "\n\t\t\t  <li style=\"style='list-style-type: none;\"><img ".'class="rounded-circle img-fluid" style="max-width: 150px;max-height: 150px; background-color: gray" '."src='/cFront:".$un->name.".png'/><br /><a href='/smitty:".$un->name.".html'>".$un->name."</a></li>";	
	} catch (\Exceptions\ItemNotFound $e){}
  	$counter++; 
}

$__output .= <<<end

          </div>
		</div>
      </div>
    </div>
  </div>
  <!-- End Smitty UniForm Unlocked -->
end;
// End Unlock Smitty Universal Forms



//$__output = code(print_r($save,1));
