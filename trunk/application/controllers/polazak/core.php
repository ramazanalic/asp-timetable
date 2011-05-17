<?php
require_once($application_folder."/controllers/navigator.php");
class Core extends navigator 
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('prevoznik/core_m', 'prevoznik');
        $this->load->model('polazak/polazak_m', 'polazak');
    }

    function index(){ show_404(); }

    function add(){
        $this->data['prevoznici'] = $this->prevoznik->listaj_prevoznike();
        $this->data['stanice'] = $this->polazak->listaj_stanice(); 
        $this->load->helper('timemaker');
        $this->core_index('polazak','add','POLAZAK');
    }

    function edit($id){
         
        $this->data['polazak'] = $this->polazak->listaj_polazak($id);
        
        $this->data['prevoznici'] = $this->prevoznik->listaj_prevoznike();
        $this->data['stanice'] = $this->polazak->listaj_stanice(); 
        
        $this->load->helper('timemaker');
        
        $this->core_index('polazak','edit','POLAZAK');
    }    

    function view(){
        $this->data['polasci'] = $this->polazak->listaj_polaske(); 
        $this->core_index('polazak','view','POLASCI');
    }

    function db_add(){
        $this->polazak->add();        
    }

    function db_edit(){
        $this->prevoznik->edit();        
    }

    function db_delete(){
        $this->polazak->delete();
    }

    function daj_stop_stanicu(){
        $this->load->helper('timemaker');
        echo json_encode(array('html' => $this->load->view('polazak/stopstanica', array('stoptype'=>'stop','id'=>$_POST['rb_stanice']), TRUE)));
    }

    function pogledaj_stop_stanice(){        
        echo json_encode(array('html' => $this->polazak->pogledaj_stop_stanice(), TRUE));
    }

    function db_brisi_stop_stanicu($answer_id){            
        if($this->anketa->deleteanswer($answer_id)) {
            echo json_encode(array('seccess'=>'seccess'));
        }else echo json_encode(array('seccess'=>'failed')); 
    }



}