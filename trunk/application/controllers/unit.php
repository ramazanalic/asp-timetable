<?php
require_once($application_folder."/controllers/navigator.php");
class Core extends navigator 
{

    function __construct()
    {
        parent::__construct(); 
    }

    function index(){ $this->core_index('home','home','HOME'); } 
      
    function add(){
        
    }
    
    function edit(){
        
    }
    
    function delete(){
        
    }
    
    function view(){
        
    }

}