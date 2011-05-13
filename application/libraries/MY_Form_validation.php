<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

class MY_Form_validation extends CI_Form_validation {

    function __construct()
    {
        parent::__construct(); 

    }    
    

    function provjeri_prevoznika() {    

        $CI =& get_instance();
        
        $CI->form_validation->set_message('provjeri_prevoznika', 'Molimo odaberite %s.');

        if($_POST['prevoznik_id']==0){

            return FALSE;

        }

        else return TRUE;

    }
    

    function provjeri_stanicu($str, $field){
        
        $message = '';
        
        if(substr($field,0,7)=='stanica'){

            $message = '<b>Stop '.substr($field,0,7).' '.substr($field,8,strlen ($field)).'</b>';
            
        }else{
            if($field=="pocetna_stanica"){
               $message = '<b>Početna stanica</b>'; 
            }else if($field=='zadnja_stanica'){
                $message = '<b>Zadnja stanica</b>';
            }

            
        }

        $CI =& get_instance();
        
        $CI->form_validation->set_message('provjeri_stanicu', $message.' ne postoji u bazi.');

        if($str=='a'){

            return FALSE;

        }

        else return TRUE; 

    }

}

