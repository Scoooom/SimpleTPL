<?php
$glitch = \Glitches\Glitch::LoadBy();
define('TPATH','/var/www/void.scooom.xyz/tmp/');
$t = time();
define('APATH',TPATH.'downloadAll'.$t.'/');
define('ZPATH',TPATH.'downloadAll'.$t.'.zip');
mkdir(APATH);

$zipFile = ZPATH;
$zipArchive = new ZipArchive();

if ($zipArchive->open($zipFile, (ZipArchive::CREATE | ZipArchive::OVERWRITE)) !== true)
    die("Failed to create archive\n");


$files = array();
foreach($glitch as $g) {
  $files[] = APATH.$g->filename;
  $zipArchive->addFromString($g->filename,$g->json_data);
}



$zipArchive->close();

$data = file_get_contents(ZPATH);
/* */
header("Content-Type: application/zip");
header("Content-Disposition: attachment; filename=allGlitches.zip");
header("Content-Length: " . filesize(ZPATH));
/* */
unlink(ZPATH);
foreach($files as $f) unlink($f);
rmdir(APATH);
	
echo $data;
die;
//rmdir(APATH);
die(APATH);
