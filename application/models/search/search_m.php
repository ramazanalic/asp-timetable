<?php

    class Search_m extends CI_Model {

        function __construct()
        {
            parent::__construct(); 
        }

        var $errors = '';

        /* Pretraga voznog reda Autobuske Stanice Podgorica 
        do kraja klase*/

        function search($from,$view,$baseurl){

            /* Paging */
            $limit = 10;
            $count = 0;
            $cur_page = 1;
            $num_links = 8;

            if($this->validate_search()==TRUE){

                $polazna_id = $this->get_stanica_id($_GET['srch_polazak']);
                $dolazna_id = $this->get_stanica_id($_GET['srch_dolazak']);

                $polasci_ids = $this->daj_spisak_polazaka_koji_ukljucuju($polazna_id, $dolazna_id);

                if(count($polasci_ids)>0){

                    $count = count($polasci_ids);

                    $total_page = ceil($count/$limit);                    

                    $html = '';

                    $i = 0;
                    $j = $from;
                    
                    $this->firephp->fb('i: '.$i);
                    $this->firephp->fb('limit: '.($from+$limit));
                    
                    foreach($polasci_ids as $value){
                        
                        if(($i<($from+$limit))&&($i>=$j)){
                        
                            $html .= $this->load->view($view, array('polasci' => $this->listaj_podatke_stanice_sa_id_polaska($value)), TRUE);     
                            
                        }  
                        
                        $i++;                      
                        
                    }

                    $this->load->library('pagination');

                    $config['base_url'] = $baseurl;
                    $config['total_rows'] = $count;
                    $config['per_page'] = $limit;
                    $config['uri_segment'] = 4;
                    $config['num_links'] = $num_links;

                    $config['prev_link'] = '<';
                    $config['next_link'] = '>';
                    
                    $config['first_link'] = 'Početna';
                    $config['last_link'] = 'Zadnja';

                    $config['anchor_class'] = 'class="pgnlink"';

                    $config['is_ajax_paging']      =  TRUE; // default FALSE
                    $config['paging_function'] = 'ajax_paging'; // Your jQuery paging

                    $this->pagination->initialize($config);

                    $paginator = $this->pagination->create_links(); 

                    echo $_GET['jsoncall'] . '(' . json_encode(array('success' => true, 'html'=> $html, 'paginator' => $paginator, 'count'=> $count)) . ');';

                }else{
                    $paginator = '';
                    echo $_GET['jsoncall'] . '(' . json_encode(array('success' => true, 'html'=> '<tr class="odd"><td colspan="9" style="text-align: center;"><b>NEMA POLAZAKA ZA TRAÅ½ENU RUTU</b></td></tr>.', 'paginator' => $paginator, 'count'=> $count)) . ');';   
                }



            } else{

                echo $_GET['jsoncall'] . '(' . json_encode(array('success' => false, 'html'=>$this->errors)) . ');';

            }

        }

        function search_ajax_paging($from){
            
            

        }

        function validate_search() {

            $_POST = $_GET;

            $this->form_validation->set_rules('srch_polazak','unesite <b>polaznu stanicu</b>','required|provjeri_stanicu[srch_polazak]');

            $this->form_validation->set_rules('srch_dolazak','unesite <b>dolaznu stanicu</b>','required|provjeri_stanicu[srch_dolazak]');

            $this->form_validation->set_message('required', 'Molimo %s.');

            if($this->form_validation->run()== TRUE) {
                return TRUE;
            }else {
                $this->errors = validation_errors(' ', '<br />');
                return FALSE;
            }
        }

        function get_stanica_id($name){

            $res = $this->db->get_where('stanica',array('naziv' => $name))->row_array();

            return $res['id'];

        }

        function listaj_podatke_stanice_sa_id_polaska($polazak_id){

            $this->db->select('polazak.*, prevoznik.naziv as naziv_prevoznika, prevoznik.grad as grad_prevoznika', FALSE);

            $this->db->join('prevoznik', 'prevoznik.id = polazak.prevoznik_id ');

            $this->db->where(array('polazak.id' => $polazak_id));

            return $this->db->get('polazak')->result_array(); 

        }

        function daj_spisak_polazaka_koji_ukljucuju($polazna_id, $dolazna_id){  //return Array


            $lista_polazaka = array();


            /* Listaj sve polaske */

            $res1 = $this->db->get('polazak')->result_array();

            foreach($res1 as $rs1){


                /* Za svaki polazak listaj stop stanice koje ukljucuju polaznu stanicu */

                $id_ili_false = $this->da_li_ima_ovaj_polazak_ovim_redosledom($polazna_id, $dolazna_id, $rs1['id']);

                if($id_ili_false != FALSE){
                    $lista_polazaka[] = $id_ili_false;  
                }


            }

            RETURN $lista_polazaka;

        }

        function da_li_ima_ovaj_polazak_ovim_redosledom($polazna_id, $dolazna_id, $polazak_id){  //return id polaska


            /* 
            Provjeri da li ima polazna stanica 
            u stop-stanicama 
            za dati polazak 
            */

            $this->db->where(array('stanica_id' => $polazna_id , 'polazak_id' => $polazak_id));
            $this->db->from('stopstanica');
            $cnt1 = $this->db->count_all_results();

            if($cnt1 ==0)   RETURN FALSE;


            /* Uzmi id stop-stanice */

            $res1 = $this->db->get_where('stopstanica', array('stanica_id' => $polazna_id , 'polazak_id' => $polazak_id))->row_array();
            $id1 = $res1['id'];


            /* 
            Provjeri da li ima dolazna stanica 
            u stop-stanicama 
            za dati polazak 
            */

            $this->db->where(array('stanica_id' => $dolazna_id , 'polazak_id' => $polazak_id));
            $this->db->from('stopstanica');
            $cnt2 = $this->db->count_all_results();

            if($cnt2 ==0)   RETURN FALSE;


            /* Uzmi id stop-stanice */

            $res2 = $this->db->get_where('stopstanica', array('stanica_id' => $dolazna_id , 'polazak_id' => $polazak_id))->row_array();
            $id2 = $res2['id'];


            if($id2 > $id1){

                /*$this->firephp->fb('stopstanicaid-1: '.$id1);
                $this->firephp->fb('stopstanicaid-2: '.$id2);
                $this->firephp->fb('id-polaska: '.$polazak_id);
                $this->firephp->fb('---------------------------');*/
                RETURN $polazak_id;

            } else RETURN FALSE;
        }

    }
?>
