<?php
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
$mon = new \Glitches\Glitch($_GET['id']);
$rivals = $mon->getRivals(true);
$mon2 = json_decode($mon->json_data);
$img = "/front:".$mon->id.".png";//$mon->front;
$back = "/back:".$mon->id.".png";//$mon->back;
$name = $mon->name;
$typeOne = $mon2->primaryType;
$typeTwo = $mon2->secondaryType;
$ogMon = $mon->getOGMon();
$ogStats = array();

	$user = new \Users\Users($mon->created_by);
	$userLink = $user->getLink();
unset($ogMon->moves);
unset($ogMon->game_indices);
unset($ogMon->held_items);
unset($ogMon->past_abilities);
$ogMon->name = ucwords($ogMon->name);
$glitchID = $mon->id;
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
$ogStats = $mon->getOGStats();



$ogBST = $ogStats[0]['value'] + $ogStats[1]['value'] + $ogStats[2]['value'] + $ogStats[3]['value'] + $ogStats[4]['value'] + $ogStats[5]['value'];
$boostedStats = $mon->adjustStats($ogStats,$mon->calculateTotalIncrease($ogBST));

$newBST = $boostedStats[0]['value'] + $boostedStats[1]['value'] + $boostedStats[2]['value'] + $boostedStats[3]['value'] + $boostedStats[4]['value'] + $boostedStats[5]['value'];

$boostedBST = $newBST;

$statBalance = $mon->getStatBoostEn();
$abilityOne = $mon->getAbilityOne();
$abilityTwo = $mon->getAbilityTwo();
$rating = $mon->getRating();
$abilityHA = $mon->getAbilityHA();
$customTitle = $name." | ".$user->username;
$t1 = getTypeEn($typeOne);
$t2 = getTypeEn($typeTwo);

$desc = $name.'; Primary '.$t1."; Secondary: {$t2}; Ability 1: ".$abilityOne["name"]."; Ability 2: ".$abilityTwo["name"]."; HA: ".$abilityHA["name"]."; Glitch of ".$ogMon->name.".; Rivals: ".$rivals;
$url = "https://".$_SERVER["HTTP_HOST"]	. $_SERVER['REQUEST_URI'];
$imgurl = "https://void.scooom.xyz/front:".$mon->id.".png";
$extraHead = <<<end
<meta property="og:type" content="website">
<meta property="og:url" content="{$url}">
<meta property="og:title" content="{$customTitle}">
<meta property="og:description" content="{$desc}">
<meta property="og:image" content="{$imgurl}">
end;
define('extraHead',$extraHead);
define('CustomTitle',$customTitle);

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
			  

			  
            <h5 class="my-3">{$name}</h5>
			<p class="text-muted mb-1">Created By: {$userLink}</p>

            <div class="d-flex justify-content-center mb-2">
              <img src="/img/types/{$typeOne}.png" />
              <img src="/img/types/{$typeTwo}.png"/>
            </div>
			<div class="d-flex justify-content-center mb-2">
			<form action="/d:{$glitchID}.html" />
			<input  type="submit" data-mdb-button-init data-mdb-ripple-init value="Download" class="btn btn-primary" /></form>
			&nbsp;
			
			<button type="button" class="btn btn-secondary">Rating: {$rating}</button>
</div>

end;

$likeForm = <<<end
			  <form action="/like:{$glitchID}.html" method="post" /><input type="hidden" name="returnURL" value="{$_SERVER['REQUEST_URI']}" />
			    <input  type="submit" data-mdb-button-init  data-mdb-ripple-init value="Like" class="btn btn-success" />
			  </form>
			  &nbsp;
end;

$dislikeForm = <<<end

			  <form action="/dislike:{$glitchID}.html" method="post"  /><input type="hidden" name="returnURL" value="{$_SERVER['REQUEST_URI']}" />
			    <input  type="submit" data-mdb-button-init data-mdb-ripple-init value="Dislike" class="btn btn-danger" />
			  </form>
			  &nbsp;
