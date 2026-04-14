<?php
namespace Tpl;
class Template {

 public static $hardpath = baseTplPath;

 public static function getHeader() {

     return self::get('header');//self::proccess(file_get_contents(self::$hardpath.'header.html'));
 }
 
 public static function getFooter() {
     return self::get('footer');//self::proccess(file_get_contents(self::$hardpath.'footer.html'));
 }     

 public static function __proccess($file) {
     include_once($file);
     return self::proccess($__output);
 }
 public static function proccess($data) {
     
     preg_match_all("/\{\{\%(.*?)\%\}\}/",$data,$m);
     if (empty($m[0]) && empty($m[1])) {
         return $data;
     }
    // echo "<!--\n\n".print_r($m,1)."\n\n-->";
     for ($i = 0; $i < count($m)-1; $i++) {
        $d1 = '';
        if (file_exists(self::$hardpath.$m[1][$i].'.php')) {
            $d1 = self::__proccess(self::$hardpath.$m[1][$i].'.php');
        } elseif (file_exists(self::$hardpath.$m[1][$i].'.html')) {
            $d1 = file_get_contents(self::$hardpath.$m[1][$i].'.html');
        } else {
            $d1 = '';    
        }
        $data = str_replace($m[0][$i],$d1,$data);
     }
     return $data;
 }
 
 public static function finalProccess($data) {
     $data = preg_replace("/<!--.*?-->/ms","",$data);
     return $data;
 }
 
 public static function get($page) {
     $path = self::$hardpath.$page.'.html';
     $md = self::$hardpath.$page.'.md';
     $path2 = self::$hardpath.$page.'.php';
     $data = null;
     if (file_exists($path2)) {
       die('Found: '.$path2);
         $data = self::__proccess($path2);
         return self::proccess($data);
     }
     if (file_exists($md)) {
         $data = \Michelf\Markdown::defaultTransform(file_get_contents($md));
         return $data;
     }
     if (!file_exists($path) && !file_exists($path2)) return self::get('404'); //return '<b>Fatal Error! Neither <i><u>'.$path.'</u></i> nor <i><u>'.$path2.'</u></i> could be found!';
     return self::finalProccess(self::proccess(file_get_contents($path)));
     //return self::proccess(file_get_contents($path));
 }
    
}
