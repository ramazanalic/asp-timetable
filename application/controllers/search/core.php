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

    function view($from = 0){

        $limit = 10;
        $count = 0;
        $cur_page = 1;
        $total_page = 0;
        
        $this->db->select('polazak.*, prevoznik.naziv as naziv_prevoznika, prevoznik.grad as grad_prevoznika', FALSE);
        $this->db->join('prevoznik', 'prevoznik.id = polazak.prevoznik_id ');        
        $res = $this->db->get('polazak');  
        
        $count = $res->num_rows();
        
        $this->db->select('polazak.*, prevoznik.naziv as naziv_prevoznika, prevoznik.grad as grad_prevoznika', FALSE);
        $this->db->join('prevoznik', 'prevoznik.id = polazak.prevoznik_id ');
        $this->db->limit($limit, $from);        
        $res = $this->db->get('polazak'); 

        
        $total_page = ceil($count/$limit);
        
        $this->load->library('pagination');

        $config['base_url'] = 'http://localhost/asp-timetable/search/core/ajax_page_view';
        $config['total_rows'] = $count;
        $config['per_page'] = $limit;
        $config['uri_segment'] = 4;
        $config['num_links'] = $total_page;
        
        $config['prev_link'] = '<';
        $config['next_link'] = '>';
        
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        
        $config['anchor_class'] = 'class="pgnlink"';
        
        $config['is_ajax_paging']      =  TRUE; // default FALSE
        $config['paging_function'] = 'ajax_paging'; // Your jQuery paging

        $this->pagination->initialize($config);
        
        $this->data['polasci'] = $res->result_array(); 
        $this->data['paginator'] = $this->pagination->create_links(); 
        $this->data['count'] = $count;
        $this->core_index('search','view','PRETRAŽIVAČ');
        
        
    }
    
    function ajax_page_view($from = 0){
     
        $limit = 10;
        $count = 0;
        $cur_page = 1;
        $total_page = 0;
        
        $this->db->select('polazak.*, prevoznik.naziv as naziv_prevoznika, prevoznik.grad as grad_prevoznika', FALSE);
        $this->db->join('prevoznik', 'prevoznik.id = polazak.prevoznik_id ');        
        $res = $this->db->get('polazak');  
        
        $count = $res->num_rows();
        
        $this->db->select('polazak.*, prevoznik.naziv as naziv_prevoznika, prevoznik.grad as grad_prevoznika', FALSE);
        $this->db->join('prevoznik', 'prevoznik.id = polazak.prevoznik_id ');
        $this->db->limit($limit, $from);        
        $res = $this->db->get('polazak'); 

        
        $total_page = ceil($count/$limit);
        
        $this->load->library('pagination');

        $config['base_url'] = 'http://localhost/asp-timetable/search/core/ajax_page_view';
        $config['total_rows'] = $count;
        $config['per_page'] = $limit;
        $config['uri_segment'] = 4;
        $config['num_links'] = $total_page;
        
        $config['prev_link'] = '<';
        $config['next_link'] = '>';
        
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        
        $config['anchor_class'] = 'class="pgnlink"';
        
        $config['is_ajax_paging']      =  TRUE; // default FALSE
        $config['paging_function'] = 'ajax_paging'; // Your jQuery paging

        $this->pagination->initialize($config);
        
        $this->data['polasci'] = $res->result_array(); 
        $this->data['paginator'] = $this->pagination->create_links(); 
        $this->data['count'] = $count;
        
        $html = $this->load->view('search/search', $this->data,TRUE);
        
        echo $_GET['jsoncall'] . '(' . json_encode(array('html'=>$html,'paginator' => $this->data['paginator'])) . ');';
        
    }


    function pogledaj_stop_stanice(){        
        echo json_encode(array('html' => $this->polazak->pogledaj_stop_stanice(), TRUE));
    }

    function search($from=0){
        $this->search->search($from,'search/search',base_url().'search/core/search');
    }

}