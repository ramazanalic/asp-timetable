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
        $this->lang->load('asp', $this->lang_ses->getlang()); 
    }

    function index($page='home',$sub='') 
    {   
        
        $this->data['page'] = $page;
        $this->data['sub'] = $sub; 
        $this->data['title'] = $page; 


        $this->dataload->getdata($page, $this);
        $this->assetsload->getassets($page, $this);

        if($sub==''){ $this->navigate('redvoznje/'.$page); }else{ $this->navigate('redvoznje/'.$page.'/'.$sub); }            

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