<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');   

    require_once ($application_folder."/classes/MY_Controller.php"); 
    class Navigator extends MY_Controller {

        var $data = array();

        function __construct()
        {
            parent::__construct();
            $this->load->model('translator');  
            $this->load->library('dataload');  
            $this->load->library('assetsload');
            $this->lang->load('asp', $this->lang_ses->getlang());
        }

        function index() { show_404(); } 

        function seo_data($rows){

            $this->data['seo_title'] = '';
            $this->data['seo_description']='';
            $this->data['seo_keywords']='';

            foreach ($rows as $row)
            {
                $this->data['seo_title'] = $row->title;
                $this->data['seo_description']=$row->description;
                $this->data['seo_keywords']=$row->keywords;
            }

        }        

        function core_index($page=NULL,$sub=NULL,$title=NULL){

            $this->data['page'] = $page;
            $this->data['sub'] = $sub; 
            $this->data['title'] = $title; 

            $this->assetsload->getassets($page, $sub, $this);

            if($sub==NULL){ $this->navigate($page); }else{ $this->navigate($page.'/'.$sub); }

        }

        function navigate($page=NULL)
        {
            $this->layout->view($page, $this->data);            
        }
    }
?>