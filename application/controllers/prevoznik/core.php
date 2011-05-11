<?php
require_once($application_folder."/controllers/navigator.php");
class Core extends navigator 
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('prevoznik/core_m', 'prevoznik');
    }

    function index(){ show_404(); }

    function add(){
        $this->core_index('prevoznik','add','PREVOZNIK');
    }

    function edit(){

    }

    function delete(){

    }

    function view(){
        $this->data['prevoznici'] = $this->prevoznik->listaj_prevoznike();
        $this->core_index('prevoznik','view','PREVOZNIK');
    }
    
    function db_add(){
        $this->prevoznik->add();        
    }

}