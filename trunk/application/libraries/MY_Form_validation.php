<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

class MY_Form_validation extends CI_Form_validation {

    function __construct()
    {
        parent::__construct(); 
    }    

    function checkAnswers(){
        $i=0;
        foreach($_POST as $key => $value){
            if((substr($key,0,6)=='answer')&&($value!='Ostavi prazno da bi obrisao odgovor')){
                $i++;   
            }                
        }        
        if($i>=2){
            return TRUE; 
        }else return FALSE;
    }

    function checkStyle(){ 
        if($_POST['styleID']){
            return TRUE;
        }
        else return FALSE;
    }

    function provjeriPervoznika(){   
        if($_POST['prevoznik_id']==0){
            return FALSE;
        }
        else return TRUE;
    }

    function checkPollWidth(){         
        if(isset($_POST['styleID'])){   
            if(!isset($_POST['poll_width'])){   
                return FALSE;
            }
        }                      
        return TRUE;
    }  
    function registrationCountry(){
        if(strlen($_POST['country_ccode'])==2){
            return TRUE;
        }
        else return FALSE; 
    }
}

