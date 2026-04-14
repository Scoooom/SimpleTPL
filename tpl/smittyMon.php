<?php
$loggedIn = true;
if ($loggedIn == true) {
function getTypeEn($id) {
	switch ($id) {
		case 0:
		  return "Normal";
		  break;
		case 1:
		  return "Fighting";
		  break;
		case 2:
		  return "Flying";
		  break;
		case 3:
		  return "Poison";
		  break;
		case 4:
		  return "Ground";
		  break;
		case 5:
		  return "Rock";
		  break;
		case 6:
		  return "Bug";
		  break;
		case 7:
		  return "Ghost";
		  break;
		case 8:
		  return "Steel";
		  break;
		case 9:
		  return "Fire";
		  break;
		case 10:
		  return "Water";
		  break;
		case 11:
		  return "Grass";
		  break;
		case 12:
		  return "Electric";
		  break;
		case 13:
		  return "Psychic";
		  break;
		case 14:
		  return "Ice";
		  break;
		case 15:
		  return "Dragon";
		  break;
		case 16:
		  return "Dark";
		  break;
		case 17:
		  return "Fairy";
		  break;
	}
}
$lowerName = strtolower($_GET['form']);

$mon = \Glitches\BuiltIn::LoadSmitty($lowerName);

//$rivals = $mon->getRivals(true);
$mon2 = $mon;
//json_decode($mon->json_data);
$img =  "https://void.scooom.xyz/cFront:".$mon->name.".png";
$back = "https://void.scooom.xyz/cBack:".$mon->name.".png";
$name = $mon->name;
$code = trim(`/usr/local/bin/getFormCode {$name} | gawk -F"\"" '{print $4}'`,"\n");

$typeOne = $mon2->type1;
$typeTwo = $mon2->type2;
    $og = explode(",",$mon2->ogMon);
	$mons = "";
	foreach($og as $ogMonId) {
		$ogMon = \Pokemon\Pokemon::getMon($ogMonId);
        $mons .= ucwords(str_replace("-",' ',$ogMon->name)).", ";
	}
$ogMon = trim(trim($mons),",");

$ogStats = array();

$mons = ucwords($ogMon);
/* 
foreach($ogMon->stats as $stat) {
	$indice = 0;
	$statName = $stat->stat->name;
	switch($statName) {
		case 'hp':
		  $indice = 0;
		  break;
		case 'attack':
		  $indice = 1;
		  break;
		case 'defense':
		  $indice = 2;
		  break;
		case 'special-attack':
		  $indice = 3;
		  break;
		case 'special-defense':
		  $indice = 4;
		  break;
		case 'speed':
		  $indice = 5;
		  break;
	}
	$ogStats[$indice] = ["value"=>$stat->base_stat,"percent"=>floor(($stat->base_stat / 255)*100)];
}
*/
//$ogStats = $mon->getOGStats(); 
// WOn't be showing this



//$ogBST = $ogStats[0]['value'] + $ogStats[1]['value'] + $ogStats[2]['value'] + $ogStats[3]['value'] + $ogStats[4]['value'] + $ogStats[5]['value'];
//$boostedStats = $mon->adjustStats($ogStats,$mon->calculateTotalIncrease($ogBST));

//$newBST = $boostedStats[0]['value'] + $boostedStats[1]['value'] + $boostedStats[2]['value'] + $boostedStats[3]['value'] + $boostedStats[4]['value'] + $boostedStats[5]['value'];

//$boostedBST = $newBST;
/*
$statBalance = $mon->getStatBoostEn();
$abilityOne = $mon->getAbilityOne();
$abilityTwo = $mon->getAbilityTwo();
$rating = $mon->getRating();
$abilityHA = $mon->getAbilityHA();
*/
$customTitle = $name;//." | ".$user->username;
$t1 = getTypeEn($typeOne);
$t2 = getTypeEn($typeTwo);
$abilityOne = $mon->ab1;
$abilityTwo = $mon->ab2;
$abilityHA = $mon->ha;
$items = \Glitches\BuiltIn::getSmittyItems($name);
if ($items === false) $items = "Unknown! Please contact ".DTAG." on discord!";
else $items = implode(", ",$items);

$desc = $name.'; Primary '.$t1."; Secondary: {$t2}; Ability 1: ".$abilityOne->name."; Ability 2: ".$abilityTwo->name."; HA: ".$abilityHA->name."; Requires: ".$items;
$url = "https://".$_SERVER["HTTP_HOST"]	. $_SERVER['REQUEST_URI'];
$imgurl = "https://void.scooom.xyz/cFront:".$name.".png";
$extraHead = <<<end
<meta property="og:type" content="website">
<meta property="og:url" content="{$url}">
<meta property="og:title" content="{$customTitle}">
<meta property="og:description" content="{$desc}">
<meta property="og:image" content="{$imgurl}">
end;
define('extraHead',$extraHead);
define('CustomTitle',$customTitle);
$typeTwoImg = '<img src="/img/types/'.$typeTwo.'.png"/>';
	if (empty($mon2->type2)) 
		$typeTwoImg = '';
$__output = <<<end
<section>


    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <img src="{$img}" alt="avatar"
              class="rounded-circle img-fluid" style="width: 150px;">
            <img src="{$back}" alt="avatar"
              class="rounded-circle img-fluid" style="width: 150px;">
			  

			  
            <h5 class="my-3">{$name} ({$code})</h5>

            <div class="d-flex justify-content-center mb-2">
              <img src="/img/types/{$typeOne}.png" />
			  {$typeTwoImg}
            </div>

end;

$hpPer = floor(($mon->hp / 255)*100);
$atkPer = floor(($mon->atk / 255)*100);
$defPer = floor(($mon->def / 255)*100);
$spatkPer = floor(($mon->spatk / 255)*100);
$spdefPer = floor(($mon->spdef / 255)*100);
$spdPer = floor(($mon->spd / 255)*100);
$ab1 = collapse($abilityOne->name,"<small class='text-muted'>".$abilityOne->description."</small>");
$ab2 = collapse($abilityTwo->name,"<small class='text-muted'>".$abilityTwo->description."</small>");
$ha = collapse($abilityHA->name,"<small class='text-muted'>".$abilityHA->description."</small>");
$__output .= <<<end

          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">

            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Ability One</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{$ab1}</p>
              </div>
            </div>
            <hr>

            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Ability Two</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{$ab2}</p>
              </div>
            </div>
            <hr>

            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Hidden Ability</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{$ha}</p>
              </div>
            </div>
            <hr>

            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">SMITTY Items</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{$items}</p>
              </div>
            </div>
            <hr>
			
			


          </div>
        </div>

		<div class="row">
          <div class="col-md">
            <div class="card mb-4 mb-md-0">
              <div class="card-body">
                <p class="mb-4"><span class="text-primary font-italic me-1">glitched </span> Stats <small>BST {$mon->bst}</small>
                </p>
end;
$k12 = <<<end
                <p class="mb-1" style="font-size: .77rem;">HP <small>{$mon->hp}</small></p>
                <div class="progress rounded" style="height: 5px;">
                  <div class="progress-bar" role="progressbar" style="width: {$hpPer}%" aria-valuenow="{$mon->hp}"
                    aria-valuemin="0" aria-valuemax="255"></div>
                </div>
                <p class="mt-4 mb-1" style="font-size: .77rem;">Attack <small>{$mon->atk}</small></p>
                <div class="progress rounded" style="height: 5px;">
                  <div class="progress-bar" role="progressbar" style="width: {$atkPer}%" aria-valuenow="{$mon->atk}"
                    aria-valuemin="0" aria-valuemax="255"></div>
                </div>
                <p class="mt-4 mb-1" style="font-size: .77rem;">Defense <small>{$mon->def}</small></p>
                <div class="progress rounded" style="height: 5px;">
                  <div class="progress-bar" role="progressbar" style="width: {$defPer}%" aria-valuenow="{$mon->def}"
                    aria-valuemin="0" aria-valuemax="255"></div>
                </div>
                <p class="mt-4 mb-1" style="font-size: .77rem;">Special Attack <small>{$mon->spatk}</small></p>
                <div class="progress rounded" style="height: 5px;">
                  <div class="progress-bar" role="progressbar" style="width: {$spatkPer}%" aria-valuenow="{$mon->spatk}"
                    aria-valuemin="0" aria-valuemax="255"></div>
                </div>
                <p class="mt-4 mb-1" style="font-size: .77rem;">Special Defense <small>{$mon->spdef}</small></p>
                <div class="progress rounded" style="height: 5px;">
                  <div class="progress-bar" role="progressbar" style="width: {$spdefPer}%" aria-valuenow="{$mon->spdef}"
                    aria-valuemin="0" aria-valuemax="255"></div>
                </div>
                <p class="mt-4 mb-1" style="font-size: .77rem;">Speed <small>{$mon->spd}</small></p>
                <div class="progress rounded" style="height: 5px;">
                  <div class="progress-bar" role="progressbar" style="width: {$spdPer}%" aria-valuenow="{$mon->spd}"
                    aria-valuemin="0" aria-valuemax="255"></div>
                </div>
end;
$__output .= collapse("View Stats",$k12);
$__output .= <<<end
              </div>
            </div>
          </div>
	  </div>
        
		  </div> 
	  
    </div>
  </div>
</section>
end;
}
