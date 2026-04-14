<?php
$name = $_GET['id'];

header("Content-Type: image/png");
$file = GPATH.strtolower(str_replace('Ω','ω',$name)."_back.png");
die(file_get_contents($file));

