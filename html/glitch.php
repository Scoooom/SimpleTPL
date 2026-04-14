<?php

  
header("Content-type: text/json");
define('F','/var/www/void.scooom.xyz/html/glitch.txt');
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
	
  $g = str_replace('addFormToSpecies(','',str_replace(');','',$a));
  $g = explode(",",$g);
  unset($g[2]);
  if (str_contains($g[0],'[')) {
      $n = preg_replace("/(.*?)\[(.*?)\](.*)/is","$1_data_$3",$a);
      $g = str_replace('addFormToSpecies(','',str_replace(');','',$n));
      $b = $g;
	  $g = explode(",",$g);
	  unset($g[2]);
	  $h = preg_replace("/(.*?)\[(.*?)\](.*)/is","$2",$a);
	  
	  $mons2 = [];
	  
	  $i = explode(", ",$h);
	  foreach($i as $i1) {
		  $i1 = str_replace('Species.','',$i1);
		  // Fix Special Names
		  if ($i1 == 'MIMIKYU') {
			  $i1 = 'mimikyu-disguised';
		  }
		  if ($i1 == 'PORYGON_Z') $i1 = 'porygon-z';
		  if ($i1 == 'EISCUE') $i1 = 'eiscue-ice';

		  $tmp = json_decode(file_get_contents('https://pokeapi.co/api/v2/pokemon/'.$i1));
		  $id = $tmp->id;
		  $mons2[] = $id;
		  unset($id);
		  unset($tmp);
	  }
	  $g[0] = implode(",",$mons2);
	  unset($mons2);
    } else {
	  $g[0] = str_replace('Species.','',$g[0]);
	  // Fix Special Names
	  if ($g[0] == 'MIMIKYU') {
		  $g[0] = 'mimikyu-disguised';
	  }
	  if ($g[0] == 'PORYGON_Z') $g[0] = 'porygon-z';
	  if ($g[0] == 'EISCUE') $g[0] = 'eiscue-ice';
	  
	  $tmp = json_decode(file_get_contents('https://pokeapi.co/api/v2/pokemon/'.$g[0]));
	  $id = $tmp->id;
	  $g[0] = $id;
	  unset($tmp);
  }
  $g[3] = str_replace('Type.','',$g[3]);
  $g[4] = str_replace('Type.','',$g[4]);
  
  $g[5] = str_replace('Abilities.','',$g[5]);
  $g[6] = str_replace('Abilities.','',$g[6]);
  $g[7] = str_replace('Abilities.','',$g[7]);
  for($i = 0; $i < count($g); $i++) { 
    if (!isset($g[$i])) continue;
    $g[$i] = trim($g[$i]);
    $g[$i] = trim($g[$i],'"');
	if ($i >= 5 && $i <= 7) {
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
	if ($i == 3 || $i == 4) {
		$g[$i] = \Glitches\BuiltIn::getNumType($g[$i]);
	}
    //echo "{$i}: {$g[$i]}\n";
  }
//  print_r($g);
  $tmp = new stdClass();
  $tmp->ogMon = $g[0];
  $tmp->name = ucwords($g[1]);
  $tmp->type1 = $g[3];
  $tmp->type2 = $g[4];
  $tmp->ab1 = $g[5];
  $tmp->ab2 = $g[6];
  $tmp->ha = $g[7];
  $tmp->bst = $g[8];
  $tmp->hp = $g[9];
  $tmp->atk = $g[10];
  $tmp->def = $g[12];
  $tmp->spatk = $g[12];
  $tmp->spdef = $g[13];
  $tmp->spd = $g[14];
  
  $name = $g[1];
  $mons->$name = $tmp;
  error_log("Added {$name}!");
}
$builtinData = json_encode($mons);
file_put_contents(BUILTIN,$builtinData);
die($builtinData);