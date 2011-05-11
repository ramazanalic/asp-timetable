<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Lang_ses {

    private $CI;
    public $lang;
    private $default = 'en';

    function Lang_ses () {
        $this->CI = & get_instance();
    }

    function setLang($to){
        $this->CI->session->set_userdata('lang',$to);
    }

    function getLang(){
        if($this->CI->session->userdata('lang') != NULL){
            if($this->CI->session->userdata('lang')=='sr'){
                $this->CI->session->set_userdata('lang','en');
            }
            return $this->CI->session->userdata('lang');
        }else{
            return $this->default;
        }
    }
    
}
?>
