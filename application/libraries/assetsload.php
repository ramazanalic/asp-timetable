<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class assetsload {
    private $CI;
    private $page;
    private $master_init;

    function assetsload(){
        $this->CI = & get_instance();
        $this->CI->load->model('translator');
    } 

    function getassets($cur_page,$master){

        $this->page = $cur_page;
        $this->master_init = $master;
        
        $this->CI->carabiner->css('core.css');       
        $this->CI->carabiner->css('basic.css');       
        
        $this->CI->carabiner->css('simple-modal.css');
        $this->CI->carabiner->css('jqueryslidemenu.css');
        $this->CI->carabiner->js('jquery.simplemodal.js');        
        $this->CI->carabiner->js('jqueryslidemenu.js');
        $this->CI->carabiner->js('swfobject.js');        
               
        switch($this->page){
            case 'home':            $this->home();              break;
            case 'prevoznikadd':        $this->services();          break; 
            case 'parking':         $this->parking();           break; 
            case 'news':            $this->news();              break;            
            case 'faq':             $this->faq();               break;            
        }
        
        $this->CI->carabiner->js('core.js'); 
        
    }
    function home(){
         
    }
    
    function services(){
        //$this->CI->carabiner->js('google_map.js'); 
    }
    
    function parking(){
        $this->CI->carabiner->js('google_map.js'); 
    }
    
    function news(){
        $this->CI->carabiner->js('news.js'); 
    }
    
    function faq(){
        $this->CI->carabiner->css('jquery.jscrollpane.css'); 
        $this->CI->carabiner->js('jquery.mousewheel.js'); 
        $this->CI->carabiner->js('jquery.jscrollpane.min.js'); 
    }

}