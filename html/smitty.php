<?php

  
header("Content-type: text/json");
define('F','/var/www/void.scooom.xyz/html/smitty.txt');
$abilties = json_decode(file_get_contents('/var/www/void.scooom.xyz/ability.json'));

//die(print_r($abilties,1));
$data = explode("\n",file_get_contents(F));
/* *
for($i = 0; $i < count($data); $i++) {
	if (str_contains($data[$i],'[')) {
		$o = $data[$i];
		$p = preg_replace("/(.*?)\[(.*?)\](.*)/is","$2",$o);
		$n = preg_replace("/(.*?)\[(.*?)\](.*)/is","$1_data_$3",$o);
		$l = explode(", ",$p);
		foreach($l as $u) {
			$new = str_replace("_data_",$u,$n);
			$data[] = $new;
		}
		unset($data[$i]);
	}
}
/* */
$mons = new stdClass();
foreach($data as $a) {
	
  $g1 = str_replace('addUniversalSmittyForm(','',str_replace(');','',$a));
  $g = explode(",",$g1);

  
  unset($g[1]);
	  $g[0] = trim(str_replace('{ formName: "','',$g[0]),'"');


  
  $g[2] = str_replace('Type.','',str_replace('primaryType: ','',$g[2]));
  $g[3] = str_replace('Type.','',str_replace('secondaryType: ','',$g[3]));

  $g[4] = str_replace('ability1: Abilities.','',$g[4]);
  $g[5] = str_replace('ability2: Abilities.','',$g[5]);
  $g[6] = str_replace('abilityHidden: Abilities.','',$g[6]);

  for($i = 0; $i < count($g); $i++) { 
    if (!isset($g[$i])) continue;
    $g[$i] = trim($g[$i]);
    $g[$i] = trim($g[$i],'"');
	if ($i >= 4 && $i <= 6) {
		$a = $g[$i];
		$a = strtolower($a);
		$b = null;
		$a = explode("_",$a);
		for($o = 0; $o < count($a); $o++) {
			if ($o == 0) $b = $a[$o];
			else $b .= ucwords($a[$o]);
		}
		$g[$i] = $abilties->$b;
		//$g[$i] = $abilties;
	}
	if ($i == 2 || $i == 3) {
		$g[$i] = \Glitches\BuiltIn::getNumType($g[$i]);
		//if (empty($g[$i])) $g[$i] = -1;
	}
	if ($i >= 7 && $i <= 13) {
		$g[$i] = preg_replace("/(.*): (.*)/is","$2",$g[$i]);
	}
    //echo "{$i}: {$g[$i]}\n";
  }
  unset($g[14]);

//  print_r($g);
  $tmp = new stdClass();
  $tmp->name = ucwords($g[0]);
  $tmp->type1 = $g[2];
  $tmp->type2 = $g[3];
  $tmp->ab1 = $g[4];
  $tmp->ab2 = $g[5];
  $tmp->ha = $g[6];
  $tmp->bst = $g[7];
  $tmp->hp = $g[8];
  $tmp->atk = $g[9];
  $tmp->def = $g[10];
  $tmp->spatk = $g[11];
  $tmp->spdef = $g[12];
  $tmp->spd = $g[13];
  $name = $g[0];
  $mons->$name = $tmp;
  error_log("Added {$name}!");
}
$builtinData = json_encode($mons);
file_put_contents(BUILTINS,$builtinData);
die($builtinData);