end;
$dislikeForm = '';
$unlikeForm = <<<end

			  <form action="/rLike:{$glitchID}.html" method="post"  /><input type="hidden" name="returnURL" value="{$_SERVER['REQUEST_URI']}" />
			    <input  type="submit" data-mdb-button-init data-mdb-ripple-init value="Remove Like" class="btn btn-success" />
			  </form>
			  &nbsp;
end;

$undislikeForm = <<<end

			  <form action="/rDislike:{$glitchID}.html"  method="post" /><input type="hidden" name="returnURL" value="{$_SERVER['REQUEST_URI']}" />
			    <input  type="submit" data-mdb-button-init data-mdb-ripple-init value="Remove Dislike" class="btn btn-danger" />
			  </form>
			  &nbsp;
end;
$undislikeForm = '';
/* */
if (\Discord2\User::isLoggedIn()) {
	$__output .= '			<div class="d-flex justify-content-center mb-2">';
	if ($user->likesGlitch($mon->id)) {
		$__output .= $unlikeForm;
	} else {
		$__output .= $likeForm;
	}

	if ($user->dislikesGlitch($mon->id)) {
		$__output .= $undislikeForm;
	} else {
		$__output .= $dislikeForm;
	}
	
	$__output .= "</div>";
}
/* */
$ab1 = collapse($abilityOne["name"],"<small class='text-muted'>".$abilityOne['desc']."</small>");
$ab2 = collapse($abilityTwo["name"],"<small class='text-muted'>".$abilityTwo['desc']."</small>");
$ha = collapse($abilityHA["name"],"<small class='text-muted'>".$abilityHA['desc']."</small>");

$__output .= <<<end

          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Glitched Pokemon</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{$ogMon->name}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Stat Spread Type</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{$statBalance}</p>
              </div>
            </div>
            <hr>
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
                <p class="mb-0">Rivals</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{$rivals}</small></p>
              </div>
            </div>
            <hr>


          </div>
        </div>

		<div class="row">
          <div class="col-md">
            <div class="card mb-4 mb-md-0">
              <div class="card-body">
                <p class="mb-4"><span class="text-primary font-italic me-1">boosted </span> Stats <small>BST {$boostedBST}</small>
                </p>
end;

$i12 = <<<end
                <p class="mb-1" style="font-size: .77rem;">HP <small>{$boostedStats[0]['value']}</small></p>
                <div class="progress rounded" style="height: 5px;">
                  <div class="progress-bar" role="progressbar" style="width: {$boostedStats[0]['percent']}%" aria-valuenow="{$boostedStats[0]['value']}"
                    aria-valuemin="0" aria-valuemax="255"></div>
                </div>
                <p class="mt-4 mb-1" style="font-size: .77rem;">Attack <small>{$boostedStats[1]['value']}</small></p>
                <div class="progress rounded" style="height: 5px;">
                  <div class="progress-bar" role="progressbar" style="width: {$boostedStats[1]['percent']}%" aria-valuenow="{$boostedStats[1]['value']}"
                    aria-valuemin="0" aria-valuemax="255"></div>
                </div>
                <p class="mt-4 mb-1" style="font-size: .77rem;">Defense <small>{$boostedStats[2]['value']}</small></p>
                <div class="progress rounded" style="height: 5px;">
                  <div class="progress-bar" role="progressbar" style="width: {$boostedStats[2]['percent']}%" aria-valuenow="{$boostedStats[2]['value']}"
                    aria-valuemin="0" aria-valuemax="255"></div>
                </div>
                <p class="mt-4 mb-1" style="font-size: .77rem;">Special Attack <small>{$boostedStats[3]['value']}</small></p>
                <div class="progress rounded" style="height: 5px;">
                  <div class="progress-bar" role="progressbar" style="width: {$boostedStats[3]['percent']}%" aria-valuenow="{$boostedStats[3]['value']}"
                    aria-valuemin="0" aria-valuemax="255"></div>
                </div>
                <p class="mt-4 mb-1" style="font-size: .77rem;">Special Defense <small>{$boostedStats[4]['value']}</small></p>
                <div class="progress rounded mb-2" style="height: 5px;">
                  <div class="progress-bar" role="progressbar" style="width: {$boostedStats[4]['percent']}%" aria-valuenow="{$boostedStats[4]['value']}"
                    aria-valuemin="0" aria-valuemax="255"></div>
                </div>
                <p class="mt-4 mb-1" style="font-size: .77rem;">Speed <small>{$boostedStats[5]['value']}</small></p>
                <div class="progress rounded mb-2" style="height: 5px;">
                  <div class="progress-bar" role="progressbar" style="width: {$boostedStats[5]['percent']}%" aria-valuenow="{$boostedStats[5]['value']}"
                    aria-valuemin="0" aria-valuemax="255"></div>
                </div>
