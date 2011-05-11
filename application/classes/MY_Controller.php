<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');   
class MY_Controller extends CI_Controller {


    function __construct()
    {
        parent::__construct();
        $this->_config_fireignition();
        $this->_config_carabiner();
    }


    function trace($string,$val=NULL)
    {
        if($val != NULL)
        {
            $this->firephp->fb($string.':'.$val);         
        }else
        {
            $this->firephp->fb($string);         
        }

    }

    function _config_fireignition()
    {
        $this->load->config('fireignition');         

        if ($this->config->item('fireignition_enabled'))
        {
            if (floor(phpversion()) < 5)
            {
                log_message('error', 'PHP 5 is required to run fireignition');
            } else {
                $this->load->library('firephp');
            }
        }
        else 
        {
            $this->load->library('firephp_fake');
            $this->firephp =& $this->firephp_fake;
        }    
    }

    function _config_carabiner()
    {
        $carabiner_config = array(
        'script_dir' => 'assets/js/', 
        'style_dir'  => 'assets/css/',
        'cache_dir'  => 'assets/cache/',
        'base_uri'   => $this->config->item('base_url'),
        'combine'    => TRUE,
        'dev'        => TRUE
        );  

        $this->carabiner->config($carabiner_config);
    }
}

/* End of file MY_Controller.php */
/* Location: ./system/application/libraries/MY_Controller.php */