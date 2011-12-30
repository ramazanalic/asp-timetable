<?php

    class Search_m extends CI_Model {

        /************************************************************* 
        *  $TYPE STRING 
        *  POLASCI I DOLASCI
        *************************************************************/ 

        var $TYPE;
        var $prefix; 
        var $sufix;

        function __construct()
        {
            parent::__construct();
            date_default_timezone_set ('Europe/Belgrade');  
        }

        var $errors = '';

        /* Pretraga voznog reda Autobuske Stanice Podgorica 
        do kraja klase*/


        function search($from,$view,$baseurl){

            //tip polaska -> polazak ili dolazak
            $this->TYPE = $_GET['type'];

            switch ($this->TYPE) {

                case 'polasci':

                    $this->sufix = '';
                    $this->prefix = 'p';

                    break;

                case 'dolasci':

                    $this->sufix = '_d';
                    $this->prefix = 'd';

                    break;
            }


            /* Paging */
            $limit = 25;
            $count = 0;
            $cur_page = 1;
            $num_links = 2;

            if($this->validate_search()==TRUE){

                $polazna_id = $this->get_stanica_id($_GET['srch_polazak']);
                $dolazna_id = $this->get_stanica_id($_GET['srch_dolazak']);
                $datum = $_GET['datum'];

                $polasci_ids = array();
                $svi_polasci_ids = array();
                $danasnjidan = TRUE;

                $polasci_ids = $this->daj_spisak_polazaka_koji_ukljucuju($polazna_id, $dolazna_id, $datum, FALSE); 

                if(count($polasci_ids)==0){
                    $svi_polasci_ids = $this->daj_spisak_polazaka_koji_ukljucuju($polazna_id, $dolazna_id, $datum, TRUE); 
                    $danasnjidan = FALSE;   
                }


                if((count($polasci_ids)>0)||(count($svi_polasci_ids)>0)){

                    $count = count($polasci_ids);
                    if(count($polasci_ids)==0){

                        $count = count($svi_polasci_ids);  

                    }

                    $total_page = ceil($count/$limit);                    

                    $html = '';

                    $i = 0;
                    $j = $from;

                    if(count($polasci_ids)==0){
                        $p_ids = $svi_polasci_ids;    
                    }else{
                        $p_ids = $polasci_ids;
                    }


                    foreach($p_ids as $value){

                        if(($i<($from+$limit))&&($i>=$j)){

                            $html .= $this->load->view($view, array(
                            'polasci' => $this->listaj_podatke_stanice_sa_id_polaska($value),
                            'polazna_vrijeme' => $this->nadji_vrijeme_polaska_za_stanicu($value, $polazna_id),
                            'dolazna_vrijeme' => $this->nadji_vrijeme_polaska_za_stanicu($value, $dolazna_id)
                            ), TRUE);     

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

                    $trazenidatum = '';
                    
                    if($this->session->userdata('lang')=='me'){
                        $trazenidatum = $this->translateDays(date("l",strtotime($_GET['datum'])));
                    }else{
                        $trazenidatum = date("l",strtotime($_GET['datum']));
                    }
                    
                    
                    
                    echo $_GET['jsoncall'] . '(' . json_encode(array('success' => true, 'html'=> $html, 'paginator' => $paginator, 'count'=> $count, 'danasnjidan'=>$danasnjidan, 'trazenidatum' => $trazenidatum, 'trazenidan' => date("d.m.Y",strtotime($_GET['datum'])) )) . ');';

                }else{
                    $paginator = '';
                    echo $_GET['jsoncall'] . '(' . json_encode(array('success' => true, 'html'=> '<tr class="odd"><td colspan="9" style="text-align: center;"><b>No result</b></td></tr>.', 'paginator' => $paginator, 'count'=> $count)) . ');';   
                }



            } else{

                echo $_GET['jsoncall'] . '(' . json_encode(array('success' => false, 'html'=>$this->errors)) . ');';

            }

        }

        function validate_search() {

            $_POST = $_GET;

            $this->form_validation->set_rules('srch_polazak','<b>'.$this->lang->line('timetable-choosefrom').'</b>','required|provjeri_stanicu[srch_polazak]');

            $this->form_validation->set_rules('srch_dolazak','<b>'.$this->lang->line('timetable-chooseto').'</b>','required|provjeri_stanicu[srch_dolazak]');

            $this->form_validation->set_message('required', $this->lang->line('timetable-choose').' %s.');

            if($this->form_validation->run()== TRUE) {
                return TRUE;
            }else {
                $this->errors = validation_errors(' ', '<br />');
                return FALSE;
            }
        }

        function get_stanica_id($name){

            $res = $this->db->get_where('stanica'.$this->sufix, array('naziv' => $name))->row_array();

            return $res['id'];

        }

        function get_stanica_name($id){

            $res = $this->db->get_where('stanica'.$this->sufix, array('id' => $id))->row_array();

            return $res['naziv'];

        }

        function listaj_podatke_stanice_sa_id_polaska($polazak_id){

            /*$this->db->select('polazak.*, prevoznik.naziv as naziv_prevoznika, prevoznik.grad as grad_prevoznika', FALSE);

            $this->db->join('prevoznik', 'prevoznik.id = polazak.prevoznik_id ');

            $this->db->where(array('polazak.id' => $polazak_id));

            return $this->db->get('polazak')->result_array();*/

            return  $this->db->get_where($this->prefix.'olazak', array($this->prefix.'olazak.id' => $polazak_id))->result_array();

        }

        function nadji_vrijeme_polaska_za_stanicu($polazak_id, $stanica_id){

            $res = $this->db->get_where('stopstanica'.$this->sufix, array($this->prefix.'olazak_id' => $polazak_id))->result_array();

            $c = 0;
            $tot = count($res);
            foreach($res as $r){

                $c++;

                if ($r['stanica'.$this->sufix.'_id']==$stanica_id){

                    //return $this->get_stanica_name($r['stanica_id']);
                    if($tot == $c){
                        return $r['vrijemedolaska'];    
                    }else{
                        //return $c;
                        return $r['vrijemepolaska'];
                    }


                }
            }

        }

        function daj_spisak_polazaka_koji_ukljucuju($polazna_id, $dolazna_id, $datum, $svi_polasci=FALSE){  //return Array


            $lista_polazaka = array();


            /* Listaj sve polaske */

            $res1 = $this->db->order_by('vrijemepolaska', 'asc')->get($this->prefix.'olazak')->result_array();

            //echo 'DATUM:'.$datum.'<br />';
            $conv_date = strtotime($datum);

            foreach($res1 as $rs1){


                /************************************************************* 
                *  Za svaki polazak listaj stop stanice koje ukljucuju polaznu stanicu
                *************************************************************/

                $id_ili_false = $this->da_li_ima_ovaj_polazak_ovim_redosledom($polazna_id, $dolazna_id, $rs1['id']);


                /************************************************************* 
                *  Da li ima polazak određenim danom
                *************************************************************/

                if(($id_ili_false != FALSE)&&($rs1['tippolaska']=='o')){ 


                    $danasnjidan = $this->translateDays(date("l",$conv_date));
                    //$dan = 'Subota';
                    $dan = $danasnjidan;
                    //echo $dan;
                    $ima_li_odredjenim_danom = $this->da_li_ima_ovaj_polazak_ovim_danom($id_ili_false, $dan);
                    if($ima_li_odredjenim_danom==TRUE){
                        //$ima_li_odredjenim_danom = TRUE; 
                    }else{
                        if(!$svi_polasci){

                            $id_ili_false = FALSE; 

                        }

                    }

                }

                //$id_ili_false = FALSE;

                /************************************************************* 
                *  Da li ima periodicni polazak
                *************************************************************/

                if(($id_ili_false != FALSE)&&($rs1['tippolaska']=='p')){

                    $datum_poredjenja = '';
                    $danasnjidatum = date("M d Y", $conv_date);
                    $prvipolazak = date("M d Y", $rs1['prvipolazak']);

                    $ima_li_periodicni_polazak = $this->da_li_ima_ovaj_polazak_periodicno_na_svakih($rs1['periodicni'], $prvipolazak, $danasnjidatum, $rs1['id']);

                    if($ima_li_periodicni_polazak==TRUE){
                        //$ima_li_odredjenim_danom = TRUE; 
                    }else{
                        if(!$svi_polasci){

                            $id_ili_false = FALSE; 

                        } 
                    }

                }

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

            $this->db->where(array('stanica'.$this->sufix.'_id' => $polazna_id , $this->prefix.'olazak_id' => $polazak_id));
            $this->db->from('stopstanica'.$this->sufix);
            $cnt1 = $this->db->count_all_results();

            if($cnt1 ==0)   RETURN FALSE;


            /* Uzmi id stop-stanice */

            $res1 = $this->db->get_where('stopstanica'.$this->sufix, array('stanica'.$this->sufix.'_id' => $polazna_id , $this->prefix.'olazak_id' => $polazak_id))->row_array();
            $id1 = $res1['id'];


            /* 
            Provjeri da li ima dolazna stanica 
            u stop-stanicama 
            za dati polazak 
            */

            $this->db->where(array('stanica'.$this->sufix.'_id' => $dolazna_id , $this->prefix.'olazak_id' => $polazak_id));
            $this->db->from('stopstanica'.$this->sufix);
            $cnt2 = $this->db->count_all_results();

            if($cnt2 ==0)   RETURN FALSE;


            /* Uzmi id stop-stanice */

            $res2 = $this->db->get_where('stopstanica'.$this->sufix, array('stanica'.$this->sufix.'_id' => $dolazna_id , $this->prefix.'olazak_id' => $polazak_id))->row_array();
            $id2 = $res2['id'];


            if($id2 > $id1){

                /*$this->firephp->fb('stopstanicaid-1: '.$id1);
                $this->firephp->fb('stopstanicaid-2: '.$id2);
                $this->firephp->fb('id-polaska: '.$polazak_id);
                $this->firephp->fb('---------------------------');*/
                RETURN $polazak_id;

            } else RETURN FALSE;
        }

        function da_li_ima_ovaj_polazak_ovim_danom($id, $dan){

            $r = $this->db->get_where('danipolaska'.$this->sufix, array($this->prefix.'olazak_id' => $id, 'dan' => $dan))->result_array();
            if(count($r)>0){
                return TRUE;
            }else{
                RETURN FALSE;
            }

        }

        function da_li_ima_ovaj_polazak_periodicno_na_svakih($broj_ponavljanja, $prvi_polazak, $datum_poredjenja, $id){

            $html = ''; 
            /*$html .= 'id:'.$id."<br />";
            $html .= 'brojponavljanja:'.$broj_ponavljanja."<br />";
            $html .= 'prvipolazak:'.$prvi_polazak."<br />";
            $html .= 'datum_poredjenja:'.$datum_poredjenja."<br />";*/

            /************************************************************* 
            *  Da li je prvi polazak danas
            *************************************************************/

            $comp = strtotime($datum_poredjenja)-strtotime($prvi_polazak);

            if($comp == '0') {

                $n_dan = date("M d Y", strtotime($prvi_polazak));                    

                $html .= 'n_dan:'.$n_dan.'<br />';

                /*echo $html; 
                echo '*********************************<br />'; */

                return TRUE;

            }


            date_default_timezone_set ( 'Europe/Belgrade' );

            $dayCount = 0; 

            for($i=1; $i<=365; $i++){

                if($dayCount++ % $broj_ponavljanja == 1 ){

                    $n_dan = date("M d Y", strtotime($prvi_polazak.' +'.$i.' days'));                    

                    //$html .= 'n_dan:'.$n_dan.'<br />';

                    if($n_dan == $datum_poredjenja){

                        /*echo $html; 
                        echo '*********************************<br />';*/ 

                        return TRUE;

                    } 

                } 

            }

            return FALSE;

        }


        /*UNIT TESTING*/   

        function unit_func_search($polazna,$dolazna, $datum, $type){

            //tip polaska -> polazak ili dolazak
            $this->TYPE = $type;

            switch ($this->TYPE) {

                case 'polasci':

                    $this->sufix = '';
                    $this->prefix = 'p';

                    break;

                case 'dolasci':

                    $this->sufix = '_d';
                    $this->prefix = 'd';

                    break;
            }

            $polazna_id = $this->get_stanica_id($polazna);
            $dolazna_id = $this->get_stanica_id($dolazna);

            $polasci_ids = array();
            $svi_polasci_ids = array();

            $polasci_ids = $this->daj_spisak_polazaka_koji_ukljucuju($polazna_id, $dolazna_id, $datum, FALSE); 

            //echo 'polasci'.count($polasci_ids);

            if(count($polasci_ids)==0){
                $svi_polasci_ids = $this->daj_spisak_polazaka_koji_ukljucuju($polazna_id, $dolazna_id, $datum, TRUE);    
            }


            if((count($polasci_ids)>0)||(count($svi_polasci_ids)>0)){

                $count = count($polasci_ids);

                echo "TOTAL RECORDS:".$count;                 

                $style1 = 'style="font-size:11px"';
                $style2 = 'style="border-bottom:1px solid #DEDEDE;border-right:1px solid #DEDEDE; padding:4px"';

                echo '<table '.$style1.' cellpadding=0 cellspacing=0>';
                $p_ids = array();
                if(count($polasci_ids)==0){
                    $p_ids = $svi_polasci_ids;    
                }else{
                    $p_ids = $polasci_ids;
                }

                foreach($p_ids as $value){

                    $res =  $this->listaj_podatke_stanice_sa_id_polaska($value);

                    foreach($res as $row){

                        echo '<tr>';

                        echo '<td '.$style2.'>'.$row['id'].'</td>';
                        echo '<td '.$style2.'>'.$row['pocetnastanica'].'</td>';
                        echo '<td '.$style2.'>'.$row['zadnjastanica'].'</td>';
                        echo '<td '.$style2.'>'.$row['tippolaska'].'</td>';
                        echo '<td '.$style2.'>'.date('H:i', $row['vrijemepolaska']).'</td>';
                        echo '<td '.$style2.'>'.date('H:i', $row['vrijemedolaska']).'</td>';

                        echo '</tr>';

                    }


                }

                echo '</table>'; 

            }else{
                echo 'NO RESULTS';
            }
        }       

        function translateDays($dayEng){

            switch ( $dayEng ){
                case 'Monday': return 'Ponedjeljak'; break;
                case 'Tuesday': return 'Utorak'; break;
                case 'Wednesday': return 'Srijeda'; break;
                case 'Thursday': return 'Cetvrtak'; break;
                case 'Friday': return 'Petak'; break;
                case 'Saturday': return 'Subota'; break;
                case 'Sunday': return 'Nedjelja'; break;
            }

        }

        function loop_every_day(){

            date_default_timezone_set ( 'Europe/Belgrade' );

            $dayCount = 0;

            for($i=1; $i<=365; $i++){

                if ($dayCount++ % 2 == 1 ){
                    echo date("M d Y", strtotime('+'.$i.' days')).'<br>';    
                }   

            }

        }
    }
?>
