<?php
namespace Site;
class Page {
    
    function getHeader() {
        return \Tpl\Template::getHeader();
    }
    
    function __construct() {
        define('PAGE',(isset($_REQUEST['page']))?$_REQUEST['page']:'index');
        $page = \Tpl\Template::get(PAGE);
	    if (defined('401') && !\Login\User::isLoggedIn()) {
	        $page = \Tpl\Template::get('403');
            die($this->getHeader().$page.$this->getFooter());
        }
        
        if (defined('401b')) {
	        $page = \Tpl\Template::get('401b');
        }
        if (defined('AJAX')) {
            die($page);
        }
        die($this->getHeader().$page.$this->getFooter());
    }
    
    function getFooter() {
        return \Tpl\Template::getFooter();
    }
}
