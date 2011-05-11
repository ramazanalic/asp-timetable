<?php
require_once($application_folder."/controllers/navigator.php");
class Core extends navigator 
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('translator');  
        $this->load->library('dataload');  
        $this->load->library('assetsload');
    }

    function index($page='home',$sub='') 
    {   
        
        $this->data['page'] = $page;
        $this->data['sub'] = $sub; 
        $this->data['title'] = 'RUTA';


        $this->dataload->getdata($page, $this);
        $this->assetsload->getassets($page, $this);

        if($sub==''){ $this->navigate('ruta/'.$page); }else{ $this->navigate('ruta/'.$page.'/'.$sub); }            

    }
    
    function add(){
        
    }
    
    function edit(){
        
    }
    
    function delete(){
        
    }
    
    function view(){
        
    }

}