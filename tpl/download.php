<?php
try {
	$mon = new \Glitches\Glitch($_GET['id']);
    header("Content-Description: File Transfer"); 
	header("Content-Type: application/octet-stream"); 
	header("Content-Disposition: attachment; filename=\"". $mon->filename ."\""); 
    die($mon->json_data);
} catch  (\Exceptions\ItemNotFound $e) {
	$__output .= "<h3>Opps! Something went wrong!</h3><p>Please let scooom know of this error, and which Glitch you were trying to download!";
}
