<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');   

    require_once ($application_folder."/classes/MY_Controller.php"); 
    class Navigator extends MY_Controller {

        var $data = array();

        function __construct()
        {
            parent::__construct();
        }

        function index() {
            show_404();
        } 

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

        function navigate($page)
        {
            $this->layout->view($page, $this->data);            
        }
    }
?>