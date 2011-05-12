<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
class assetsload {
    private $CI;
    private $page;
    private $sub;
    private $master_init;

    function assetsload(){
        $this->CI = & get_instance();
        $this->CI->load->model('translator');
    } 

    function getassets($cur_page, $cur_sub, $master){

        $this->page = $cur_page;
        $this->sub = $cur_sub;
        $this->master_init = $master;

        $this->CI->carabiner->css('core.css');       
        $this->CI->carabiner->css('basic.css');       

        $this->CI->carabiner->css('simple-modal.css');
        $this->CI->carabiner->js('jquery.simplemodal.js');

        $this->CI->carabiner->css('jqueryslidemenu.css');                
        $this->CI->carabiner->js('jqueryslidemenu.js');        
        $this->CI->carabiner->js('swfobject.js');        

        switch($this->page){



            case 'home':            
            switch($this->sub){
                case 'add':
                    break;
                case 'edit':
                    break;
                case 'view':
                    break;
            }  
            break;



            case 'prevoznik':    
            switch($this->sub){
                case 'add':
                    $this->CI->carabiner->js('tiny_mce/tiny_mce.js');
                    $this->CI->carabiner->js('prevoznik/add.js');
                    break;
                case 'edit':
                    $this->CI->carabiner->js('tiny_mce/tiny_mce.js');
                    $this->CI->carabiner->js('prevoznik/edit.js');
                    break;
                case 'view':
                    $this->CI->carabiner->js('tablesorter/jquery.tablesorter.js');
                    $this->CI->carabiner->js('tablesorter/pager/jquery.tablesorter.pager.js');
                    $this->CI->carabiner->css('tablesorter/style.css');
                    $this->CI->carabiner->js('prevoznik/view.js');
                    break;
            }
            break;



            case 'ruta':    
            switch($this->sub){
                case 'add':
                    $this->CI->carabiner->js('jquery.tagger.js');
                    $this->CI->carabiner->js('ruta/add.js');
                    break;
                case 'edit':
                    break;
                case 'view':
                    break;
            }
            break; 



        }

        $this->CI->carabiner->js('core.js'); 

    }
}