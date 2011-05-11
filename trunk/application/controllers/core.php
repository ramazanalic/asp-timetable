<?php
require_once($application_folder."/controllers/navigator.php");
class Core extends navigator 
{

    function __construct()
    {
        parent::__construct(); 
    }

    function index(){ show_404(); } 
      
    function add(){
        
    }
    
    function edit(){
        
    }
    
    function delete(){
        
    }
    
    function view(){
        
    }

}