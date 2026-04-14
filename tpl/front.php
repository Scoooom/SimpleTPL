<?php

$mon = new \Glitches\Glitch($_GET['id']);
$mon2 = json_decode($mon->json_data);

$img = $mon->front;
if ($_GET['b'] == true) {
  $img = $mon->back;
}
$img = str_replace("data:image/png;base64,","",$img);
//header("Content-Type: text/plain");
header("Content-Type: image/png");

die(base64_decode($img));