end;
$__output .= collapse("See Boosted Stats",$i12);
unset($i12);
$__output .= <<<end
              </div>
            </div>
          </div>
	  </div>
        <div class="row">
          <div class="col">
            <div class="card mb-4 mb-md-0">
              <div class="card-body">
                <p class="mb-4"><span class="text-primary font-italic me-1">original </span> Stats <small>BST {$ogBST}</small>
                </p>
end;
$i12 = <<<end
                <p class="mb-1" style="font-size: .77rem;">HP <small>{$ogStats[0]['value']}</small></p>
                <div class="progress rounded" style="height: 5px;">
                  <div class="progress-bar" role="progressbar" style="width: {$ogStats[0]['percent']}%" aria-valuenow="{$ogStats[0]['value']}"
                    aria-valuemin="0" aria-valuemax="255"></div>
                </div>
                <p class="mt-4 mb-1" style="font-size: .77rem;">Attack <small>{$ogStats[1]['value']}</small></p>
                <div class="progress rounded" style="height: 5px;">
                  <div class="progress-bar" role="progressbar" style="width: {$ogStats[1]['percent']}%" aria-valuenow="{$ogStats[1]['value']}"
                    aria-valuemin="0" aria-valuemax="255"></div>
                </div>
                <p class="mt-4 mb-1" style="font-size: .77rem;">Defense <small>{$ogStats[2]['value']}</small></p>
                <div class="progress rounded" style="height: 5px;">
                  <div class="progress-bar" role="progressbar" style="width: {$ogStats[2]['percent']}%" aria-valuenow="{$ogStats[2]['value']}"
                    aria-valuemin="0" aria-valuemax="255"></div>
                </div>
                <p class="mt-4 mb-1" style="font-size: .77rem;">Special Attack <small>{$ogStats[3]['value']}</small></p>
                <div class="progress rounded" style="height: 5px;">
                  <div class="progress-bar" role="progressbar" style="width: {$ogStats[3]['percent']}%" aria-valuenow="{$ogStats[3]['value']}"
                    aria-valuemin="0" aria-valuemax="255"></div>
                </div>
                <p class="mt-4 mb-1" style="font-size: .77rem;">Special Defense <small>{$ogStats[4]['value']}</small></p>
                <div class="progress rounded mb-2" style="height: 5px;">
                  <div class="progress-bar" role="progressbar" style="width: {$ogStats[4]['percent']}%" aria-valuenow="{$ogStats[4]['value']}"
                    aria-valuemin="0" aria-valuemax="255"></div>
                </div>
                <p class="mt-4 mb-1" style="font-size: .77rem;">Speed <small>{$ogStats[5]['value']}</small></p>
                <div class="progress rounded mb-2" style="height: 5px;">
                  <div class="progress-bar" role="progressbar" style="width: {$ogStats[5]['percent']}%" aria-valuenow="{$ogStats[5]['value']}"
                    aria-valuemin="0" aria-valuemax="255"></div>
                </div>
		
end;
$__output .= collapse("See Original Stats",$i12);
$__output .= <<<end
              </div>
            </div>
          </div>
		  </div> 
	  
    </div>
  </div>
</section>
end;
