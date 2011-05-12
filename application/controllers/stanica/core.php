<?php
require_once($application_folder."/controllers/navigator.php");
class Core extends navigator 
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('stanica/core_m', 'stanica');
    }

    function index(){ show_404(); }

    function add(){
        $this->core_index('stanica','add','STANICA');
    }

    function edit($id){
        $this->data['stanica'] = $this->prevoznik->listaj_stanicu($id);
        $this->core_index('stanica','edit','STANICA');
    }    

    function view(){
        $this->data['stanice'] = $this->stanica->listaj_stanice();
        $this->core_index('stanica','view','STANICA');
    }

    function db_add(){
        $this->stanica->add();        
    }

    function db_edit(){
        $this->stanica->edit();        
    }

    function db_delete(){
        $this->stanica->delete();
    }

}