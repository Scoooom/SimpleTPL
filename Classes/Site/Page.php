<?php
namespace Site;
class Page {
    
    function getHeader() {
        return \Tpl\Template::getHeader();
    }
    
    function __construct() {
        define('PAGE',(isset($_REQUEST['page']))?$_REQUEST['page']:'index');
        $page = \Tpl\Template::get(PAGE);
        if (defined('AUTH_REQUIRED') && !\Login\User::isLoggedIn()) {
          $page = \Tpl\Template::get('403');
          die($this->getHeader().$page.$this->getFooter());
        }
        
        if (defined('AJAX')) { // This causes the template system to not output the header / footer
            die($page);
        }
        die($this->getHeader().$page.$this->getFooter());
    }
    
    function getFooter() {
        return \Tpl\Template::getFooter();
    }
}
