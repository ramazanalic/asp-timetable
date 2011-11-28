<?php
require_once($application_folder."/controllers/navigator.php");
class Core extends navigator 
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('prevoznik/core_m', 'prevoznik');
        $this->load->model('polazak/polazak_m', 'polazak');
        $this->load->model('search/search_m', 'search');
    }

    function index(){ show_404(); }

    function add(){
        $this->data['prevoznici'] = $this->prevoznik->listaj_prevoznike();
        $this->data['stanice'] = $this->polazak->listaj_stanice(); 
        $this->load->helper('timemaker');
        $this->core_index('polazak','add','POLAZAK');
    }

    function edit($polazak_id){

        $this->data['polazak'] = $this->polazak->listaj_polazak($polazak_id);
        $this->data['st_stanice'] = $this->polazak->listaj_stop_stanice($polazak_id);

        $this->data['prevoznici'] = $this->prevoznik->listaj_prevoznike();
        $this->data['stanice'] = $this->polazak->listaj_stanice(); 

        $this->load->helper('timemaker');

        $this->core_index('polazak','edit','POLAZAK');
    }    

    function view($from=0){
        $limit = 10;
        $count = 0;
        $cur_page = 1;
        $num_links = 2;

        $this->db->select('polazak.*, prevoznik.naziv as naziv_prevoznika, prevoznik.grad as grad_prevoznika', FALSE);
        $this->db->join('prevoznik', 'prevoznik.id = polazak.prevoznik_id ');
        $res = $this->db->get('polazak');  

        $count = $res->num_rows();

        $total_page = ceil($count/$limit);


        $this->db->select('polazak.*, prevoznik.naziv as naziv_prevoznika, prevoznik.grad as grad_prevoznika', FALSE);
        $this->db->join('prevoznik', 'prevoznik.id = polazak.prevoznik_id ');
        $this->db->limit($limit, $from); 

        
        
        $this->load->library('pagination');

        $config['base_url'] = base_url().'polazak/core/view';
        $config['total_rows'] = $count;
        $config['per_page'] = $limit;
        $config['uri_segment'] = 4;
        $config['num_links'] = $num_links;
        
        $config['prev_link'] = '<';
        $config['next_link'] = '>';
        
        $config['first_link'] = 'Početna';
        $config['last_link'] = 'Zadnja';
        
        $config['anchor_class'] = 'class="pgnlink-noajax"';
        
        $config['is_ajax_paging']      =  TRUE; // default FALSE
        $config['paging_function'] = 'ajax_paging'; // Your jQuery paging

        $this->pagination->initialize($config);
        
        $this->data['polasci'] = $this->db->get('polazak')->result_array(); 
        $this->data['paginator'] = $this->pagination->create_links(); 
        $this->data['count'] = $count;
        
        $this->core_index('polazak','view','POLASCI');
    }

    function db_add(){
        $this->polazak->add();        
    }

    function db_edit(){
        $this->polazak->edit();        
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
    
    function pogledaj_detalje_polaska(){
        echo json_encode(array('html' => $this->polazak->pogledaj_detalje_polaska(), TRUE));
    }

    function search($from=0){
        $this->search->search($from,'polazak/search',base_url().'polazak/core/search');
    }

}