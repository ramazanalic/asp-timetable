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

    function index($page=NULL,$sub=NULL,$title=NULL) 
    {   
        
        $this->data['page'] = $page;
        $this->data['sub'] = $sub; 
        $this->data['title'] = $title;

        $this->assetsload->getassets($page, $this);

        if($sub==NULL){ $this->navigate($page); }else{ $this->navigate($page.'/'.$sub); }            

    }
    
    function add(){
        
    }
    
    function edit(){
        
    }
    
    function delete(){
        
    }
    
    function view(){
        $this->load->model('prevoznik/core_m', 'prevoznik');
        $this->data['prevoznici'] = $this->prevoznik->listaj_prevoznike();
        $this->index('prevoznik','view','PREVOZNIK');
    }

}