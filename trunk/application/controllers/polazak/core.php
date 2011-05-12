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
        $this->data['prevoznici'] = $this->prevoznik->listaj_prevoznike();
        $this->load->helper('timemaker');
        $this->core_index('polazak','add','POLAZAK');
    }

    function edit($id){
        $this->data['prevoznik'] = $this->prevoznik->listaj_prevoznika($id);
        $this->core_index('prevoznik','edit','PREVOZNIK');
    }    

    function view(){
        $this->data['prevoznici'] = $this->prevoznik->listaj_prevoznike();
        $this->core_index('prevoznik','view','PREVOZNIK');
    }

    function db_add(){
        $this->prevoznik->add();        
    }

    function db_edit(){
        $this->prevoznik->edit();        
    }

    function db_delete(){
        $this->prevoznik->delete();
    }

}