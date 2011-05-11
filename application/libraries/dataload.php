<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
    class dataload {
        private $CI;
        private $page;
        private $master_init;

        function dataload(){
            $this->CI = & get_instance();
            $this->CI->load->model('translator');
        } 

        function getdata($cur_page,$master){

            $this->page = $cur_page;
            $this->master_init = $master;

            switch($this->page){
                case"home":             $this->home();              break;
                case"accomodation":     $this->accommodation();     break;
                case"excursions":       $this->excursions();        break;
                case"tours":            $this->tours();             break;
                case"adventurestours":  $this->adventurestours();   break;  
                case"news":             $this->news();              break; 
                case"admin":            $this->admin();             break; 
            }

            /*$this->master_init->data['mainnav'] = $this->CI->translator->mainnav();
            $this->master_init->data['subnav'] = $this->CI->translator->subnav(); */
        }
        function home(){
            /*$this->master_init->data['bustours'] = $this->CI->translator->bustours();
            $this->master_init->data['partners'] = $this->CI->translator->partners();
            $this->master_init->data['hotels'] = $this->CI->translator->hotels();*/
        }
        function accommodation(){
            /*$this->master_init->data['hotels'] = $this->CI->translator->hotels(); 
            $this->master_init->data['page'] = 'accomodation';
            $this->master_init->data['link'] = $this->CI->input->post('hotel-sel'); */
        }
        function excursions(){
            //$this->master_init->data['excursions'] = $this->CI->translator->excursions();  
        }
        function tours(){
            //$this->master_init->data['tours'] = $this->CI->translator->tours($this->master_init->data['sub']);
        }
        function adventurestours(){
            //$this->master_init->data['tours'] = $this->CI->translator->tours('adventurestours'); 
        }
        function news(){
            /*$this->master_init->data['news'] = $this->CI->translator->news();
            $this->master_init->data['current-news'] = $this->CI->input->post('current-news');*/
        }
        function admin(){
            //redirect('http://www.logicsolution.rs/logicsol_news');
        }
    }